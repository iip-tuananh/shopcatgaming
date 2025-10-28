@extends('site.layouts.master')
@section('title')Dịch vụ - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link href="/site/assets/breadcrumb_style.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all" />

    <link href="/site/assets/paginate.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all" />





    <link href="/site/assets/blog_article_style.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/assets/sidebar_style.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all" />

@endsection


@section('content')
    <div class="bodywrap">
        <section class="bread-crumb"
                 style="background-image: url({{ $banner->image->path ?? '' }});">

            <div class="container">
                <div class="title-bread-crumb">

                    Dịch vụ

                </div>
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                        <span class="mr_lr">&nbsp;<svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                       data-icon="chevron-right" role="img"
                                                       xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                                       class="svg-inline--fa fa-chevron-right fa-w-10"><path
                                    fill="currentColor"
                                    d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"
                                    class=""></path></svg>&nbsp;</span>
                    </li>


                    <li><strong><span>Dịch vụ</span></strong></li>


                </ul>
            </div>
        </section>
        <div class="blog_wrapper layout-blog" itemscope itemtype="https://schema.org/Blog">
            <div class="container">
                <div class="row">


                    <div class="right-content col-lg-8 col-xl-9 col-12">

                        <div class="list-blogs">

                            <div class="row row-fix">

                                @foreach($services as $service)
                                    <div class="col-12 col-md-6 col-lg-4 col-fix">
                                        <div class="item-blog">
                                            <div class="block-thumb">

                                                <a class="thumb" href="{{ route('front.getServiceDetail', $service->slug) }}"
                                                   title="{{ $service->name }}">
                                                    <img width="400" height="300" class="lazyload"
                                                         src="{{ $service->image->path ?? '' }}"
                                                         data-src="{{ $service->image->path ?? '' }}"
                                                         alt="{{ $service->name }}">
                                                </a>


                                            </div>
                                            <div class="block-content">

                                                <h3>
                                                    <a class="line-clamp line-clamp-2"
                                                       href="{{ route('front.getServiceDetail', $service->slug) }}"
                                                       title="{{ $service->name }}">{{ $service->name }}</a>
                                                </h3>

                                                <p class="justify line-clamp line-clamp-3">
                                                    {{ $service->description }}
                                                </p>

                                            </div>

                                        </div>
                                    </div>

                                @endforeach


                            </div>
                            <div class="text-center">

                            </div>
                            <div class="pagenav">
                                {{ $services->links('site.pagination.paginate2') }}
                            </div>
                        </div>

                    </div>
                    <div class="blog_left_base col-lg-4 col-xl-3">
                        <div class="aside-content-menu aside-content-blog">
                            <div class="title-head-col">
                                Danh mục


                            </div>
                            <nav class="nav-category">
                                <ul class="nav navbar-pills">
                                    <li class="nav-item  relative">
                                        <a title="Trang chủ" class="nav-link" href="{{ route('front.home-page') }}">Trang chủ</a>
                                    </li>
                                    <li class="nav-item active relative">
                                        <a title="Giới thiệu" class="nav-link" href="{{ route('front.abouts') }}">Giới thiệu</a>
                                    </li>
                                    <li class="nav-item  relative">
                                        <a title="Dự án" class="nav-link" href="{{ route('front.projects') }}">Dự án</a>
                                    </li>
                                    <li class="nav-item  relative">
                                        <a title="Dự án" class="nav-link" href="{{ route('front.getProductList') }}">Sản phẩm</a>
                                    </li>
                                    <li class="nav-item  relative">
                                        <a title="Tin tức" class="nav-link" href="{{ route('front.blogs') }}">Tin tức</a>
                                    </li>
                                    <li class="nav-item  relative">
                                        <a title="Liên hệ" class="nav-link" href="{{ route('front.contact') }}">Liên hệ</a>
                                    </li>
                                </ul>
                            </nav>

                        </div>
                        <script data-cfasync="false"
                                src="cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                        <script>
                            $(".open_mnu").click(function () {
                                $(this).toggleClass('cls_mn').next().slideToggle();
                            });
                        </script>
                        <div class="blog_noibat">


                            <h2 class="h2_sidebar_blog">
                                <a href="{{ route('front.blogs') }}" title="Tin tức mới nhất">Tin tức mới nhất</a>
                            </h2>
                            <div class="blog_content">

                                @foreach($blogs as $blog)
                                    <div class="item">
                                        <div class="post-thumb">

                                            <a class="thumb" href="{{ route('front.blogDetail', $blog->slug) }}"
                                               title="{{ $blog->name }}">
                                                <img class="lazyload"
                                                     src="{{ $blog->image->path ?? '' }}"
                                                     data-src="{{ $blog->image->path ?? '' }}"
                                                     alt="{{ $blog->name }}">
                                            </a>


                                        </div>
                                        <div class="contentright">
                                            <h3>
                                                <a class="line-clamp line-clamp-2"
                                                   href="{{ route('front.blogDetail', $blog->slug) }}"
                                                   title="{{ $blog->name }}">{{ $blog->name }}</a>
                                            </h3>
                                        </div>

                                    </div>
                                @endforeach



                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <div class="ab-module-article-mostview"></div>
    </div>

@endsection

@push('scripts')
    <script>
    </script>
@endpush
