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
            padding-bottom: 0;
        }

        .section-pt-1 {
            padding-top: 40px;
        }

        @media (max-width: 991.98px){  /* mobile */
            .banners-swiper-thumb { display:none !important; }
        }


    </style>



    <style>
        /* ----- Pagination Dots Style (ảnh mẫu) ----- */
        :root{
            --dot-size: 10px;          /* đường kính dot thường */
            --dot-gap: 12px;           /* khoảng cách giữa các dot */
            --dot-color: #b9c3cf;      /* xám nhạt của dot thường */
            --dot-active-bg: #ffa01a;  /* cam active */
            --dot-active-w: 28px;      /* chiều rộng "viên nang" active */
            --dot-active-h: 10px;      /* chiều cao "viên nang" active (bằng dot-size) */
        }

        .thumbs-carousel-container .js-hero-dots{
            position: absolute; left:0; right:0; bottom:0;
            display:flex; align-items:center; justify-content:center;
            padding: 8px 0;
            z-index: 20;
        }

        /* Dot mặc định */
        .thumbs-carousel-container .js-hero-dots .swiper-pagination-bullet{
            width: var(--dot-size);
            height: var(--dot-size);
            border-radius: 9999px;
            background: var(--dot-color);
            opacity: 1;
            margin: 0 calc(var(--dot-gap) / 2);
            /* bỏ mọi text/layout phụ từ browser */
            border: 0; outline: none; line-height: 0; padding: 0;
            /* transition mượt */
            transition: width .25s ease, background-color .2s ease, border-radius .2s ease;
        }

        /* Dot active -> viên nang cam */
        .thumbs-carousel-container .js-hero-dots .swiper-pagination-bullet-active,
        .thumbs-carousel-container .js-hero-dots .is-active{
            width: var(--dot-active-w);
            height: var(--dot-active-h);
            background: var(--dot-active-bg);
            border-radius: 9999px;
        }

        /* Giảm chuyển động nếu người dùng chọn reduce motion */
        @media (prefers-reduced-motion: reduce){
            .thumbs-carousel-container .js-hero-dots .swiper-pagination-bullet{
                transition: none;
            }
        }

        /* Tinh chỉnh cỡ trên mobile nhỏ nếu muốn */
        @media (max-width: 480px){
            :root{
                --dot-size: 8px;
                --dot-active-h: 8px;
                --dot-active-w: 24px;
                --dot-gap: 10px;
            }
        }
    </style>
@endsection

@section('content')

    <main>

        <!-- hero section start -->
        <section class="section-pt banner-home">
            <div class="container relative pt-[60px] ">
                <div class="thumbs-carousel-container" data-carousel-name="home-hero-slider" data-slides-per-view="4">
                    <div class="swiper js-hero-main">
                        <div class="swiper-wrapper">
                            @foreach($banners as $banner)
                                <div class="swiper-slide">
                                    <div class="w-full rounded-32 overflow-hidden relative">
                                     <a href="{{ $banner->link }}">
                                         <img
                                             class="w-full xxl:h-[630px] xl:h-[580px] lg:h-[520px] md:h-[420px] sm:h-[380px] h-[300px] object-cover"
                                             src="{{ $banner->image->path ?? '' }}" alt="product" />
                                     </a>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div
                        class="md:absolute lg:right-15 md:right-12 lg:bottom-20 md:bottom-12 z-[2] overflow-hidden pt-5 flex justify-end">
                        <div
                            class="js-hero-thumbs xxl:w-[500px] lg:w-[400px] md:w-[380px] xsm:w-[300px] w-full h-fit overflow-hidden">
                            <div class="swiper-wrapper pb-10 ">
{{--                                @foreach($banners as $banner)--}}
{{--                                    <div class="swiper-slide banners-swiper-thumb">--}}
{{--                                        <div class="overflow-hidden cursor-pointer rounded-20">--}}
{{--                                            <img--}}
{{--                                                class="xxl:w-[180px] xl:w-[140px] lg:w-[120px] md:w-25 w-20 xxl:h-[110px] xl:h-24 lg:h-20 md:h-18 h-16 hover:scale-110 hover:-rotate-6 object-cover transition-1"--}}
{{--                                                src="{{ $banner->image->path ?? '' }}" alt="product">--}}

