@extends('site.layouts.master')
@section('title'){{ $category ? $category->name : "Sản phẩm" }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

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
{{--                <div--}}
{{--                    class="relative  bg-cover bg-no-repeat rounded-24 overflow-hidden category-hero" style="background-image: url({{ @$category->banner->path ?? '' }})">--}}
{{--                    <div class="container">--}}
{{--                        <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">--}}
{{--                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">--}}
{{--                                <h2 class="heading-2 text-w-neutral-1 mb-3">--}}
{{--                                    {{ @$category->name ?? 'Sản phẩm' }}--}}
{{--                                </h2>--}}
{{--                                <ul class="breadcrumb">--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                        <a href="{{ route('front.home-page') }}" class="breadcrumb-link">--}}
{{--                                          Trang chủ--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    @if($parentCategory)--}}
{{--                                        <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                        </li>--}}
{{--                                        <li class="breadcrumb-item">--}}
{{--                                            <a href="{{ route('front.getProductList', $parentCategory->slug) }}" class="breadcrumb-link">--}}
{{--                                                {{ $parentCategory->name }}--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                    </li>--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                        <span class="breadcrumb-current"> {{ @$category->name ?? 'Sản phẩm' }}</span>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="overlay-11"></div>--}}
{{--                </div>--}}


                <div class="category-hero relative rounded-24 overflow-hidden">
                    <picture>
                        <img
                            src="{{ @$category->banner->path ?? '' }}"
                            alt="{{ $category->name ?? '' }}"
                            class="hero-img"
                            loading="lazy"
                        >
                    </picture>

                    <div class="container hero-content">
                        <div class="grid grid-cols-12 gap-30p relative hero-content- z-[2]">
                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                                <h2 class="heading-2 text-w-neutral-1 mb-3">
                                    {{ @$category->name ?? 'Sản phẩm' }}
                                </h2>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home-page') }}" class="breadcrumb-link">
                                            Trang chủ
                                        </a>
                                    </li>
                                    @if($parentCategory)
                                        <li class="breadcrumb-item">
                                            <span class="breadcrumb-icon">
                                                <i class="ti ti-chevrons-right"></i>
                                            </span>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('front.getProductList', $parentCategory->slug) }}" class="breadcrumb-link">
                                                {{ $parentCategory->name }}
                                            </a>
                                        </li>
                                    @endif
                                    <li class="breadcrumb-item">
                                            <span class="breadcrumb-icon">
                                                <i class="ti ti-chevrons-right"></i>
                                            </span>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <span class="breadcrumb-current"> {{ @$category->name ?? 'Sản phẩm' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="overlay-11" aria-hidden="true"></div>
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
                                    @if($products->total() > 0)
                                        Hiển thị {{ number_format($products->firstItem()) }}–{{ number_format($products->lastItem()) }}
                                        trên tổng {{ number_format($products->total()) }}
                                        sản phẩm
                                    @else
                                        0 sản phẩm
                                    @endif
                                </h5>
                                <div class="flex items-center sm:justify-end max-sm:flex-wrap gap-24p">
                                    @php
                                        $currentSort = request('sort', 'price_desc');
                                    @endphp
                                    <div class="shrink-0 flex-y gap-28p">
                                <span class="text-m-medium text-w-neutral-1">
                                    Sắp xếp:
                                </span>
                                        <form class="select-2 shrink-0">
                                            <select class="select w-full sm:py-3 py-2 px-24p rounded-full !text-base" name="sort" onchange="this.form.submit()">
                                                <option value="date_desc" {{ $currentSort === 'date_desc' ? 'selected' : '' }}>Sản phẩm mới nhất</option>
                                                <option value="name_asc"  {{ $currentSort === 'name_asc'  ? 'selected' : '' }}>Tên A–Z</option>
                                                <option value="name_desc" {{ $currentSort === 'name_desc' ? 'selected' : '' }}>Tên Z–A</option>
                                                <option value="price_asc" {{ $currentSort === 'price_asc' ? 'selected' : '' }}>Giá thấp đến cao</option>
                                                <option value="price_desc"{{ $currentSort === 'price_desc'? 'selected' : '' }}>Giá cao xuống thấp</option>
                                            </select>
                                        </form>
                                    </div>
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


                        {{ $products->links('site.pagination.paginate2') }}


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
