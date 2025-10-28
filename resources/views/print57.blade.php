@extends('site.layouts.master')
@section('title'){{ $product->name }}- {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@6.8.4/swiper-bundle.min.css">
    <style>
        /* ==== Khối gallery chung ==== */
        .product-image-block { --gap:12px; --thumb:84px; }
        .product-image-block .gallery-top{
            border:1px solid #e5e7eb; border-radius:14px; overflow:hidden; background:#fff;
            box-shadow: 0 8px 24px rgba(0,0,0,.06);
        }

        /* Giữ tỉ lệ, căn giữa ảnh lớn */
        .product-image-block .gallery-top .swiper-slide{
            display:flex; align-items:center; justify-content:center;
            /*padding: var(--gap);*/
            background:#fff;
        }
        .product-image-block .gallery-top .swiper-slide img{
            width:100%;
            height:auto;                        /* giữ tỉ lệ tự nhiên */
            max-height: min(72vh, 530px);       /* không vượt quá chiều cao viewport */
            object-fit: contain;                /* không cắt ảnh */
            display:block;
        }

        /* ==== Thumbnails ==== */
        .product-image-block .gallery-thumbs{
            margin-top: 12px; position:relative;
        }
        .product-image-block .gallery-thumbs .swiper-slide{
            width: var(--thumb) !important;     /* kích thước ô thumb */
            height: var(--thumb);
            border:2px solid #e5e7eb; border-radius:10px; overflow:hidden;
            background:#fff;
            display:flex; align-items:center; justify-content:center;
            transition: box-shadow .2s, border-color .2s, transform .2s;
        }
        .product-image-block .gallery-thumbs .swiper-slide img{
            width:100%; height:100%; object-fit:cover; display:block;
        }
        .product-image-block .gallery-thumbs .swiper-slide:hover{
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0,0,0,.08);
        }

        /* Thumb đang chọn */
        .product-image-block .gallery-thumbs .swiper-slide-thumb-active{
            border-color:#f29620; box-shadow: 0 0 0 2px #2563eb33;
        }

        /* Nút điều hướng thumbnails */
        .product-image-block .gallery-thumbs .swiper-button-next,
        .product-image-block .gallery-thumbs .swiper-button-prev{
            width:36px; height:36px; border-radius:999px;
            background: #111827; color:#fff; opacity:.9;
            top: 50%; transform: translateY(-50%);
        }
        .product-image-block .gallery-thumbs .swiper-button-next:hover,
        .product-image-block .gallery-thumbs .swiper-button-prev:hover{
            background:#2563eb;
        }

        /* ==== Responsive ==== */
        @media (max-width: 991.98px){
            .product-image-block { --thumb:74px; }
        }
        @media (max-width: 575.98px){
            .product-image-block { --thumb:64px; --gap:10px; }
            /*.product-image-block .gallery-top .swiper-slide{ padding: var(--gap); }*/
            .product-image-block .gallery-top .swiper-slide img{ max-height: 58vh; }
        }
        @media (max-width: 360px){
            .product-image-block { --thumb:56px; }
        }
    </style>

    <style>
        /* ===== Product Info Card ===== */
        .prod-info-wrap{
            position:relative;
        }
        @media(min-width:1200px){
            .prod-info-wrap{ position:sticky; top:30px; }
        }

        /*.prod-info-card{*/
        /*    background:#fff;*/
        /*    border:1px solid #e5e7eb;*/
        /*    border-radius:14px;*/
        /*    padding:20px 20px 22px;*/
        /*    box-shadow:0 10px 30px rgba(0,0,0,.05);*/
        /*}*/

        .prod-title{
            font-size:20px; line-height:1.35; font-weight:700; color:#fff; margin:0 0 8px;
        }

        /* Giá */
        .prod-price-row{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; }
        .prod-price{
            font-size:28px; font-weight:800; color:#fff;
        }
        .prod-price span{ font-size:.7em; font-weight:700; margin-left:2px; }

        /* Đường kẻ chấm giống ảnh mẫu */
        .prod-sep.dotted{
            border:0; border-top:2px dotted #9ca3af; margin:12px 0 14px;
        }

        /* Meta */
        /* Layout hàng */
        .prod-actions{
            display:flex; align-items:center; gap:12px; flex-wrap:wrap;
            margin-top:14px;
        }

        /* Stepper */
        .qty-stepper{
            display:inline-flex; align-items:center;
            border:1px solid #e5e7eb; background:#fff; border-radius:999px;
            padding:0; overflow:hidden; height:40px;
            box-shadow:0 2px 8px rgba(0,0,0,.04) inset;
        }
        .qty-stepper .qty-btn{
            width:40px; height:40px; display:grid; place-items:center;
            background:#fff; border:0; cursor:pointer; font-size:20px; line-height:1;
            color:#111827;
        }
        .qty-stepper .qty-btn:active{ transform:scale(.96); }
        .qty-stepper .qty-btn.minus{ border-right:1px solid #e5e7eb; }
        .qty-stepper .qty-btn.plus { border-left:1px solid #e5e7eb; }

        .qty-stepper .qty-input{
            width:56px; height:40px; text-align:center; border:0; outline:0;
            font-weight:700; color:#111827; background:#fff; font-size:16px;
        }

        /* Nút Add to cart */
        .btn-addcart{
            height:44px; padding:0 20px; border-radius:999px;
            background:#e53935; border:1px solid #e53935; color:#fff;
            font-weight:800; letter-spacing:.3px; cursor:pointer;
            transition:transform .06s ease, background .2s ease, box-shadow .2s ease;
            box-shadow:0 6px 14px rgba(229,57,53,.24);
        }
        .btn-addcart:hover{ background:#d32f2f; }
        .btn-addcart:active{ transform: translateY(1px); }

        /* Responsive */
        @media (max-width: 575.98px){
            .prod-actions{ flex-direction:column; align-items:stretch; }
            .qty-stepper{ width:100%; justify-content:center; }
            .btn-addcart{ width:100%; }
        }

        /* Optional badge */
        .badge{
            display:inline-flex; align-items:center; padding:6px 10px; border-radius:999px;
            font-size:12px; font-weight:700;
        }
        .badge-green{ background:#e7f7ef; color:#0a7a45; border:1px solid #bdebd3; }
    </style>

    <style>
        /* Vùng intro chung */
        .prod-info-card .prod-intro{
            color:#fff;
            font-size:15px;
            line-height:1.65;
        }

        /* Khoảng cách đoạn */
        .prod-info-card .prod-intro p{ margin:0 0 10px; }

        /* ===== LISTS ===== */
        .prod-info-card .prod-intro ul,
        .prod-info-card .prod-intro ol{
            margin:8px 0 10px;
            padding-left: 1.25em;                 /* lùi đầu dòng đẹp */
        }
        .prod-info-card .prod-intro li{
            margin:6px 0;
        }
        .prod-info-card .prod-intro ul{ list-style: disc; }
        .prod-info-card .prod-intro ol{ list-style: decimal; }
        /* màu bullet */
        .prod-info-card .prod-intro li::marker{ color:#fff; }

        /* Danh sách lồng nhau nhỏ lại chút */
        .prod-info-card .prod-intro li ul,
        .prod-info-card .prod-intro li ol{
            margin-top:4px; margin-bottom:6px;
        }

        /* ===== TABLE ===== */

        .prod-info-card .prod-intro caption{
            caption-side: top;
            font-weight:700; margin-bottom:8px; text-align:left;
        }

        /* ===== IMAGES / FIGURE ===== */
        .prod-info-card .prod-intro img{
            max-width:100% !important;
            height:auto !important;
            display:block; margin:10px auto;
        }
        .prod-info-card .prod-intro figure{
            margin:12px 0; text-align:center;
        }
        .prod-info-card .prod-intro figcaption{
            font-size:13px; color:#6b7280; margin-top:6px;
        }

        /* ===== MISC ===== */
        .prod-info-card .prod-intro hr{
            border:0; border-top:1px dashed #e5e7eb; margin:14px 0;
        }
        .prod-info-card .prod-intro a{ color:#fff; text-decoration:underline; }
        .prod-info-card .prod-intro strong,
        .prod-info-card .prod-intro b{ color:#fff; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 767.98px){
            .prod-info-card .prod-intro{ font-size:14.5px; }
            .prod-info-card .prod-intro th,
            .prod-info-card .prod-intro td{ padding:8px 10px; }
            .prod-info-card .prod-intro ul,
            .prod-info-card .prod-intro ol{ padding-left: 1.1em; }
        }
        @media (max-width: 479.98px){
            .prod-info-card .prod-intro{ font-size:14px; }
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
        .v-title{ font-weight:800; line-height:1.15; color:#0f172a; margin-bottom:4px; }
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
@endsection


@section('content')
    <main>


        <section class="pt-60p overflow-visible">
            <div class="container">
                <h3 class="heading-3 text-w-neutral-1 mb-30p">
                    Overview
                </h3>
                <div class="grid grid-cols-12 gap-x-24p gap-y-10">
                    <div class="xxl:col-span-6 col-span-12">
                        <div class="product-image-block relative">

                            <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper" id="lightgallery">
                                    <a class="swiper-slide" data-hash="0" href="{{ $product->image->path ?? '' }}" title="Click để xem">
                                        <img src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}">
                                    </a>

                                    @foreach($product->galleries as $k => $gal)
                                        <a class="swiper-slide" data-hash="{{ $k+1 }}" href="{{ $gal->image->path ?? '' }}" title="Click để xem">
                                            <img src="{{ $gal->image->path ?? '' }}" alt="{{ $product->name }}">
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"><img src="{{ $product->image->path ?? '' }}" alt=""></div>
                                    @foreach($product->galleries as $gal)
                                        <div class="swiper-slide"><img src="{{ $gal->image->path ?? '' }}" alt=""></div>
                                    @endforeach
                                </div>

                            </div>


                        </div>

                    </div>


                    <div class="xxl:col-span-6 col-span-12 relative">
                        <div class="xxl:sticky xxl:top-30">
                            <div class="p-40p rounded-12 bg-b-neutral-3">
                                <div class="flex items-center gap-3 flex-wrap">
                                    <!-- PRODUCT INFO CARD -->
                                    <div class="prod-info-wrap">
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

                                        <aside class="prod-info-card">
                                            <h1 class="prod-title">{{ $product->name }}</h1>

                                            <div class="prod-price-row">
                                                @if($initPrice > 0)
                                                    <div id="mainPrice">
                                                        <div class="prod-price" id="mainPriceValue">
                                                            {{ number_format($initPrice, 0, ',', '.') }}<span> VND</span>
                                                        </div>

                                                        @if($initBase > $initPrice)
                                                            <span class="prod-price-old" aria-label="Giá gốc" id="mainBaseValue">
                                                                {{ number_format($initBase, 0, ',', '.') }}<span> VND</span>
                                                            </span>
                                                            <span class="prod-price-discount">
                                                             -{{ round(100 * (1 - $product->price / $initBase)) }}%
                                                      @endif
                                                        </span>
                                                    </div>

                                                @else
                                                    <div class="prod-price">
                                                        <span id="mainPriceValue">Liên hệ</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <hr class="prod-sep dotted">

                                            <!-- Danh sách mô tả ngắn (đổ từ DB/ckeditor cũng được) -->
                                            <div class="prod-intro rte">
                                                {!! $product->intro !!}
                                            </div>
                                            <!-- Thông tin nhanh (tùy chọn) -->

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

                                            <!-- Nút hành động (tuỳ bạn) -->
                                            <div class="prod-actions">
                                                <!-- Stepper số lượng -->
                                                <div class="qty-stepper" data-min="1" data-max="99">
                                                    <button class="qty-btn minus" type="button" aria-label="Giảm">−</button>
                                                    <input type="text" inputmode="numeric" pattern="[0-9]*"
                                                           class="qty-input" value="1" aria-label="Số lượng">
                                                    <button class="qty-btn plus" type="button" aria-label="Tăng">+</button>
                                                </div>

                                                <!-- Nút thêm giỏ -->
                                                <button class="btn-addcart" type="button">
                                                    THÊM VÀO GIỎ HÀNG
                                                </button>
                                            </div>
                                        </aside>
                                    </div>



                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- game details section end -->

        <!-- related games start -->
        <section class="section-py">
            <div class="container">
                <div class="flex items-center justify-between flex-wrap gap-24p mb-40p">
                    <h2 class="heading-2 text-w-neutral-1 text-split-left">
                        Related Games
                    </h2>
                    <form class="select-1 shrink-0">
                        <select class="select w-full sm:py-3 py-2 px-24p rounded-full">
                            <option value="popular">Popular</option>
                            <option value="new-releases">New Releases</option>
                            <option value="action">Action</option>
                            <option value="adventure">Adventure</option>
                            <option value="sports">Sports</option>
                        </select>
                    </form>
                </div>
                <div class="swiper four-card-carousel" data-carousel-name="related-games" data-aos="fade-up">
                    <div class="swiper-wrapper pb-15">
                        <div class="swiper-slide">
                            <div class="w-full bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12">
                                <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game14.png" alt="Power Play" />
                                    </div>
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game14.png" alt="Power Play" />
                                    </div>
                                </div>
                                <div>
                                    <a href="game-details.html"
                                       class="heading-4 text-w-neutral-1 link-1 line-clamp-1">
                                        Power Play
                                    </a>
                                    <p class="text-l-regular text-w-neutral-2">
                                        Animal Park Adventures
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="w-full bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12">
                                <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game15.png" alt="Gourmet Empire" />
                                    </div>
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game15.png" alt="Gourmet Empire" />
                                    </div>
                                </div>
                                <div>
                                    <a href="game-details.html"
                                       class="heading-4 text-w-neutral-1 link-1 line-clamp-1">
                                        Gourmet Empire
                                    </a>
                                    <p class="text-l-regular text-w-neutral-2">
                                        Food Tycoon
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="w-full bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12">
                                <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game16.png" alt="Flight Captain" />
                                    </div>
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game16.png" alt="Flight Captain" />
                                    </div>
                                </div>
                                <div>
                                    <a href="game-details.html"
                                       class="heading-4 text-w-neutral-1 link-1 line-clamp-1">
                                        Flight Captain
                                    </a>
                                    <p class="text-l-regular text-w-neutral-2">
                                        Sky Adventures
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="w-full bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12">
                                <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game17.png" alt="Animal Park Adventures" />
                                    </div>
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game17.png" alt="Animal Park Adventures" />
                                    </div>
                                </div>
                                <div>
                                    <a href="game-details.html"
                                       class="heading-4 text-w-neutral-1 link-1 line-clamp-1">
                                        Animal Park Adventures
                                    </a>
                                    <p class="text-l-regular text-w-neutral-2">
                                        Wildlife Journey
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="w-full bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12">
                                <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game18.png" alt="Battles Beyond the Stars" />
                                    </div>
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game18.png" alt="Battles Beyond the Stars" />
                                    </div>
                                </div>
                                <div>
                                    <a href="game-details.html"
                                       class="heading-4 text-w-neutral-1 link-1 line-clamp-1">
                                        Battles Beyond the Stars
                                    </a>
                                    <p class="text-l-regular text-w-neutral-2">
                                        Galactic War
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="w-full bg-b-neutral-3 px-20p pt-20p pb-32p rounded-12">
                                <div class="glitch-effect rounded-12 overflow-hidden mb-24p">
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game19.png" alt="Gridiron Glory" />
                                    </div>
                                    <div class="glitch-thumb">
                                        <img class="w-full md:h-[228px] h-[200px] object-cover"
                                             src="/site/assets/images/games/game19.png" alt="Gridiron Glory" />
                                    </div>
                                </div>
                                <div>
                                    <a href="game-details.html"
                                       class="heading-4 text-w-neutral-1 link-1 line-clamp-1">
                                        Gridiron Glory
                                    </a>
                                    <p class="text-l-regular text-w-neutral-2">
                                        Ultimate Football
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="swiper-pagination pagination-one related-games-carousel-pagination flex-c gap-2.5">
                    </div>
                </div>
            </div>
        </section>
        <!-- related trending end -->

    </main>
@endsection

@push('scripts')


    <script>
        $(document).ready(function () {
            $("#lightgallery").lightGallery({
                thumbnail: false
            });
            $("#videolary").lightGallery({
                thumbnail: false
            });
        });

        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 5,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            breakpoints: {
                0:   { slidesPerView: 3, spaceBetween: 8 },
                480: { slidesPerView: 4, spaceBetween: 8 },
                768: { slidesPerView: 5, spaceBetween: 10 }
            },
            navigation: {
                nextEl: '.gallery-thumbs .swiper-button-next',
                prevEl: '.gallery-thumbs .swiper-button-prev'
            }
        });

        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            slidesPerView: 1,
            effect: 'slide',
            lazy: { loadPrevNext: true },
            thumbs: { swiper: galleryThumbs }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.qty-stepper').forEach(function(box){
                const input = box.querySelector('.qty-input');
                const min = parseInt(box.dataset.min || '1', 10);
                const max = parseInt(box.dataset.max || '9999', 10);

                const clamp = v => Math.max(min, Math.min(max, v));

                box.querySelector('.minus').addEventListener('click', () => {
                    input.value = clamp((parseInt(input.value||'0',10) || min) - 1);
                    input.dispatchEvent(new Event('change'));
                });
                box.querySelector('.plus').addEventListener('click', () => {
                    input.value = clamp((parseInt(input.value||'0',10) || min) + 1);
                    input.dispatchEvent(new Event('change'));
                });

                // Chỉ cho số, tự sửa khi blur
                input.addEventListener('input', () => {
                    input.value = input.value.replace(/[^\d]/g,'').slice(0,4);
                });
                input.addEventListener('blur', () => {
                    input.value = clamp(parseInt(input.value||min,10) || min);
                    input.dispatchEvent(new Event('change'));
                });
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

@endpush
