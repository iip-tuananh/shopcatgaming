<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title')</title>
<link href="/site/assets/styles/app.css?v=2.0" rel="stylesheet">
<script defer src="/site/assets/js/app.js"></script>
<link rel='stylesheet' id='xts-google-fonts-css' href='https://fonts.googleapis.com/css?family=Montserrat%3A400%2C600%2C500%2C700&#038;ver=8.2.7' type='text/css' media='all' />

<link rel="preload" as="script" href="/site/js/jquery.js?1758009149569" />
<script src="/site/js/jquery.js?1758009149569" type="text/javascript"></script>

<script src="/site/assets/js/swiper.js?1758009149569" type="text/javascript"></script>

<link href="/site/assets/styles/picbox.scss.css?1758009149569" rel="stylesheet" type="text/css" media="all" />
<script src="/site/assets/js/picbox.js?1758009149569" type="text/javascript"></script>

<link rel="shortcut icon" href="{{@$config->favicon->path ?? ''}}" type="image/x-icon">
<link rel="apple-touch-icon" sizes="180x180" href="{{@$config->favicon->path ?? ''}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{@$config->favicon->path ?? ''}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{@$config->favicon->path ?? ''}}">
<meta name="application-name" content="{{ $config->web_title }}" />
<meta name="generator" content="@yield('title')" />

<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title')">
<meta property="og:description" content="@yield('description')">
<meta property="og:image" content="@yield('image')">
<meta property="og:site_name" content="{{ url()->current() }}">
<meta property="og:image:alt" content="{{ $config->web_title }}">
<meta itemprop="description" content="@yield('description')">
<meta itemprop="image" content="@yield('image')">
<meta itemprop="url" content="{{ url()->current() }}">
<meta property="og:type" content="website" />
<meta property="og:locale" content="vi_VN" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ url()->current() }}" />
<link rel="stylesheet" href="/site/css/callbutton.css?v=12">

<style>
    /* Ẩn mọi phần tử có ng-cloak cho tới khi Angular biên dịch xong */
    [ng-cloak], [data-ng-cloak], [x-ng-cloak],
    .ng-cloak, .data-ng-cloak, .x-ng-cloak {
        display: none !important;
    }
</style>

