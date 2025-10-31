@extends('site.layouts.master')
@section('title')
    Giỏ hàng
@endsection

@section('css')



@endsection

@section('content')
    <main ng-controller="CartController">

        <!-- breadcrumb start -->
        <section class="pt-60p">
            <div class="section-pt">
                <div
                    class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $banner->image->path ?? '' }})">
                    <div class="container">
                        <div class="grid grid-cols-12 gap-30p relative xl:py-[130px] md:py-30 sm:py-25 py-20 z-[2]">
                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                                <h2 class="heading-2 text-w-neutral-1 mb-3">
                                    Giỏ hàng
                                </h2>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home-page') }}" class="breadcrumb-link">
                                           Trang chủ
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                            <span class="breadcrumb-icon">
                                                <i class="ti ti-chevrons-right"></i>
                                            </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="breadcrumb-current">Giỏ hàng</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="overlay-11"></div>
                </div>
            </div>
        </section>
        <!-- breadcrumb end -->

        <!-- product cart section start -->
        <section class="section-pb pt-15">
            <div class="container" ng-cloak>
                <div class="grid grid-cols-12 gap-30p" ng-if="total_qty > 0">
                    <div class="xxl:col-start-2 xxl:col-end-12 col-span-12">
                        <div class="overflow-x-auto scrollbar-sm w-full mb-5">
                            <table class="w-full text-left">
                                <thead>
                                <tr class="md:text-2xl sm:text-xl text-lg font-borda">
                                    <th class="min-w-[320px] w-full">Sản phẩm</th>
                                    <th class="3xl:min-w-[157px] min-w-[144px] p-16p">Đơn giá</th>
                                    <th class="3xl:min-w-[206px] min-w-[144px] p-16p text-center">Số lượng</th>
                                    <th class="3xl:min-w-[163px] min-w-[144px] p-16p text-center">Thành tiền</th>
                                    <th class="min-w-10 p-16p">Xóa</th>
                                </tr>
                                </thead>
                                <tbody
                                    class="*:bg-b-neutral-3 sm:divide-y-[20px] divide-y-[16px] divide-b-neutral-4">

                                <tr class="*:p-20p" ng-repeat="item in items">
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="shrink-0  rounded-12">
                                                <img class="size-[74px] rounded-12"
                                                     ng-src="<% (item && item.attributes && item.attributes.image) ? item.attributes.image : '' %>"
                                                     alt="<% item.name %>" />
                                            </div>
                                            <a href="#!"
                                               class="text-m-medium text-w-neutral-1 link-1">
                                                <% item.name %>

                                                <br ng-if="item.attributes && item.attributes.type && item.attributes.type.type_title">
                                                <small class="cart-variant text-muted"
                                                       ng-if="item.attributes && item.attributes.type && item.attributes.type.type_title">
                                                    Phân loại:
                                                    <span ng-bind="item.attributes.type.type_title"></span>
                                                </small>
                                                <br ng-if="item.attributes && item.attributes.attributes">
                                                <small class="cart-variant text-muted"
                                                       ng-if="item.attributes && item.attributes.attributes">
                                                    <span ng-bind="item.attributes.attributes"></span>
                                                </small>

                                            </a>

                                        </div>
                                    </td>
                                    <td>
                                                <span class="text-m-medium text-w-neutral-1">
                                                <% (+item.price > 0) ? ((+item.price) | number) + '₫' : 'Liên hệ' %>
                                                </span>
                                    </td>
                                    <td>
                                        <div class="flex-c">
                                            <div
                                                class="qtySelector inline-flex items-center justify-center border border-shap px-16p sm:py-3 py-2 rounded-12 w-[144px] *:h-full">
                                                <button class="decreaseQty flex-c size-12 icon-24"
                                                        ng-click="decrementQuantity(item); changeQty(item.quantity, item.id)"
                                                >
                                                    <i class="ti ti-minus"></i>
                                                </button>
                                                <input min="1" value="1" type="number" placeholder="1" value="<%item.quantity%>"
                                                       ng-model="item.quantity" ng-change="changeQty(item.quantity, item.id)"
                                                       class="qtyValue btn-xsm bg-transparent min-w-12 max-w-18 text-base text-w-neutral-1 text-center"
                                                       readonly="">
                                                <button class="increaseQty flex-c size-12 icon-24"
                                                        ng-click="incrementQuantity(item); changeQty(item.quantity, item.id)"
                                                >
                                                    <i class="ti ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                                <span class="text-m-medium text-w-neutral-1 text-center">
                                                     <% (+item.price > 0)
                                    ? (((+item.price) * (+item.quantity || 1)) | number) + '₫'
                                    : 'Liên hệ' %>
                                                </span>
                                    </td>
                                    <td>
                                        <button ng-click="removeItem(item.id)"
                                            class="icon-24 text-w-neutral-1 hover:text-danger text-center transition-1">
                                            <i class="ti ti-archive"></i>
                                        </button>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <div
                            class="bg-b-neutral-3 flex max-md:flex-wrap items-center justify-between gap-20p p-30p">
                            <div>
                                    <span class="heading-4 font-normal text-w-neutral-1 mb-3">
                                        Tổng tiền
                                    </span>
                                <p class="text-l-reguler text-w-neutral-4">
                                    Vui lòng chuyển sang trang thanh toán để hoàn tất
                                </p>
                            </div>
                            <div class="flex-y gap-30p">
                                <div>
                                    <span class="heading-4 text-w-neutral-1 font-normal inline"></span><span
                                        class="heading-4 text-w-neutral-1 font-normal inline"><% total | number%>₫</span>
                                </div>
                                <a href="{{ route('cart.checkout') }}" class="btn btn-md btn-primary rounded-12">
                                    Thanh toán
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <p ng-if="!total_qty || total_qty == 0">Chưa có sản phẩm nào trong giỏ hàng của bạn</p>


            </div>
        </section>
        <!-- product cart section end -->

    </main>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.cart-item').forEach(item => {
            item.addEventListener('click', e => {
                if (e.target.classList.contains('qty-btn')) {
                    const input = item.querySelector('.qty-input');
                    let val = parseInt(input.value, 10) || 1;
                    if (e.target.classList.contains('minus')) val = Math.max(1, val - 1);
                    else val++;
                    input.value = val;
                }
            });
            // khi gõ số trực tiếp
            item.querySelector('.qty-input').addEventListener('change', e => {
                if (e.target.value < 1) e.target.value = 1;
            });
        });
    </script>

    <script>
        app.controller('CartController', function ($scope, cartItemSync, $interval, $rootScope) {
            $scope.items = @json($cartCollection);
            $scope.total_qty = "{{ $total_qty }}";
            $scope.total = "{{$total_price}}";

            $scope.countItem = Object.keys($scope.items).length;

            $scope.changeQty = function (qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function (product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function (product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{ route('cart.update.item') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function (product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('cart.remove.item') }}",
                    data: {
                        product_id: product_id
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = Object.keys($scope.items).length;

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }
        });
    </script>

    <script>
        /**
         * Qty override: mỗi lần click chỉ +/- 1
         * Chặn handler cũ bằng capture (third arg = true)
         */
        (function () {
            // Helper: lấy input trong 1 qtySelector
            function getInputFrom(el) {
                const root = el.closest('.qtySelector');
                if (!root) return null;
                return root.querySelector('input.qtyValue');
            }

            // Tăng
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.increaseQty');
                if (!btn) return;
                e.preventDefault();
                e.stopPropagation();                // chặn bubble
                e.stopImmediatePropagation?.();     // chặn các handler khác cùng phần tử

                const input = getInputFrom(btn);
                if (!input) return;

                const min = parseInt(input.getAttribute('min') || '1', 10);
                const maxAttr = input.getAttribute('max');
                const max = maxAttr ? parseInt(maxAttr, 10) : Infinity;

                // Luôn bước = 1, bỏ qua step cũ nếu có
                let val = parseInt(input.value || '0', 10);
                if (isNaN(val) || val < min) val = min;

                val = Math.min(max, val + 1);
                input.value = String(val);
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }, true); // capture = true

            // Giảm
            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.decreaseQty');
                if (!btn) return;
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation?.();

                const input = getInputFrom(btn);
                if (!input) return;

                const min = parseInt(input.getAttribute('min') || '1', 10);

                let val = parseInt(input.value || '0', 10);
                if (isNaN(val) || val < min) val = min;

                val = Math.max(min, val - 1);
                input.value = String(val);
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }, true); // capture = true

            // (Tuỳ chọn) Nếu user gõ tay vào input, cũng ép về >= min và bước 1
            document.addEventListener('input', function (e) {
                const input = e.target.closest('.qtySelector .qtyValue');
                if (!input) return;

                const min = parseInt(input.getAttribute('min') || '1', 10);
                const maxAttr = input.getAttribute('max');
                const max = maxAttr ? parseInt(maxAttr, 10) : Infinity;

                let val = parseInt(input.value || '0', 10);
                if (isNaN(val)) val = min;
                val = Math.max(min, Math.min(max, val));
                input.value = String(val);
            }, true);
        })();
    </script>

@endpush
