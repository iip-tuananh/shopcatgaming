<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Order;
use Illuminate\Http\Request;
use App\Model\Admin\Order as ThisModel;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use \stdClass;

use Rap2hpoutre\FastExcel\FastExcel;
use PDF;
use App\Http\Controllers\Controller;
use \Carbon\Carbon;
use Illuminate\Validation\Rule;
use App\Helpers\FileHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\Common\Customer;

class OrderController extends Controller
{
    protected $view = 'admin.orders';
    protected $route = 'orders';

    public function index()
    {
        return view($this->view . '.index');
    }

    // Hàm lấy data cho bảng list
    public function searchData(Request $request)
    {
        $objects = ThisModel::searchByFilter($request);
        return Datatables::of($objects)
            ->addColumn('total_price', function ($object) {
                return number_format($object->total_price);
            })
            ->editColumn('code', function ($object) {
                return '<a href = "'.route('orders.show', $object->id).'" title = "Xem chi tiết">' . $object->code . '</a>';
            })
            ->editColumn('created_at', function ($object) {
                return formatDate($object->created_at);
            })
            ->addColumn('action', function ($object) {
                $result = '<div class="btn-group btn-action">
                <button class="btn btn-info btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class = "fa fa-cog"></i>
                </button>
                <div class="dropdown-menu">';
                $result = $result . ' <a href="" title="đổi trạng thái" class="dropdown-item update-status"><i class="fa fa-angle-right"></i>Đổi trạng thái</a>';
                $result = $result . ' <a href="'.route('orders.show', $object->id).'" title="đổi trạng thái" class="dropdown-item"><i class="fa fa-angle-right"></i>Xem chi tiết</a>';
                $result = $result . ' <a href="'.route('orders.delete', $object->id).'" title="xóa" class="dropdown-item confirm"><i class="fa fa-angle-right"></i>Xóa</a>';

                $result = $result . '</div></div>';
                return $result;
            })
            ->addIndexColumn()
            ->rawColumns(['code', 'action'])
            ->make(true);
    }

    public function show(Request $request, $id) {
        $order = Order::query()->with(['details.product'])->find($id);
//        $order->payment_method_name = Order::PAYMENT_METHODS[$order->payment_method];

        return view($this->view . '.show', compact('order'));
    }

    public function delete($id) {
        $order = Order::query()->where('id', $id)->first();
        $order->details()->delete();

        $order->delete();

        $message = array(
            "message" => "Thao tác thành công!",
            "alert-type" => "success"
        );

        return redirect()->route($this->route.'.index')->with($message);
    }

    public function updateStatus(Request $request)
    {
        $order = Order::query()->find($request->order_id);

        $order->status = $request->status;
        $order->save();

        return Response::json(['success' => true, 'message' => 'cập nhật trạng thái đơn hàng thành công']);
    }
}
