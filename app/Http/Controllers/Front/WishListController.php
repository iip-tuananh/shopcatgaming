<?php

namespace App\Http\Controllers\Front;

use App\Mail\NewOrder;
use App\Model\Admin\Config;
use App\Model\Admin\Order;
use App\Model\Admin\OrderDetail;
use App\Model\Admin\Product;
use App\Model\Admin\Room;
use App\Model\Common\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Category;
use App\Model\Admin\Voucher;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Kjmtrue\VietnamZone\Models\Province;
use Vanthao03596\HCVN\Models\District;
use Vanthao03596\HCVN\Models\Province as Vanthao03596Province;
use Vanthao03596\HCVN\Models\Ward;

class WishListController extends Controller
{
    // trang giỏ hàng
    public function index()
    {
        $wishList = \Cart::session('wishlist');

        return view('site.wishlist');
    }

    public function addItem(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $wishlist  = \Cart::session('wishlist');

        if ($wishlist->get($product->id)) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm này đã được thêm vào danh sách của bạn',
                'wishlistItems' => $wishlist ->getContent(),
                'count' => $wishlist ->getContent()->count(),
            ]);
        }

        $wishlist->add([
            'id'         => $product->id,
            'name'       => $product->name,
            'price'       => $product->price ?? 1,
            'quantity'   => 1,
            'attributes' => [
                'image' => $product->image->path ?? '',
                'slug' => $product->slug,
            ],
        ]);

        return response()->json([
            'success'       => true,
            'message'       => 'Đã thêm vào danh sách yêu thích',
            'wishlistItems' => $wishlist->getContent(),
            'count'         => $wishlist->getContent()->count(),
        ]);
    }

    public function updateItem(Request $request)
    {
        \Cart::update($request->product_id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->qty
            ),
        ));

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity')]);

    }

    public function removeFromWishlist(Request $request)
    {
        \Cart::session('wishlist')->remove($request->productId);

        return response()->json([
            'success'       => true,
            'wishlistItems' => \Cart::session('wishlist')->getContent(),
            'count'         => \Cart::session('wishlist')->getContent()->count(),
        ]);
    }

    public function removeAll(Request $request)
    {
        \Cart::session('wishlist')->clear();

        return response()->json([
            'success'       => true,
            'wishlistItems' => [],      // đã trống
            'count'         => 0,
        ]);
    }


    public function removeItem(Request $request)
    {
        \Cart::remove($request->product_id);

        return \Response::json(['success' => true, 'items' => \Cart::getContent(), 'total' => \Cart::getTotal(),
            'count' => \Cart::getContent()->sum('quantity')]);
    }

    // trang thanh toán
    public function checkout(Request $request) {
        $cartCollection = \Cart::getContent();
        $total = \Cart::getTotal();
        $vouchers = Voucher::query()->where('status', 1)->where('quantity', '>', 0)->where('to_date', '>=', now())->orderBy('created_at', 'desc')->get();
        $provinces = Vanthao03596Province::all();
        $districts = District::all();
        $wards = Ward::all();

        return view('site.orders.checkout', compact('cartCollection', 'total', 'vouchers', 'provinces', 'districts', 'wards'));
    }

    // áp dụng mã giảm giá (boolean)
    public function applyVoucher(Request $request) {
        $voucher = Voucher::query()->where('code', $request->code)->first();
        $cartCollection = \Cart::getContent();
        $total_price = \Cart::getTotal();
        $total_qty = \Cart::getContent()->sum('quantity');
        // dd($total_price, $total_qty, $voucher);
        if(isset($voucher) && (($total_price >= $voucher->limit_bill_value && $voucher->limit_bill_value > 0) || ($voucher->limit_product_qty > 0 && $total_qty >= $voucher->limit_product_qty))) {
            return Response::json(['success' => true, 'voucher' => $voucher, 'message' => 'Áp dụng mã giảm giá thành công']);
        }
        return Response::json(['success' => false, 'message' => 'Không đủ điều kiện áp mã giảm giá']);
    }

    // submit đặt hàng
    public function checkoutSubmit(Request $request)
    {
        DB::beginTransaction();
        try {
            $translate = [
                'customer_name.required' => 'Vui lòng nhập họ tên',
                'customer_phone.required' => 'Vui lòng nhập số điện thoại',
                'customer_phone.regex' => 'Số điện thoại không đúng định dạng',
                'customer_address.required' => 'Vui lòng nhập địa chỉ',
                'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
                'customer_email.required' => 'Vui lòng nhập email',
            ];

            $validate = Validator::make(
                $request->all(),
                [
                    'customer_name' => 'required',
                    'customer_phone' => 'required|regex:/^(0)[0-9]{9,11}$/',
                    'customer_address' => 'required',
                    'customer_email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                    'customer_province' => 'required',
                    'customer_district' => 'required',
                    'customer_ward' => 'required',
                    'discount_code' => 'nullable',
                    'discount_value' => 'nullable',
                ],
                $translate
            );

            $json = new \stdClass();

            if ($validate->fails()) {
                $json->success = false;
                $json->errors = $validate->errors();
                $json->message = "Thao tác thất bại!";
                return Response::json($json);
            }

            $ward = Ward::query()->find($request->customer_ward);

            $customer_address = $request->customer_address . ', ' . $ward->path_with_type;

            $lastId = Order::query()->latest('id')->first()->id ?? 1;
            $total_price = \Cart::getTotal();

            $order = Order::query()->create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'customer_address' => $customer_address,
                'customer_required' => $request->customer_required,
                'discount_code' => $request->discount_code,
                'discount_value' => $request->discount_value,
                'total_before_discount' => $total_price,
                'total_after_discount' => $total_price - ($request->discount_value ?? 0),
                'code' => 'ORDER' . date('Ymd') . '-' . $lastId
            ]);

            foreach ($request->items as $item) {
                $detail = new OrderDetail();
                $detail->order_id = $order->id;
                $product_id = is_numeric($item['id']) ? $item['id'] : Product::query()->where('slug', $item['attributes']['slug'])->first()->id;
                $detail->product_id = $product_id;
                $detail->qty = $item['quantity'];
                $detail->price = $item['price'];
                $detail->type = $item['attributes']['attribute_name'] ?? null;
                $detail->save();
            }

            \Cart::clear();

            $voucher = Voucher::query()->where('code', $request->discount_code)->first();
            if ($voucher) {
                $voucher->quantity -= 1;
                $voucher->save();
            }

            session(['order_id' => $order->id]);

            $config = Config::query()->first();

            // gửi mail thông báo có đơn hàng mới cho admin
            $users = User::query()->where('status', 1)->get();
            // Mail::to('nguyentienvu4897@gmail.com')->send(new NewOrder($order, $config, 'admin'));


            if($users->count()) {
                foreach ($users as $user) {
                    Mail::to($user->email)->send(new NewOrder($order, $config, 'admin'));
                }
            }

            DB::commit();
            return Response::json(['success' => true, 'order_code' => $order->code, 'message' => 'Đặt hàng thành công']);
        } catch (\Exception $exception) {
            DB::rollBack();
            dd($exception->getMessage());
        }

    }

    // trả về trang đặt hàng thành công
    public function checkoutSuccess(Request $request)
    {
        if (!session()->has('order_id')) {
            return redirect()->route('front.home-page');
        }

        $orderId = session('order_id');
        $order = Order::query()->with('details', 'details.product', 'details.product.image')->find($orderId);

        session()->forget('order_id');
        return view('site.checkout_success', compact('order'));
    }

}