<style>
    /* -------- Palette (khớp logo) -------- */
    :root{
        --cg-primary:#F4A01E;   /* cam chủ đạo */
        --cg-light:#FFD166;     /* vàng highlight */
        --cg-dark:#0E0F12;      /* dùng cho viền chữ */
        --cg-glow:rgba(244,160,30,.45);
    }

    /* ------- Khối brand + loader ------- */
    .cg-brand-loader{
        display:inline-flex;           /* để khối gọn như logo */
        flex-direction:column;
        gap:10px;
    }

    /* Tiêu đề */
    .cg-title{
        line-height:1;
        user-select:none;
    }
    .cg-title .cg-shop{
        display:block;
        font-size:12px;
        letter-spacing:.25em;
        color:#9aa0a6;                 /* chữ “SHOP” xám nhạt như caption */
    }
    .cg-title .cg-cat{
        display:block;
        margin-top:2px;
        font-weight:800;
        text-transform:uppercase;
        letter-spacing:.08em;
        font-size:28px;
        color:var(--cg-primary);
        /* tạo cảm giác viền pixel đậm như logo */
        text-shadow:
            0 1px 0 var(--cg-dark),
            1px 0 0 var(--cg-dark),
            0 -1px 0 var(--cg-dark),
            -1px 0 0 var(--cg-dark);
    }

    /* ------- Pixel bounce loader (không có nền bao quanh) ------- */
    .cg-pixel-bounce{
        display:flex;
        align-items:flex-end;
        gap:6px;
        height:36px;                     /* chiều cao không gian để pixel “nhảy” */
        filter:drop-shadow(0 0 8px var(--cg-glow));
    }

    .cg-pixel-bounce > span{
        width:16px; height:16px;
        background:transparent;
        border:3px solid var(--cg-primary);
        border-radius:4px;
        box-sizing:border-box;
        opacity:.35;
        transform:translateY(0);
        animation:cg-bounce .9s steps(6) infinite;
    }

    /* chạy lần lượt trái → phải */
    .cg-pixel-bounce > span:nth-child(1)  { animation-delay:0.00s }
    .cg-pixel-bounce > span:nth-child(2)  { animation-delay:0.08s }
    .cg-pixel-bounce > span:nth-child(3)  { animation-delay:0.16s }
    .cg-pixel-bounce > span:nth-child(4)  { animation-delay:0.24s }
    .cg-pixel-bounce > span:nth-child(5)  { animation-delay:0.32s }
    .cg-pixel-bounce > span:nth-child(6)  { animation-delay:0.40s }
    .cg-pixel-bounce > span:nth-child(7)  { animation-delay:0.48s }
    .cg-pixel-bounce > span:nth-child(8)  { animation-delay:0.56s }
    .cg-pixel-bounce > span:nth-child(9)  { animation-delay:0.64s }
    .cg-pixel-bounce > span:nth-child(10) { animation-delay:0.72s }
    .cg-pixel-bounce > span:nth-child(11) { animation-delay:0.80s }
    .cg-pixel-bounce > span:nth-child(12) { animation-delay:0.88s }

    /* keyframes nhảy lên–xuống + đổi màu vàng/cam */
    @keyframes cg-bounce{
        0%,100% { transform:translateY(0);     background:transparent;  border-color:var(--cg-primary); opacity:.35 }
        40%     { transform:translateY(-14px); background:var(--cg-light); border-color:var(--cg-light); opacity:1 }
        65%     { transform:translateY(-6px);  background:var(--cg-primary); border-color:var(--cg-primary); opacity:.9 }
    }

    /* Responsive nhỏ lại ở màn hẹp */
    @media (max-width:420px){
        .cg-title .cg-cat{ font-size:22px }
        .cg-pixel-bounce{ gap:5px; height:28px }
        .cg-pixel-bounce > span{ width:12px; height:12px; border-width:2px; border-radius:3px }
        @keyframes cg-bounce{
            0%,100% { transform:translateY(0) }
            40%     { transform:translateY(-10px) }
            65%     { transform:translateY(-4px) }
        }
    }

    /* Trợ năng: nếu người dùng giảm chuyển động */
    @media (prefers-reduced-motion: reduce){
        .cg-pixel-bounce > span{ animation-duration:0.01ms; animation-iteration-count:1 }
    }

</style>





<style>
    /* Desktop: banner full khối */
    @media (min-width: 993px){
        /* Khung hero dùng ảnh nền bằng <img> */
        .category-hero{ position:relative; }

        /* Ảnh nền */
        .category-hero .hero-img{
            position:absolute;
            inset:0;
            width:100%;
            height:100%;
            object-position:center top;
            z-index:0;
        }

        /* Lớp phủ (nếu bạn đang dùng để tạo gradient/mờ chữ) */
        .category-hero .overlay-11{
            position:absolute;
            inset:0;
            z-index:1;            /* nằm trên ảnh, dưới content */
            pointer-events:none;
            /* ví dụ: background: linear-gradient(to top, rgba(0,0,0,.35), rgba(0,0,0,0)); */
        }

        /* Nội dung luôn nằm phía trên ảnh */
        .category-hero .hero-content{
            position:relative;
            z-index:2;
        }


        .category-hero .hero-img{ object-fit:cover; }

        .hero-content- {
            padding-top: 5rem;
            padding-bottom: 5rem
        }

    }


</style>

<style>
    /* Desktop: overlay để đẹp như banner */
    @media (max-width: 992px){
        /* Mobile-first: content nằm DƯỚI ảnh */
        .category-hero{ position: relative; border-radius: 24px; overflow: hidden; }
        .category-hero picture,
        .category-hero .hero-img{ display:block; width:100%; }
        .category-hero .hero-img{
            height:auto;                 /* để ảnh tự cao theo tỉ lệ */
            object-fit: contain;         /* thấy đủ ảnh trên mobile */
            object-position: center top;
            background:#0a0a0a;          /* fill phần trống nếu có */
        }

        /* nội dung là khối bình thường, nằm dưới ảnh */
        .category-hero .hero-content{
            position: static;            /* quan trọng: không overlay trên mobile */
            padding: 12px 16px;          /* tuỳ chỉnh */
            z-index: auto;
        }
         .category-hero h2{ margin-left: auto; margin-right: auto; font-size: 17px }
/* lớp phủ không cần trên mobile */
        /*.category-hero .overlay-11{ display:none; }*/
    }


</style>
