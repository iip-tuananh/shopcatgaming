@extends('site.layouts.master')
@section('title'){{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/site/assets/styles/product-card.css">

    <style>
        .banner-home {
            padding-top: 120px;
        }
        /* ===== Banner ngang cho từng category ===== */
        .cat-banner{
            position: relative;
            display: block;
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            background: linear-gradient(90deg, #f2f6ff 0%, #ffffff 50%, #eef4ff 100%);
            box-shadow: 0 10px 28px rgba(0,0,0,.08);
            margin: 6px 0 18px;             /* sát trên heading */
            isolation: isolate;              /* giữ z-index của góc trang trí */
        }

        /* Ảnh banner: fill khối, giữ tỉ lệ */
        .cat-banner .cb-img{
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
            /*aspect-ratio: 21 / 4;            !* ngang, giống mẫu *!*/
        }

        /* Fallback khi không có ảnh: tạo khối nội dung giữa */
        .cat-banner .cb-fallback{
            display: grid;
            place-items: center;
            text-align: center;
            min-height: clamp(140px, 20vw, 240px);
            padding: clamp(16px, 3vw, 32px);
            background:
                radial-gradient(600px 220px at 85% 20%, #2f80ed22 0%, transparent 60%),
                radial-gradient(420px 180px at 10% 90%, #2d9cdb30 0%, transparent 65%),
                linear-gradient(135deg, #e9f3ff 0%, #d6ebff 40%, #c3e2ff 100%);
        }
        .cat-banner .cb-title{
            font-size: clamp(20px, 3.4vw, 44px);
            font-weight: 800;
            letter-spacing: .5px;
            color:#0b1a38;
        }
        .cat-banner .cb-sub{
            display:block;
            margin-top: 6px;
            font-size: clamp(12px, 1.4vw, 16px);
            letter-spacing: .3px;
            color:#0b4bcc;
            font-weight: 700;
        }

        /* Góc tam giác xanh giống ảnh */
        .cat-banner .cb-corner{
            position:absolute;
            width: 0; height: 0;
            border-style: solid;
            z-index: 2;
        }
        .cat-banner .cb-left{
            left:0; top:0;
            border-width: 0 0 36px 36px;
            border-color: transparent transparent #1d4ed8 transparent;  /* #1d4ed8 = xanh */
        }
        .cat-banner .cb-right{
            right:0; top:0;
            border-width: 0 36px 36px 0;
            border-color: transparent #1d4ed8 transparent transparent;
        }

        /* ===== Responsive ===== */
        @media (max-width: 1024px){
            /*.cat-banner .cb-img{ aspect-ratio: 21 / 7; }*/
            .cat-banner .cb-left,
            .cat-banner .cb-right{ border-width: 0 0 28px 28px; }
        }
        @media (max-width: 768px){
            .banner-home {
                padding-top: 60px;
            }
            .cat-banner{ margin: 0 0 14px; border-radius: 10px; }
            /*.cat-banner .cb-img{ aspect-ratio: 16 / 9; }*/
            .cat-banner .cb-left,
            .cat-banner .cb-right{ border-width: 0 0 22px 22px; }
        }
        @media (max-width: 480px){
            /*.cat-banner .cb-img{ aspect-ratio: 4 / 3; } !* ảnh cao hơn trên mobile *!*/
            .cat-banner .cb-left,
            .cat-banner .cb-right{ border-width: 0 0 18px 18px; }
        }

        /* ===== Đảm bảo không bị CSS cũ can thiệp ===== */
        .section-pt .cat-banner img{ max-width:100% !important; height:auto !important; }

        .section-news {
            padding-top: 30px;
        }

        .section-pt-1 {
            padding-top: 20px;
        }
    </style>
@endsection

@section('content')

    <main>

        <!-- hero section start -->
        <section class="section-pt banner-home">
            <div class="container relative pt-[60px] ">
                <div class="thumbs-carousel-container" data-carousel-name="home-hero-slider" data-slides-per-view="3">
                    <div class="swiper thumbs-gallery-main">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                                <div class="swiper-slide">
                                    <div class="w-full rounded-32 overflow-hidden relative">
                                        <img
                                            class="w-full xxl:h-[630px] xl:h-[580px] lg:h-[520px] md:h-[420px] sm:h-[380px] h-[300px] object-cover"
                                            src="{{ $banner->image->path ?? '' }}" alt="product" />
                                        <div class="overlay-1"></div>
                                    </div>
                                </div>

                            @endforeach



                        </div>
                    </div>
                    <div
                        class="md:absolute lg:right-15 md:right-12 lg:bottom-15 md:bottom-12 z-[2] overflow-hidden pt-5 flex justify-end">
                        <div
                            class="thumbs-gallery xxl:w-[572px] lg:w-[400px] md:w-[380px] xsm:w-[300px] w-full h-fit overflow-hidden">
                            <div class="swiper-wrapper pb-10">
                                @foreach($banners as $banner)
                                    <div class="swiper-slide">
                                        <div class="overflow-hidden cursor-pointer rounded-20">
                                            <img
                                                class="xxl:w-[180px] xl:w-[140px] lg:w-[120px] md:w-25 w-20 xxl:h-[110px] xl:h-24 lg:h-20 md:h-18 h-16 hover:scale-110 hover:-rotate-6 object-cover transition-1"
                                                src="{{ $banner->image->path ?? '' }}" alt="product">
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="swiper-pagination pagination-three thumbs-gallery-pagination flex-c gap-2.5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section end -->


        <!-- Popular Categories section start -->
            <section class="">
                <div class="container">
                    <div class="mt-40p" data-aos="fade-left">
                        <div class="swiper two-card-carousel" data-carousel-name="popular-categories" data-carousel-reverse="true">
                            <div class="swiper-wrapper pb-40p">
                                @foreach($categoriesParent as $categoryParent)
                                <div class="swiper-slide">
                                    <div
                                        class="w-full h-full bg-b-neutral-3 grid 4xl:grid-cols-2 grid-cols-1 gap-y-30p items-center rounded-24 overflow-hidden group">
                                        <div class="overflow-hidden h-full">
                                            <img
                                                class="w-full xxl:h-full lg:h-[340px] sm:h-[320px] h-[300px] object-cover object-top group-hover:scale-110 transition-1"
                                                src="{{ $categoryParent->image->path ?? '' }}" alt="img" />
                                        </div>
                                        <div class="p-30p">
                                            <a href="{{ route('front.getProductList', $categoryParent->slug) }}" class="heading-3 text-w-neutral-1 link-1 line-clamp-1 mb-16p">{{ $categoryParent->name }}</a>

                                            <div class="pt-16p border-t border-w-neutral-4/20">
                                                <p class="text-base text-w-neutral-3">
                                                   {{ $categoryParent->short_des }}
                                                </p>
                                            </div>
                                            <div class="flex-y gap-2.5 my-24p">
                                                <span class="badge badge-secondary badge-circle size-3"></span>
                                                <p class="text-base text-neutral-100"><span>{{ $categoryParent->total_products }}</span> sản phẩm</p>
                                            </div>
                                            <a href="{{ route('front.getProductList', $categoryParent->slug) }}" class="btn btn-sm flex btn-neutral-2 group-hover:btn-primary">
                                                Xem tất cả
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach


                            </div>
                            <div class="flex items-center gap-28p">
                                <div class="swiper-navigation swp-navigation-one">
                                    <button type="button" class="navigation-btn-one popular-categories-carousel-prev">
                                        <i class="ti ti-chevron-left"></i>
                                    </button>
                                    <button type="button" class="navigation-btn-one popular-categories-carousel-next">
                                        <i class="ti ti-chevron-right"></i>
                                    </button>
                                </div>
                                <div class="swiper-scrollbar swiper-scrollbar-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


        <!-- Popular Categories section end -->

        <!-- Popular Games Two section start -->
        @foreach($categoriesSpecial as $categorySpecial)
            <section class="section-pt section-pt-1">
                <div class="container">
                    <div class="flex items-center justify-between flex-wrap gap-24p">
                        <h2 class="heading-2 text-w-neutral-1 text-split-left">
                            {{ $categorySpecial->name }}
                        </h2>
{{--                        <a href="games.html" class="btn btn-lg py-3 btn-neutral-2 shrink-0">--}}
{{--                            View All--}}
{{--                        </a>--}}
                    </div>
                    <div class="mt-40p" >
                        <div class="swiper four-card-carousel" data-carousel-name="popular-games-one">
                            <div class="swiper-wrapper pb-15">

                                @foreach($categorySpecial->products as $productSpec)
                                    <div class="swiper-slide">
                                        @include('site.partials.product_item', ['product' => $productSpec])
                                    </div>
                                @endforeach

                            </div>
                            <div
                                class="swiper-pagination pagination-one popular-games-one-carousel-pagination flex-c gap-2.5">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
        <!-- Popular Games Two section end -->


        @foreach($categories as $cate)
            <section class="section-pt section-pt-1">
                <div class="container">
                    {{-- BANNER NGANG CHO CATEGORY --}}
                    <a class="cat-banner" href="" aria-label="{{ $cate->name }}">
                        @php
                            $bannerUrl = @$cate->banner->path ?? null;
                        @endphp

                        @if($bannerUrl)
                            <picture>
                                <img class="cb-img" src="{{ $bannerUrl }}" alt="{{ $cate->name }}">
                            </picture>
                        @else
                            <div class="cb-fallback">
                                <strong class="cb-title">{{ strtoupper($cate->name) }}</strong>
                            </div>
                        @endif

                    </a>

                    {{-- HÀNG TIÊU ĐỀ + NÚT VIEW ALL --}}
                    <div class="flex items-center justify-between flex-wrap gap-24p">
                        <h2 class="heading-2 text-w-neutral-1 text-split-left">{{ $cate->name }}</h2>
                        <a href="{{ route('front.getProductList', $cate->slug ?? '') }}" class="btn btn-lg py-3 btn-neutral-2 shrink-0">
                           Xem tất cả
                        </a>
                    </div>



                    <div class="mt-40p">
                        <div class="swiper four-card-carousel" data-carousel-name="popular-games-one">
                            <div class="swiper-wrapper pb-15">
                                @foreach($cate->products as $productCate)
                                    <div class="swiper-slide">
                                        @include('site.partials.product_item', ['product' => $productCate])
                                    </div>
                                @endforeach
                            </div>
                            <div
                                class="swiper-pagination pagination-one popular-games-one-carousel-pagination flex-c gap-2.5">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach


        <section class="section-py section-news">
            <div class="container">
                <div class="flex items-center justify-between flex-wrap gap-24p">
                    <h2 class="heading-2 text-w-neutral-1 text-split-left">
                        Tin tức
                    </h2>
                    <a href="{{ route('front.blogs') }}" class="btn btn-lg px-32p btn-neutral-2">
                        Xem tất cả
                    </a>
                </div>
                <div class="mt-40p">
                    <div class="swiper three-card-carousel" data-carousel-name="top-rated-stream">
                        <div class="swiper-wrapper pb-15">

                          @foreach($blogs as $blog)
                                <div class="swiper-slide">
                                    <div class="relative rounded-12 overflow-hidden w-full group">
                                        <img class="w-full h-[300px] group-hover:scale-110 object-cover transition-1"
                                             src="{{ $blog->image->path ?? '' }}" alt="img"/>
                                        <div class="overlay-6 p-20p flex flex-col items-start justify-between">
                                            <div class="w-full">
                                                <a href="{{ route('front.blogDetail', $blog->slug) }}"
                                                   class="library-title heading-4 link-1 mb-2">
                                                  {{ $blog->name }}
                                                </a>
                                                <span class="text-l-regular text-w-neutral-2 mb-20p">{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</span>
                                                <div class="flex-y justify-between gap-16p">
                                                    <a href="{{ route('front.blogDetail', $blog->slug) }}"
                                                       class="btn btn-md btn-danger rounded-12">
                                                        Chi tiết
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach




                        </div>
                        <div
                            class="swiper-pagination pagination-one top-rated-stream-carousel-pagination flex-c gap-2.5">
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>
@endsection

@push('scripts')

@endpush