{{--                                            <div class="overlay-1 rounded-20"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}

                            </div>
                            <div class="js-hero-dots swiper-pagination pagination-three flex-c gap-2.5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- hero section end -->


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

        <style>
            /* Biến slider này thành lưới 2 cột */
            .two-card-carousel .swiper-wrapper{
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 24px;                /* chỉnh khoảng cách giữa 2 ô nếu muốn */
                padding-bottom: 0 !important;
            }

            /* Để ô con co giãn tự nhiên như thẻ grid item */
            .two-card-carousel .swiper-slide{
                width: auto !important;
                height: auto;
                margin: 0 !important;
            }

            /* Ẩn thanh kéo & nút nếu không cần khi đã là grid */
            .two-card-carousel .swiper-scrollbar,
            .two-card-carousel .swp-navigation-one{ display: none !important; }

            /* (Tuỳ chọn) Mobile 1 cột cho dễ đọc */
            @media (max-width: 575.98px){
                .two-card-carousel .swiper-wrapper{
                    grid-template-columns: 1fr;
                }
            }

        </style>
        <!-- Popular Categories section start -->
        <section class="">
            <div class="container">
                <div class="mt-40p" >
                    <div class="swiper two-card-carousel" data-carousel-name="popular-categories" data-carousel-reverse="true">
                        <div class="swiper-wrapper pb-40p">
                            @foreach($categoriesParent as $categoryParent)
                                <div class="swiper-slide">
                                    <div
                                        class="w-full h-full bg-b-neutral-3 grid 4xl:grid-cols-2 grid-cols-1  items-center rounded-24 overflow-hidden group">
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

                                            </div>
                                            <a href="{{ route('front.getProductList', $categoryParent->slug) }}" class="btn btn-sm flex btn-neutral-2 group-hover:btn-primary">
                                               Tìm hiểu thêm
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



        @foreach($postsCategory as $postCategory)
            <section class="section-py section-news">
                <div class="container">
                    <div class="flex items-center justify-between flex-wrap gap-24p">
                        <h2 class="heading-2 text-w-neutral-1 text-split-left">
                           {{ $postCategory->name }}
                        </h2>
                        <a href="{{ route('front.blogs', $postCategory->slug) }}" class="btn btn-lg px-32p btn-neutral-2">
                            Xem tất cả
                        </a>
                    </div>
                    <div class="mt-40p">
                        <div class="swiper three-card-carousel" data-carousel-name="top-rated-stream">
                            <div class="swiper-wrapper ">

                                @foreach($postCategory->posts as $blog)
                                    <div class="swiper-slide">
                                        <div class="relative rounded-12 overflow-hidden w-full group">
                                            <img class="w-full h-[300px] group-hover:scale-110 object-cover transition-1"
                                                 src="{{ $blog->image->path ?? '' }}" alt="img"/>
                                            <div class="overlay-6x p-20p flex flex-col items-start justify-between">
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
        @endforeach


    </main>
@endsection

@push('scripts')
    <script>
        (function(){
            // tìm đúng container (nếu có nhiều, có thể lặp Array.from(...).forEach)
            var container = document.querySelector(".thumbs-carousel-container");
            if (!container || container.dataset.heroInited) return;
            container.dataset.heroInited = "1";

            var mainEl  = container.querySelector(".js-hero-main");
            var thumbsEl= container.querySelector(".js-hero-thumbs");
            var dotsEl  = container.querySelector(".js-hero-dots");
            if (!mainEl || !thumbsEl || !dotsEl) return;

            // nếu bị init ở đâu đó trước đó, hủy sạch
            function destroyIfAny(el){
                if (el && el.swiper && typeof el.swiper.destroy === 'function'){
                    try { el.swiper.destroy(true, true); } catch(e){}
                }
            }
            destroyIfAny(mainEl);
            destroyIfAny(thumbsEl);

            var total = mainEl.querySelectorAll(".swiper-wrapper .swiper-slide").length;
            var canAuto = total > 1;

            // Render DOTS thủ công để né pagination mặc định
            dotsEl.innerHTML = "";
            var dots = [];
            for (var i=0;i<total;i++){
                var b = document.createElement("button");
                b.type = "button";
                b.className = "swiper-pagination-bullet";
                b.dataset.index = String(i);
                b.addEventListener("click", function(){
                    var idx = parseInt(this.dataset.index,10) || 0;
                    if (mainEl.swiper) mainEl.swiper.slideTo(idx);
                }, true);
                dots.push(b);
                dotsEl.appendChild(b);
            }
            function setActiveDot(idx){
                for (var i=0;i<dots.length;i++){
                    if (i===idx) dots[i].classList.add("swiper-pagination-bullet-active","is-active");
                    else dots[i].classList.remove("swiper-pagination-bullet-active","is-active");
                }
            }

            // slidesPerView cho thumbs
            var spv = parseInt(container.getAttribute("data-slides-per-view"),10);
            if (isNaN(spv) || spv<1) spv = 4;

            // THUMBS (class mới)
            var thumbs = new Swiper(thumbsEl, {
                spaceBetween: 12,
                slidesPerView: spv,
                freeMode: true,
                watchSlidesProgress: true,
                watchSlidesVisibility: true,
                slideToClickedSlide: true,
                loop: false,
                watchOverflow: true,
                breakpoints:{768:{spaceBetween:16}, 992:{spaceBetween:20}},
            });

            // MAIN (class mới) — không dùng pagination module
            var main = new Swiper(mainEl, {
                spaceBetween: 10,
                slidesPerView: 1,
                loop: false,
                rewind: true,
                speed: 800,
                autoplay: canAuto ? {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                } : false,
                watchOverflow: true,
                observer: true,
                observeParents: true,
                thumbs: { swiper: thumbs },
                on: {
                    init: function(){
                        var i = typeof this.realIndex === "number" ? this.realIndex : (this.activeIndex||0);
                        setActiveDot(i);
                        scrollThumbIntoView(thumbs, i);
                    },
                    slideChange: function(){
                        var i = typeof this.realIndex === "number" ? this.realIndex : (this.activeIndex||0);
                        setActiveDot(i);
                        scrollThumbIntoView(thumbs, i);
                    },
                    transitionEnd: function(){
                        var i = typeof this.realIndex === "number" ? this.realIndex : (this.activeIndex||0);
                        setActiveDot(i);
                    }
                }
            });

            // ép thumbnail “theo kịp” slide đang active
            function scrollThumbIntoView(thumbSwiper, index){
                if (!thumbSwiper || typeof thumbSwiper.slideTo !== 'function') return;
                var perView = thumbSwiper.params.slidesPerView;
                var per = (typeof perView === 'number' && perView>0) ? perView : 4;
                var first = thumbSwiper.activeIndex;
                var last  = first + (per - 1);
                if (index < first) thumbSwiper.slideTo(index);
                else if (index > last) thumbSwiper.slideTo(Math.max(0, index - (per - 1)));
            }

            // đặt active dot ban đầu
            setTimeout(function(){
                var i = typeof main.realIndex === "number" ? main.realIndex : (main.activeIndex||0);
                setActiveDot(i);
            },0);

        })();
    </script>




@endpush
