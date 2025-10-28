@extends('site.layouts.master')
@section('title')
    Tìm kiếm - {{ $config->web_title }}
@endsection
@section('description')
    {{ strip_tags(html_entity_decode($config->introduction)) }}
@endsection
@section('image')
    {{@$config->image->path ?? ''}}
@endsection

@section('css')
    <style>
        /* ------- Layout & responsive ------- */
        .pl-section { margin: 24px 0; }
        .pl-toolbar{
            display:flex; align-items:center; justify-content:space-between;
            gap:12px; margin-bottom:16px; flex-wrap:wrap;
        }
        .pl-title{ margin:0; font-size:22px; font-weight:700; line-height:1.2; }
        .pl-meta{ color:#fff; font-size:15px; margin-left:8px; }
        .pl-toolbar-left{ display:flex; align-items:center; gap:8px; }
        .pl-toolbar-right{ margin-left:auto; display:flex; align-items:center; gap:8px; }
        .pl-sort-label{ font-size:18px; color:#fff; }
        .pl-select{
            padding:8px 10px; border:1px solid #e5e7eb; border-radius:8px; background:#000000;
            font-size:14px; min-width:190px;
        }

        /* Grid: mobile 2 cột, desktop 4 cột */
        .product-grid{
            display:grid; gap:20px;
            grid-template-columns:repeat(2, minmax(0, 1fr));
        }
        @media (min-width: 992px){
            .product-grid{ grid-template-columns:repeat(5, minmax(0, 1fr)); gap:22px; }
        }

    </style>

    <link rel="stylesheet" type="text/css" href="/site/assets/styles/product-card.css">

@endsection


@section('content')

    <main>

        <!-- breadcrumb start -->
        <section class="pt-60p">
            <div class="section-pt">
                <div
                    class="relative  bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $banner->image->path ?? '' }})">
                    <div class="container">
                        <div class="grid grid-cols-12 gap-30p relative xl:py-[130px] md:py-30 sm:py-25 py-20 z-[2]">
                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                                <h2 class="heading-2 text-w-neutral-1 mb-3">
                                  Tìm kiếm sản phẩm
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
                                        <span class="breadcrumb-current">Tìm kiếm sản phẩm </span>
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

        <!-- games section start -->
        <section class="section-pb overflow-visible">
            <div class="container">


                <div class="grid grid-cols-12 gap-x-30p gap-y-10">
                    <div class="xxl:col-span-12 xl:col-span-8 col-span-12 xl:order-1 order-2">

                        <!-- PRODUCT LISTING -->
                        <section class="pl-section">
                            <div class="flex-y justify-between flex-wrap gap-24p mb-[30px]">
                                <h5 class="heading-5 text-w-neutral-1">
                                    Tìm thấy {{ $products->count() }} sản phẩm phù hợp với từ khóa "{{ $keyword }}"
                                </h5>
                                <div class="flex items-center sm:justify-end max-sm:flex-wrap gap-24p">
                                    @php
                                        $currentSort = request('sort', 'date_desc');
                                    @endphp
                                </div>
                            </div>


                            <!-- Lưới sản phẩm -->
                            <div class="product-grid" id="productGrid">
                                <!-- ITEM -->
                                @foreach($products as $product)
                                    @include('site.partials.product_item', ['product' => $product])
                                @endforeach
                            </div>
                        </section>




                    </div>
                </div>
            </div>
        </section>
        <!-- games section end -->

    </main>

@endsection

@push('scripts')

    <script>
        app.controller('productList', function ($rootScope, $scope, cartItemSync, $interval) {
            $scope.cart = cartItemSync;


            $scope.addToCart = function (productId, qty = null) {
                url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
                url = url.replace('productId', productId);

                if(! qty) {
                    var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                } else {
                    var currentVal = parseInt(qty);
                }

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'qty': currentVal
                    },
                    success: function (response) {
                        if (response.success) {
                            $interval.cancel($rootScope.promise);
                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                        }

                        toastr.success('Đã thêm sản phẩm vào giỏ hàng!');

                    },
                    error: function () {
                        toastr.error('Có lỗi xảy ra. Vui lòng thử lại.');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }


        })

    </script>

@endpush
