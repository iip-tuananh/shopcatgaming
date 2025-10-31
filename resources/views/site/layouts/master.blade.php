<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('site.partials.head')
    @yield('css')
</head>

<body ng-app="App">

    <div class="preloader">
        <div class="cg-brand-loader" role="group" aria-label="CAT GAMING loading">
            <div class="cg-title">
                <span class="cg-shop">SHOP</span>
                <span class="cg-cat">CAT GAMING</span>
            </div>

            <div class="cg-pixel-bounce" aria-label="Đang tải" role="progressbar">
                <span></span><span></span><span></span><span></span><span></span><span></span>
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>

    </div>

    <!-- scroll to top button start -->
    <button class="scroll-to-top show" id="scrollToTop">
        <i class="ti ti-arrow-up"></i>
    </button>

    @include('site.partials.header')
    @include('site.partials.sidebar')

    <div class="min-h-screen lg:ml-[240px] lg:mr-[136px]">
        @yield('content')

        @include('site.partials.footer')
    </div>


    @include('site.partials.angular_mix')

<script src="/site/js/callbutton.js"></script>

<div class="hidden-xs">
    <div class="inner-fabs show">
        <a href="tel:{{ $config->hotline }}" class="fabs roundCool phone" title="Gọi hotline">
            <img class="inner-fab-icon" src="/site/imgs/phone.png" alt="Phone" loading="lazy">
        </a>

        <a target="_blank" href="https://zalo.me/{{ preg_replace('/\s+/', '', $config->zalo) }}" class="fabs roundCool zalo" title="Chat Zalo">
            <img class="inner-fab-icon" src="/site/imgs/zalo.png" alt="Zalo" loading="lazy">
        </a>

        <a target="_blank" href="{{ $config->facebook }}" class="fabs roundCool fb" title="Facebook">
            <img class="inner-fab-icon" src="/site/imgs/Facebook.png" alt="Facebook" loading="lazy">
        </a>
    </div>
</div>



    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
    </script>

    <script>
        app.controller('headerPartial', function ($rootScope, $scope, cartItemSync, $interval, $window) {
            $scope.cart = cartItemSync;

            $scope.incrementQuantity = function (product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function (product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            $scope.changeQty = function (qty, item) {
                updateCart(qty, item)
            }

            function updateCart(qty, item) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('cart.update.item')}}",
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        product_id: item.id,
                        variant_id: item.attributes.variant_id,
                        qty: qty
                    },
                    beforeSend: function() {
                        jQuery('.loading-spin').show();
                        // showOverlay();
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.countItem = response.count;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
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
                        jQuery('.loading-spin').hide();
                        // hideOverlay();
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function (product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{route('cart.remove.item')}}",
                    data: {
                        product_id: product_id
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = response.count;

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



            $scope.search = function () {
                if (!$scope.keywords || !$scope.keywords.trim()) {
                    alert('Vui lòng nhập từ khóa tìm kiếm!');
                    return;
                }

                // Xây URL cơ bản
                var url = '/tim-kiem?keywords=' + encodeURIComponent($scope.keywords.trim());

                // Điều hướng
                $window.location.href = url;
            };

        });


        app.factory('cartItemSync', function ($interval) {
            var cart = {items: null, total: null};

            cart.items = @json($cartItems);
            cart.count = {{$cartItems->sum('quantity')}};
            cart.total = {{$totalPriceCart}};

            return cart;
        });

    </script>


    @stack('scripts')


</body>

</html>
