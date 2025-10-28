<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title')</title>
<link href="/site/assets/styles/app.css" rel="stylesheet">
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


<style>
    /* Ẩn mọi phần tử có ng-cloak cho tới khi Angular biên dịch xong */
    [ng-cloak], [data-ng-cloak], [x-ng-cloak],
    .ng-cloak, .data-ng-cloak, .x-ng-cloak {
        display: none !important;
    }
</style>
