@extends('site.layouts.master')
@section('title'){{ $product->name }}- {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/assets/styles/editor-content.css?v=5.0">
    <link rel="stylesheet" type="text/css" href="/site/assets/styles/product-card.css">

    <style>
        /* Vùng intro chung */
        .prod-intro{
            color:#fff;
            font-size:15px;
            line-height:1.65;
        }

        /* Khoảng cách đoạn */
        .prod-intro p{ margin:0 0 10px; }

        /* ===== LISTS ===== */
        .prod-intro ul,
        .prod-intro ol{
            margin:8px 0 10px;
            padding-left: 1.25em;                 /* lùi đầu dòng đẹp */
        }
        .prod-intro li{
            margin:6px 0;
        }
        .prod-intro ul{ list-style: disc; }
        .prod-intro ol{ list-style: decimal; }
        /* màu bullet */
        .prod-intro li::marker{ color:#fff; }

        /* Danh sách lồng nhau nhỏ lại chút */
        .prod-intro li ul,
        .prod-intro li ol{
            margin-top:4px; margin-bottom:6px;
        }

        /* ===== TABLE ===== */

        .prod-intro caption{
            caption-side: top;
            font-weight:700; margin-bottom:8px; text-align:left;
        }

        /* ===== IMAGES / FIGURE ===== */
        .prod-intro img{
            max-width:100% !important;
            height:auto !important;
            display:block; margin:10px auto;
        }
        .prod-intro figure{
            margin:12px 0; text-align:center;
        }
        .prod-intro figcaption{
            font-size:13px; color:#6b7280; margin-top:6px;
        }

        /* ===== MISC ===== */
        .prod-intro hr{
            border:0; border-top:1px dashed #e5e7eb; margin:14px 0;
        }
        .prod-intro a{ color:#fff; text-decoration:underline; }
        .prod-intro strong,
        .prod-intro b{ color:#fff; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 767.98px){
            .prod-intro{ font-size:14.5px; }
            .prod-intro th,
            .prod-intro td{ padding:8px 10px; }
            .prod-intro ul,
            .prod-intro ol{ padding-left: 1.1em; }
        }
        @media (max-width: 479.98px){
            .prod-intro{ font-size:14px; }
        }

    </style>

    <style>
        /* ===== Base ===== */
        .variant-select{ margin-top:14px; }
        .variant-select__label{ font-weight:500; margin-bottom:21px; color:#fff; font-size: 1.3rem}

        /* Layout: desktop tự co nhiều cột, mobile bắt buộc 2 cột */
        .variant-select__list{
            display:grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap:10px;
        }
        @media (max-width:576px){
            .variant-select__list{
                grid-template-columns: repeat(2, 1fr); /* đúng 2 phân loại / dòng */
            }
        }

        /* Ẩn radio, vẫn truy cập được bàn phím qua label */
        .variant-radio{
            position:absolute;
            opacity:0;
            width:0; height:0;
        }

        /* Pill */
        .variant-pill{
            position:relative;
            display:flex; flex-direction:column; justify-content:center;
            min-height:70px;
            padding:12px 14px;
            border:1px solid #e5e7eb;
            border-radius:12px;
            background:#fff;
            cursor:pointer;
            transition:box-shadow .15s ease, border-color .15s ease, transform .02s ease;
            outline:0;
        }
        .variant-pill:hover{ box-shadow:0 3px 10px rgba(0,0,0,.06); }
        .variant-radio:focus-visible + .variant-pill{ outline:2px solid #111; outline-offset:2px; }

        /* Trạng thái chọn: viền đen đậm */
        .variant-radio:checked + .variant-pill{
            border:5px solid #f29620; box-shadow:0 2px 0 rgba(0,0,0,.06) inset;
        }

        /* Texts */
        .v-title{ font-weight:600; line-height:1.15; color:#0f172a; margin-bottom:4px; }
        .v-price{ font-weight:600; color:#334155; }
        .v-base{ color:#94a3b8; margin-left:6px; font-weight:500; font-size:.95em; }

        /* Badge */
        .v-badge{
            position:absolute; right:10px; top:10px;
            background:#f9d977; color:#111827;
            font-weight:800; font-size:12px;
            padding:4px 8px; border-radius:999px; line-height:1;
            box-shadow:0 1px 0 rgba(0,0,0,.05) inset;
        }

    </style>

    <style>
        .prod-price-row{ display:flex; align-items:baseline; gap:10px; flex-wrap:wrap; }

        .prod-price{ font-size:28px; font-weight:800; color:#f29620; }
        .prod-price span{ font-size:.7em; margin-left:2px; font-weight:700; }

        .prod-price-old{
            font-size:16px; color:#9ca3af; text-decoration: line-through;
            font-weight:600;
        }
        .prod-price-old span{ font-size:.9em; margin-left:2px; }

        /* (Tuỳ chọn) nhãn % giảm */
        .prod-price-discount{
            background:#fee2e2; color:#b91c1c; border:1px solid #fecaca;
            padding:2px 8px; border-radius:999px; font-size:12px; font-weight:800;
        }

        /* Responsive */
        @media (max-width: 767.98px){
            .prod-price{ font-size:24px; }
            .prod-price-old{ font-size:15px; }
        }
    </style>

    <style>
        /* ============ SWATCH – dark ============ */
        .select-swatch{
            --bg: #0b0b0c;           /* nền tổng thể của site */
            --muted: #8b90a0;        /* chữ phụ */
            --text: #e9edf3;         /* chữ chính */
            --stroke: #2a2d36;       /* viền nhạt */
            --primary: #3b82f6;      /* nhấn */
            --success: #10b981;      /* dùng cho dot xanh lá */
            --danger: #ef4444;       /* dot đỏ */
            --warning: #f59e0b;      /* dot vàng */
            --rounded: 999px;        /* pill */
            --shadow: 0 6px 14px rgba(0,0,0,.35);
            color: var(--text);
        }

        .select-swatch .swatch{
            margin: 18px 0 14px;
        }

        .select-swatch .swatch .header{
            margin-bottom: 10px;
            font-weight: 500;
            letter-spacing: .2px;
            color: #fff;
            display: flex;
            gap: 8px;
            font-size: 1.06rem;
            align-items: baseline;
        }
        .select-swatch .swatch .header .value-roperties{
            color: var(--text);
            font-weight: 600;
        }

        /* Mỗi item */
        .select-swatch .swatch-element{
            display: inline-block;
            margin: 6px 8px 6px 0;
            position: relative;
        }

        .select-swatch .swatch-element input{
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        /* Nút label dạng pill */
        .select-swatch .swatch-element label{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            min-height: 38px;
            border: 2px solid var(--stroke);
            border-radius: var(--rounded);
            color: var(--text);
            background: linear-gradient(180deg, rgba(255,255,255,.02), rgba(255,255,255,0));
            backdrop-filter: blur(2px);
            cursor: pointer;
            user-select: none;
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease, transform .05s ease;
        }

        /* Hover / focus */
        .select-swatch .swatch-element label:hover{
            border-color: #3a3f4a;
            box-shadow: 0 0 0 3px rgba(59,130,246,.12);
        }
        .select-swatch .swatch-element input:focus-visible + label{
            outline: 2px solid rgba(59,130,246,.6);
            outline-offset: 2px;
        }

        /* Active (đang chọn) */
        .select-swatch .swatch-element input:checked + label{
            border-color: #f29620;
            background: linear-gradient(180deg, rgba(59,130,246,.12), rgba(59,130,246,.04));
            transform: translateY(-1px);
        }

        /* Disabled (nếu có thêm class .soldout hoặc .unavailable) */
        .select-swatch .swatch-element.unavailable label,
        .select-swatch .swatch-element.soldout label{
            color: #656b78;
            border-style: dashed;
            cursor: not-allowed;
            opacity: .7;
        }

        /* Dot màu nhỏ trước text – map theo tên phổ biến (tuỳ chọn) */
        .select-swatch .swatch-element label::before{
            content: "";
            width: 14px; height: 14px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.25);
            background: linear-gradient(180deg, rgba(255,255,255,.18), rgba(255,255,255,.02));
            display: none;           /* mặc định tắt, chỉ bật khi match các case dưới */
        }

        /* Bật dot khi là màu sắc quen thuộc (dựa theo title/giá trị) */

        /* bạn có thể thêm các case: Bạc, Tím, Xanh dương… */

        /* Nhỏ gọn trên mobile */
        @media (max-width: 575.98px){
            .select-swatch .swatch .header{ font-size: 14px; }
            .select-swatch .swatch-element label{ padding: 8px 12px; min-height: 34px; font-size: 14px; }
        }

    </style>

    <style>
        /* Swatch bắt buộc nhưng chưa chọn (auto highlight) */
        .swatch.is-required:has(input[type=radio]):not(:has(input[type=radio]:checked)){
            outline: 2px solid #ef4444;
            outline-offset: 2px;
            border-radius: 10px;
        }
    </style>

    <style>
        /* ===== Bundle styles (updated) ===== */
        .ak-bundle{background:#fff;border-radius:12px}
        .ak-bundle__head{
            display:flex;align-items:center;justify-content:space-between;
            padding:12px 16px;background:#FFF7D6;border-radius:12px;border:1px solid #F2E7A6
        }
        .ak-bundle__title{font-weight:700;font-size:18px;color:#232325;margin:0}
        .ak-bundle__more{font-size:14px;color:#2a73ff;text-decoration:none}

        .ak-bundle__wrap{position:relative;padding:14px 36px}
        .ak-bundle-swiper{overflow:hidden}

        /* Card */
        .ak-card{
            display:flex;gap:12px;align-items:center;
            border:1px solid #eee;border-radius:12px;padding:12px;background:#fff;
            text-decoration:none;min-height:110px;transition:box-shadow .2s
        }
        .ak-card:hover{box-shadow:0 6px 18px rgba(0,0,0,.07)}
        .ak-card__media{width:110px;flex:0 0 110px;display:flex;align-items:center;justify-content:center}
        .ak-card__media img{width:100%;height:auto;border-radius:8px;object-fit:cover}
        .ak-card__body{flex:1;min-width:0}
        .ak-card__title{
            margin:0 0 6px;color:#222;font-weight:600;line-height:1.35;
            /* hiển thị FULL, bỏ clamp/ellipsis */
            white-space:normal;overflow:visible;display:block
        }
        .ak-card__sub{margin:0 0 6px;color:#6b7280;font-size:13px}
        .ak-card__sale{margin:0 0 8px;color:#e11d48;font-weight:700}
        .ak-card__cta{
            display:inline-block;padding:6px 10px;background:#f5f7ff;border:1px solid #dfe6ff;
            border-radius:999px;font-size:13px;color:#1f3aff
        }

        /* Nav buttons */
        .ak-bundle__nav{
            position:absolute;top:50%;transform:translateY(-50%);
            width:36px;height:36px;border-radius:50%;border:1px solid #e5e7eb;background:#fff;
            box-shadow:0 2px 8px rgba(0,0,0,.08);cursor:pointer;z-index:2
        }
        .ak-bundle__prev{left:8px}
        .ak-bundle__next{right:8px}
        .ak-bundle__nav:after{
            content:"";display:block;width:8px;height:8px;border-top:2px solid #111;border-right:2px solid #111;margin:3px auto 0 auto
        }
        .ak-bundle__prev:after{transform:rotate(-135deg)}
        .ak-bundle__next:after{transform:rotate(45deg)}

        /* Responsive */
        @media (max-width:639.98px){
            .ak-bundle__wrap{padding:12px 28px}
            .ak-card__media{width:96px;flex-basis:96px}
            .ak-bundle__head{padding:10px 12px}
        }

    </style>

    <style>
        /* thu hẹp khoảng cách giữa các thumbnail */
        .thumbs-gallery .swiper-wrapper{ display:flex; gap:8px; }   /* mobile */
        @media (min-width:640px){ .thumbs-gallery .swiper-wrapper{ gap:10px; } }
        @media (min-width:992px){ .thumbs-gallery .swiper-wrapper{ gap:12px; } }

        /* Swiper hay set margin-right inline → reset để dùng gap */
        .thumbs-gallery .swiper-slide{ margin-right:0 !important; width:auto !important; }

        /* tránh padding thừa của container (nếu có) */
        .thumbs-gallery{ padding-left:0 !important; padding-right:0 !important; }
    </style>
@endsection


@section('content')
    <main ng-controller="productDetail">

        <!-- breadcrumb start -->
        <section class="pt-60p">
            <div class="section-pt">
{{--                <div--}}
{{--                    class="relative  bg-cover bg-no-repeat rounded-24 overflow-hidden category-hero" style="background-image: url({{ @$product->category->banner->path ?? '' }})">--}}
{{--                    <div class="container">--}}
{{--                        <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">--}}
{{--                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">--}}
{{--                                <h2 class="heading-2 text-w-neutral-1 mb-3">--}}

{{--                                </h2>--}}
{{--                                <ul class="breadcrumb">--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                        <a href="{{ route('front.home-page') }}" class="breadcrumb-link">--}}
{{--                                            Trang chủ--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                    </li>--}}
{{--                                    @if($product->category)--}}
{{--                                        <li class="breadcrumb-item">--}}
{{--                                            <a href="{{ route('front.getProductList', $product->category->slug ?? '') }}" class="breadcrumb-link">--}}
{{--                                                {{ $product->category->name ?? '' }}--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                        <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                        </li>--}}
{{--                                    @endif--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                        <span class="breadcrumb-current">{{ $product->name }}</span>--}}
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
                            src="{{ @$product->category->banner->path ?? '' }}"
                            alt="{{ $product->category->name ?? '' }}"
                            class="hero-img"
                            loading="lazy"
                        >
                    </picture>

                    <div class="container hero-content">
                        <div class="grid grid-cols-12 gap-30p relative hero-content- z-[2]">
                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                                <h2 class="heading-2 text-w-neutral-1 mb-3"></h2>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('front.home-page') }}" class="breadcrumb-link">Trang chủ</a>
                                    </li>
                                    <li class="breadcrumb-item"><span class="breadcrumb-icon"><i class="ti ti-chevrons-right"></i></span></li>

                                    @if($product->category)
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('front.getProductList', $product->category->slug ?? '') }}" class="breadcrumb-link">
                                                {{ $product->category->name ?? '' }}
                                            </a>
                                        </li>
                                        <li class="breadcrumb-item"><span class="breadcrumb-icon"><i class="ti ti-chevrons-right"></i></span></li>
                                    @endif

                                    <li class="breadcrumb-item"><span class="breadcrumb-current">{{ $product->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="overlay-11" aria-hidden="true"></div>
                </div>

            </div>
        </section>
        <!-- breadcrumb end -->

        <!-- shop details section start -->
        <section class="py-15 overflow-visible">
            <div class="container">
                <div class="grid grid-cols-12 gap-x-30p gap-y-10 mb-60p">
{{--                    <div class="xxl:col-span-6 xl:col-span-7 col-span-12 relative">--}}
{{--                        <div class="xl:sticky xl:top-30">--}}
{{--                            <div class="thumbs-carousel-container" data-carousel-name="product-slider"--}}
{{--                                 data-slides-per-view="4" data-carousel-direction="vertical">--}}
{{--                                <div class="swiper !flex md:gap-30p gap-2.5 xl:h-[514px] sm:h-[400px] h-[300px]">--}}
{{--                                    <div class="shrink-0 sm:w-[110px] w-20  thumbs-gallery">--}}
{{--                                        <div class="swiper-wrapper *:!h-fit" >--}}

{{--                                            <a class="swiper-slide"  >--}}
{{--                                                <div class="cursor-pointer  bg-b-neutral-3 rounded-12">--}}
{{--                                                    <img class="w-full  h-24  object-contain"--}}
{{--                                                         src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}">--}}
{{--                                                </div>--}}
{{--                                            </a>--}}

{{--                                            @foreach($product->galleries as $k => $gal)--}}
{{--                                                <a class="swiper-slide" >--}}
{{--                                                    <div class="cursor-pointer bg-b-neutral-3 rounded-12">--}}
{{--                                                        <img class="w-full  h-24  object-contain"--}}
{{--                                                             src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}">--}}
{{--                                                    </div>--}}
{{--                                                </a>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <div class="swiper thumbs-gallery-main">--}}
{{--                                        <div class="swiper-wrapper" id="lightgallery">--}}

{{--                                            <a class="swiper-slide" data-hash="0" href="{{ $product->image->path ?? '' }}">--}}
{{--                                                <div--}}
{{--                                                    class="w-full h-full flex-c   rounded-12 overflow-hidden" style="align-items: stretch">--}}
{{--                                                    <img class=" object-contain"--}}
{{--                                                         src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}" />--}}
{{--                                                </div>--}}
{{--                                            </a>--}}

{{--                                            @foreach($product->galleries as $gal)--}}
{{--                                                <a class="swiper-slide"  data-hash="{{ $k+1 }}" href="{{ $gal->image->path ?? '' }}">--}}
{{--                                                    <div--}}
{{--                                                        class="w-full h-full flex-c  rounded-12 overflow-hidden" style="align-items: stretch">--}}
{{--                                                        <img class="object-contain"--}}
{{--                                                             src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}" />--}}
{{--                                                    </div>--}}
{{--                                                </a>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


                    <div class="xxl:col-span-5 xl:col-span-6 col-span-12 relative">
                        <div class="xl:sticky xl:top-30">
                            <div class="thumbs-carousel-container" data-carousel-name="product-slider"
                                 data-slides-per-view="4" data-carousel-direction="horizontal"> <!-- đổi vertical -> horizontal -->
                                <!-- đổi layout: flex-col (thay vì row) -->
                                <div class="swiper !flex flex-col gap-3">  <!-- bỏ các class set chiều cao cố định -->

                                    <!-- MAIN ảnh lớn: order-1 -->
                                    <!-- MAIN ảnh lớn -->
                                    <div class="swiper thumbs-gallery-main order-1 w-full">
                                        <div class="swiper-wrapper" id="lightgallery">

                                            <a class="swiper-slide" data-hash="0" href="{{ $product->image->path ?? '' }}">
                                                <!-- Khung có tỉ lệ + padding để ảnh trông nhỏ lại -->
                                                <div class="w-full rounded-12 overflow-hidden bg-b-neutral-3
                  aspect-[4/3] sm:aspect-[16/12] lg:aspect-[16/10]
                  flex items-center justify-center
                  p-4 sm:p-6 lg:p-8">
                                                    <img
                                                        class="object-contain
                 max-w-[88%] sm:max-w-[84%] lg:max-w-[78%] xl:max-w-[60%]
                 max-h-full"
                                                        src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}" />
                                                </div>
                                            </a>

                                            @foreach($product->galleries as $k => $gal)
                                                <a class="swiper-slide" data-hash="{{ $k+1 }}" href="{{ $gal->image->path ?? '' }}">
                                                    <div class="w-full rounded-12 overflow-hidden bg-b-neutral-3
                    aspect-[4/3] sm:aspect-[16/12] lg:aspect-[16/10]
                    flex items-center justify-center
                    p-4 sm:p-6 lg:p-8">
                                                        <img
                                                            class="object-contain
                   max-w-[88%] sm:max-w-[84%] lg:max-w-[78%] xl:max-w-[72%]
                   max-h-full"
                                                            src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}" />
                                                    </div>
                                                </a>
                                            @endforeach

                                        </div>
                                    </div>


                                    <!-- THUMBNAILS: order-2 + full width + nằm ngang -->
                                    <div class="order-2 w-full thumbs-gallery">
                                        <div class="swiper-wrapper *:!h-fit">
                                            <a class="swiper-slide !w-auto">
                                                <div class="cursor-pointer bg-b-neutral-3 rounded-12">
                                                    <img class="w-full sm:h-[114px] h-24  object-contain"
                                                         src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}">
                                                </div>
                                            </a>
                                            @foreach($product->galleries as $k => $gal)
                                                <a class="swiper-slide !w-auto">
                                                    <div class="cursor-pointer bg-b-neutral-3 rounded-12">
                                                        <img class="w-full sm:h-[114px] h-24  object-contain"
                                                             src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}">
                                                    </div>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="xxl:col-span-7 xl:col-span-6 col-span-12">
                        <div>
                            <h2 class="heading-2 text-w-neutral-1 mb-16p">
                                {{ $product->name }}
                            </h2>
                            <div class="flex-y gap-2 mb-20p">
                                <div class="flex-c gap-1 icon-24 text-primary">
                                    <i class="ti ti-star-filled"></i>
                                    <i class="ti ti-star-filled"></i>
                                    <i class="ti ti-star-filled"></i>
                                    <i class="ti ti-star-filled"></i>
                                    <i class="ti ti-star-filled"></i>
                                </div>
                            </div>
                            @php
                                $types = $product->types ?? collect();
                                $hasTypes = $types->count() > 0;

                                if ($hasTypes) {
                                    $first = $types->first();
                                    $initPrice = (int) $first->price;
                                    $initBase  = (int) $first->base_price;
                                } else {
                                    $initPrice = (int) $product->price;
                                    $initBase  = (int) $product->base_price;
                                }

                            @endphp
                            <div class="flex-y gap-1 mb-20p">
                                <div id="mainPrice">
                                    @if($initPrice > 0)
                                        <span class="text-lead-medium text-w-neutral-1" id="mainPriceValue">
                                        {{ number_format($initPrice, 0, ',', '.') }} <span> VND</span>
                                        </span>

                                        @if($initBase > $initPrice)
                                            <span class="text-xl text-w-neutral-4 line-through" id="mainBaseValue">
                                        {{ number_format($initBase, 0, ',', '.') }} VND <span> VND</span>
                                        </span>
                                            <span class="prod-price-discount">
                                                             -{{ round(100 * (1 - $product->price / $initBase)) }}%
                                        </span>
                                        @endif
                                 @else
                                    <span class="text-lead-medium text-w-neutral-1" id="mainPriceValue">
                                     Liên hệ
                                    </span>
                                @endif
                                </div>
                            </div>

                            <div class="text-base text-w-neutral-4 mb-3 prod-intro rte">
                                {!! $product->intro !!}
                            </div>


                            <div class="select-swatch">
                                @foreach($product->attributes as $keyAttr => $attribute)
                                    <div class="swatch clearfix"
                                         data-option-index="{{ $keyAttr }}"
                                         @if(!empty($attribute['id'])) data-attr-id="{{ $attribute['id'] }}" @endif>
                                        <div class="header">
                                            {{ $attribute['name'] }}:
                                            <span class="value-roperties"></span>
                                        </div>
                                        <div class="header-none" style="display: none">
                                            {{ $attribute['name'] }}
                                        </div>

                                        @foreach($attribute['values'] as $keyVal => $val)
                                            @php $vid = $val['id']; $vlabel = $val['value']; @endphp

                                            <div class="swatch-element {{ $keyAttr }}-{{ $keyVal }} available"
                                                 data-id="{{ $vid }}" data-value="{{ $vlabel }}" title="{{ $vlabel }}">
                                                <input id="swatch-{{ $keyAttr }}-{{ $keyVal }}"
                                                       type="radio"
                                                       name="option-{{ !empty($attribute['id']) ? $attribute['id'] : $keyAttr }}"
                                                       value="{{ $vid }}" />
                                                <label for="swatch-{{ $keyAttr }}-{{ $keyVal }}">{{ $vlabel }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>




                            @if($hasTypes)
                                <fieldset id="variantSelect" class="variant-select">
                                    <legend class="variant-select__label">Tùy chọn</legend>

                                    <div class="variant-select__list" role="listbox" aria-label="Chọn phân loại">
                                        @foreach($types as $i => $t)
                                            @php
                                                $base = (int) ($t->base_price ?? 0);
                                                $price = (int) ($t->price ?? 0);
                                                $save = ($base > $price && $price > 0) ? max(0, round((1 - ($price/$base))*100)) : 0;
                                                $id = 'variant_'.$t->id ?? ('variant_'.$i);
                                            @endphp

                                            <input
                                                class="variant-radio"
                                                type="radio"
                                                name="selected_type"
                                                id="{{ $id }}"
                                                value="{{ $t->id ?? $i }}"
                                                data-title="{{ $t->title }}"
                                                data-price="{{ $price }}"
                                                data-base="{{ $base }}"
                                                {{ $i === 0 ? 'checked' : '' }}
                                            >
                                            <label class="variant-pill" for="{{ $id }}" role="option" aria-selected="{{ $i===0 ? 'true':'false' }}">
                                                @if($save > 0)
                                                    <span class="v-badge">Sale {{ $save }}%</span>
                                                @endif
                                                <div class="v-title">{{ $t->title }}</div>
                                                <div>
                                                    <span class="v-price">{{ number_format($price, 0, ',', '.') }}₫</span>
                                                    @if($base > $price)
                                                        <del class="v-base">{{ number_format($base, 0, ',', '.') }}₫</del>
                                                    @endif
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                            @endif


                            <div class="flex items-center flex-wrap gap-3 my-32p">
                                <div
                                    class="qtySelector inline-flex items-center justify-center border border-shap px-16p sm:py-3.5 py-2.5 rounded-12 w-[144px] *:h-full">
                                    <button class="decreaseQty flex-c size-12 icon-24">
                                        <i class="ti ti-minus"></i>
                                    </button>
                                    <input min="1" value="1" type="number" placeholder="1" name="quantity"
                                           class="qtyValue btn-xsm bg-transparent min-w-12 max-w-18 text-base text-w-neutral-1 text-center"
                                           readonly="">
                                    <button class="increaseQty flex-c size-12 icon-24">
                                        <i class="ti ti-plus"></i>
                                    </button>
                                </div>
                                <a href="#!" class="btn btn-lg-2 btn-primary rounded-12" ng-click="addToCart({{ $product->id }})">
                                    <i class="ti ti-shopping-cart-plus icon-24"></i>
                                    Thêm vào giỏ hàng
                                </a>
{{--                                                                <a href="shopping-cart.html"--}}
{{--                                                                   class="btn py-3 px-16p btn-primary rounded-12 icon-28">--}}
{{--                                                                    <i class="ti ti-heart"></i>--}}
{{--                                                                </a>--}}
                            </div>
                            <div class="flex-y gap-3.5 mb-16p">
                                    <span class="text-l-medium text-w-neutral-1">
                                        Danh mục:
                                    </span>
                                <span class="text-base text-w-neutral-4">
                                        {{ $product->category->name ?? '' }}
                                    </span>
                            </div>


                            @if($product->upsells->count())
                                <section class="ak-bundle mt-16">
                                    <div class="ak-bundle__head">
                                        <h3 class="ak-bundle__title">Sản phẩm mua kèm</h3>
                                    </div>

                                    <div class="ak-bundle__wrap">
                                        <div class="swiper ak-bundle-swiper">
                                            <div class="swiper-wrapper">

                                                @foreach($product->upsells as $pUp)
                                                    <div class="swiper-slide">
                                                        <a href="{{ route('front.getProductDetail', $pUp->slug) }}" class="ak-card">
                                                            <div class="ak-card__media">
                                                                <img src="{{ $pUp->image->path ?? '' }}" alt="">
                                                            </div>
                                                            <div class="ak-card__body">
                                                                <p class="ak-card__title">{{ $pUp->name }}</p>


                                                                <span class="ak-card__cta">
                                                                  Chi tiết
                                                                </span>

                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>

                                        <!-- Điều hướng -->
                                        <button type="button" class="ak-bundle__nav ak-bundle__prev" aria-label="Prev"></button>
                                        <button type="button" class="ak-bundle__nav ak-bundle__next" aria-label="Next"></button>
                                    </div>
                                </section>

                            @endif



                        </div>
                    </div>



{{--                    <div class="xxl:col-span-6 xl:col-span-7 col-span-12 relative">--}}
{{--                        <div class="xl:sticky xl:top-30">--}}
{{--                            <div class="thumbs-carousel-container" data-carousel-name="product-slider"--}}
{{--                                 data-slides-per-view="4" data-carousel-direction="horizontal"> <!-- đổi vertical -> horizontal -->--}}
{{--                                <!-- đổi layout: flex-col (thay vì row) -->--}}
{{--                                <div class="swiper !flex flex-col gap-3">  <!-- bỏ các class set chiều cao cố định -->--}}

{{--                                    <!-- MAIN ảnh lớn: order-1 -->--}}
{{--                                    <div class="swiper thumbs-gallery-main order-1 w-full">--}}
{{--                                        <div class="swiper-wrapper" id="lightgallery">--}}
{{--                                            <a class="swiper-slide" data-hash="0" href="{{ $product->image->path ?? '' }}">--}}
{{--                                                <div class="w-full rounded-12 overflow-hidden">--}}
{{--                                                    <img class="w-full h-auto object-contain"--}}
{{--                                                         src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}" />--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                            @foreach($product->galleries as $gal)--}}
{{--                                                <a class="swiper-slide" data-hash="{{ $k+1 }}" href="{{ $gal->image->path ?? '' }}">--}}
{{--                                                    <div class="w-full rounded-12 overflow-hidden">--}}
{{--                                                        <img class="w-full h-auto object-contain"--}}
{{--                                                             src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}" />--}}
{{--                                                    </div>--}}
{{--                                                </a>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                    <!-- THUMBNAILS: order-2 + full width + nằm ngang -->--}}
{{--                                    <div class="order-2 w-full thumbs-gallery">--}}
{{--                                        <div class="swiper-wrapper *:!h-fit">--}}
{{--                                            <a class="swiper-slide !w-auto">--}}
{{--                                                <div class="cursor-pointer bg-b-neutral-3 rounded-12">--}}
{{--                                                    <img class="w-[88px] h-[64px] sm:w-[100px] sm:h-[72px] object-contain"--}}
{{--                                                         src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}">--}}
{{--                                                </div>--}}
{{--                                            </a>--}}
{{--                                            @foreach($product->galleries as $k => $gal)--}}
{{--                                                <a class="swiper-slide !w-auto">--}}
{{--                                                    <div class="cursor-pointer bg-b-neutral-3 rounded-12">--}}
{{--                                                        <img class="w-[88px] h-[64px] sm:w-[100px] sm:h-[72px] object-contain"--}}
{{--                                                             src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}">--}}
{{--                                                    </div>--}}
{{--                                                </a>--}}
{{--                                            @endforeach--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}



                </div>
                <div x-data="{ activeTab: 1 }" class="max-w-[1230px] w-full">
                    <div class="flex items-center flex-wrap text-l-medium mb-6">
                        <button @click="activeTab = 1"
                                :class="activeTab === 1 ? 'bg-secondary text-b-neutral-4' : 'bg-b-neutral-3 text-w-neutral-4'"
                                class="px-60p py-16p">
                            Thông tin sản phẩm
                        </button>
                        <button @click="activeTab = 2"
                                :class="activeTab === 2 ? 'bg-secondary text-b-neutral-4' : 'bg-b-neutral-3 text-w-neutral-4'"
                                class="px-60p py-16p">
                            Hướng dẫn cài đặt
                        </button>
                    </div>

                    <div>
                        <div x-show="activeTab === 1" x-transition>
                            <div class="editor-content">
                                {!! normalizeResponsiveImages($product->body) !!}

                            </div>
                        </div>

                        <div x-show="activeTab === 2" x-transition>
                            <div class="editor-content">

                                {!! normalizeResponsiveImages($product->hdcd) !!}

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </section>
        <!-- shop details section end -->

        <!-- realated product section start -->
        <section class="section-pb">
            <div class="container">
                <div class="flex-y justify-between gap-24p mb-40p">
                    <h2 class="heading-2 text-w-neutral-1">
                        Sản phẩm liên quan
                    </h2>
                    <a href="{{ route('front.getProductList', $product->category->slug ?? '') }}" class="text-s-medium text-w-neutral-1 link-1">
                        Xem thêm
                        <i class="ti ti-arrow-right"></i>
                    </a>
                </div>
                <div class="grid xxl+:grid-cols-4 xl:grid-cols-3 sm:grid-cols-2 gap-30p mb-60p">
                    <!-- product card 1 -->
                    @foreach($productsLq as $productLq)
                        <div class="py-30p px-20p rounded-20 border border-shap group">
                            @include('site.partials.product_item', ['product' => $productLq])
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
        <!-- realated product section end -->


    </main>
@endsection

@push('scripts')
    <script>
        function getSelectedVariant(){
            const checked = document.querySelector('.variant-radio:checked');
            if(!checked) return null;

            let title = checked.getAttribute('data-title') || '';
            if(!title){
                const label = document.querySelector(`label[for="${checked.id}"] .v-title`);
                title = label ? (label.textContent || '').trim() : '';
            }

            return {
                id: checked.value,
                title: title,
                price: Number(checked.getAttribute('data-price') || 0),
                base_price: Number(checked.getAttribute('data-base') || 0),
            };
        }
    </script>

    <script>
        app.controller('productDetail', function ($rootScope, $scope, cartItemSync, $interval) {
            $scope.cart = cartItemSync;

            $scope.addToCart = function (productId, qty = null) {
                url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
                url = url.replace('productId', productId);

                if(! qty) {
                    var currentVal = parseInt(jQuery('input[name="quantity"]').val());
                } else {
                    var currentVal = parseInt(qty);
                }

                // mảng value attributes khi click chọn
                var selectedValueIds = [];
                var selectedValueLabels = [];
                var missing = [];

                jQuery('.swatch').each(function () {
                    var $sw = jQuery(this);
                    var $checked = $sw.find('input[type=radio]:checked');

                    if ($checked.length) {
                        // id (vid)
                        var vid = parseInt($checked.val(), 10);
                        selectedValueIds.push(vid);

                        // label (vlabel)
                        // ưu tiên lấy từ .swatch-element đang selected
                        var $el = $checked.closest('.swatch-element');
                        var vlabel = ($el.data('value') || '').toString().trim();

                        // nếu vì lý do nào đó không có data-value, fallback sang text của <label>
                        if (!vlabel) {
                            vlabel = ($el.find('label').text() || '').trim();
                        }

                        selectedValueLabels.push(vlabel);
                    } else {
                        var name = $sw.find('.header-none').text().trim();
                        missing.push(name);
                    }
                });

                if (missing.length) {
                    document.querySelector('.swatch.is-required:has(input[type=radio]):not(:has(:checked))')
                        ?.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    return void toastr.warning(
                        'Vui lòng chọn: ' + missing.map(n => `<b>${n}</b>`).join(', ')
                    );
                }



                const hasVariantInputs = document.querySelectorAll('.variant-radio').length > 0;
                const selectedVariant = hasVariantInputs ? getSelectedVariant() : null;

                if (hasVariantInputs && !selectedVariant) {
                    toastr.warning('Vui lòng chọn phân loại trước khi thêm giỏ hàng.');
                    return;
                }

                const payload = { qty: currentVal,attribute_value_ids:selectedValueIds,attribute_value_labels:selectedValueLabels  };

                // Nếu có phân loại, đính kèm thông tin type
                if (selectedVariant) {
                    payload.type_id = selectedVariant.id;
                    payload.type_title = selectedVariant.title;
                    payload.type_price = selectedVariant.price;
                    payload.type_base_price = selectedVariant.base_price;
                }


                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: payload,
                    success: function (response) {
                        if (response.success) {
                            $interval.cancel($rootScope.promise);
                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Đã thêm sản phẩm vào giỏ hàng!');
                        }
                    },
                    error: function () {
                        toastr.error('Có lỗi xảy ra. Vui lòng thử lại.');

                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.buyNow = function (productId) {
                url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
                url = url.replace('productId', productId);
                var currentVal = parseInt(jQuery('input[name="quantity"]').val());

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

                            window.location.href = "{{ route('cart.checkout') }}";

                        }
                    },
                    error: function () {
                        jQuery.toast('Thao tác thất bại !')
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.addToMyHeart = function (productId) {
                url = "{{route('love.add.item', ['productId' => 'productId'])}}";
                url = url.replace('productId', productId);
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'qty': 1
                    },
                    success: function (response) {
                        if (response.success) {
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function () {
                                loveItemSync.items = response.wishlistItems;
                                loveItemSync.count = response.count;
                            }, 1000);
                            theme.alert.new('Thêm vào danh sách yêu thích', 'Sản phẩm của bạn đã thêm vào danh sách yêu thích thành công.', 3000, 'alert-success');
                        } else {
                            theme.alert.new('Thêm vào danh sách yêu thích', 'Sản phẩm của bạn đã thêm vào danh sách yêu thích thành công.', 3000, 'alert-success');
                        }
                    },
                    error: function () {
                        theme.alert.new('Lỗi hệ thống', 'Có lỗi xảy ra. Vui lòng thử lại sau', 3000, 'alert-warning');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

        })

    </script>

    <script>
        $(document).ready(function () {
            $("#lightgallery").lightGallery({
                thumbnail: false
            });
            $("#videolary").lightGallery({
                thumbnail: false
            });
        });
    </script>

    <script>
        (function(){
            // helpers
            const fmt = n => (Number(n)||0).toLocaleString('vi-VN');
            const VND = ' VND';

            // elements sẵn có
            const priceBox = document.getElementById('mainPriceValue');   // .prod-price (đang chứa số + <span> VND</span>)
            if(!priceBox) return;

            // chèn/đảm bảo tồn tại element giá gốc & % giảm
            function ensureBaseEl(){
                let el = document.getElementById('mainBaseValue');
                if(!el){
                    el = document.createElement('span');
                    el.id = 'mainBaseValue';
                    el.className = 'prod-price-old';
                    priceBox.parentNode.insertBefore(el, priceBox.nextSibling);
                }
                return el;
            }
            function ensureDiscountEl(){
                let el = document.querySelector('#mainPrice .prod-price-discount');
                if(!el){
                    el = document.createElement('span');
                    el.className = 'prod-price-discount';
                    priceBox.parentNode.appendChild(el);
                }
                return el;
            }

            function updatePrice(price, base){
                const p = Number(price)||0;
                const b = Number(base)||0;

                if(p > 0){
                    priceBox.innerHTML = fmt(p) + '<span>'+VND+'</span>';
                    // base price
                    if(b > p){
                        const baseEl = ensureBaseEl();
                        baseEl.style.display = '';
                        baseEl.innerHTML = fmt(b) + '<span>'+VND+'</span>';

                        const disc = Math.max(0, Math.round(100*(1 - p/b)));
                        const discEl = ensureDiscountEl();
                        discEl.textContent = `-${disc}%`;
                        discEl.style.display = '';
                    }else{
                        const baseEl = document.getElementById('mainBaseValue');
                        if(baseEl){ baseEl.style.display = 'none'; baseEl.innerHTML = ''; }
                        const discEl = document.querySelector('#mainPrice .prod-price-discount');
                        if(discEl){ discEl.style.display = 'none'; discEl.textContent = ''; }
                    }
                }else{
                    priceBox.textContent = 'Liên hệ';
                    const baseEl = document.getElementById('mainBaseValue');
                    if(baseEl){ baseEl.style.display = 'none'; baseEl.innerHTML = ''; }
                    const discEl = document.querySelector('#mainPrice .prod-price-discount');
                    if(discEl){ discEl.style.display = 'none'; discEl.textContent = ''; }
                }
            }

            // lấy radios (có thể render động)
            const selector = '.variant-radio';
            function getCheckedRadio(){ return document.querySelector(selector+':checked'); }

            // init theo radio đang chọn hoặc radio đầu
            const initRadio = getCheckedRadio() || document.querySelector(selector);
            if(initRadio){
                updatePrice(initRadio.dataset.price, initRadio.dataset.base);
            }

            // lắng nghe thay đổi (uỷ quyền sự kiện – phòng trường hợp DOM thay đổi)
            document.addEventListener('change', function(e){
                const r = e.target.closest(selector);
                if(!r) return;
                updatePrice(r.dataset.price, r.dataset.base);
            });

        })();
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
    <script>
        document.addEventListener('change', function(e){
            const target = e.target;
            if(target.matches('.swatch-element input[type="radio"]')){
                const swatch = target.closest('.swatch');
                const val = target.value;
                const text = target.nextElementSibling?.textContent?.trim() || '';
                const out = swatch.querySelector('.value-roperties');
                if(out){ out.textContent = text; }
            }
        });


    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
        (function(){
            new Swiper('.ak-bundle-swiper', {
                spaceBetween: 12,
                // 1.05 trên mobile để lộ preview
                slidesPerView: 1.05,
                slidesPerGroup: 1,
                navigation: {
                    nextEl: '.ak-bundle__next',
                    prevEl: '.ak-bundle__prev'
                },
                // thêm chút "peek" ở đầu/cuối
                slidesOffsetBefore: 0,
                slidesOffsetAfter: 12,
                breakpoints: {
                    // từ 640px trở lên: luôn 2 item full + 1 chút preview
                    640:  { slidesPerView: 2.05, spaceBetween: 14 },
                    1024: { slidesPerView: 2.05, spaceBetween: 16 },
                    1280: { slidesPerView: 2.05, spaceBetween: 18 }
                }
            });
        })();
    </script>


@endpush
