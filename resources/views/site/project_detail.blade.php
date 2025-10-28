@extends('site.layouts.master')
@section('title')   {{ $project->name }} - {{ $config->web_title }}@endsection
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
        <section class="bread-crumb" style="background-image: url({{ $banner->image->path ?? '' }});">

            <div class="container">
                <div class="title-bread-crumb">

                    {{ $project->name }}

                </div>
                <ul class="breadcrumb" >
                    <li class="home">
                        <a  href="{{ route('front.home-page') }}" ><span >Trang chủ</span></a>
                        <span class="mr_lr">&nbsp;<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg>&nbsp;</span>
                    </li>

                    <li class="home">
                        <a  href="{{ route('front.home-page') }}" ><span >Dự án</span></a>
                        <span class="mr_lr">&nbsp;<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg>&nbsp;</span>
                    </li>

                    <li><strong ><span>{{ $project->name }}</span></strong></li>

                </ul>
            </div>
        </section>


        <link rel="preload" as="script" href="/site/assets/picbox75d3.js?1719476197344" />
        <link rel="preload" as='style'  type="text/css" href="/site/assets/picbox.scss75d3.css?1719476197344">
        <link href="/site/assets/picbox.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all" />

        <script src="/site/assets/picbox75d3.js?1719476197344" type="text/javascript"></script>
        <section class="blogpage">
            <div class="container layout-article" itemscope itemtype="https://schema.org/Article">
                <div class="bg_blog">

                    <article class="article-main">
                        <div class="row">

                            <div class="col-12">

                                <div class="article-image-block relative">


                                    <div class="swiper-container gallery-top">
                                        <div class="swiper-wrapper" id="lightgallery">

                                            <a class="swiper-slide"  href="{{ $project->image->path ?? '' }}" title="Click để xem">
                                                <img src="{{ $project->image->path ?? '' }}" alt="" data-image="{{ $project->image->path ?? '' }}"
                                                     class="img-responsive mx-auto d-block swiper-lazy" />
                                            </a>

                                            @foreach($project->galleries as $gallery)
                                                <a class="swiper-slide"  href="{{ $gallery->image->path ?? '' }}" title="Click để xem">
                                                    <img src="{{ $gallery->image->path ?? '' }}" alt="" data-image="{{ $gallery->image->path ?? '' }}"
                                                         class="img-responsive mx-auto d-block swiper-lazy" />
                                                </a>
                                            @endforeach



                                        </div>
                                    </div>

                                    <div class="swiper-container gallery-thumbs">
                                        <div class="swiper-wrapper">



                                            <div class="swiper-slide" data-hash="0">
                                                <div class="p-100">
                                                    <img  src="{{ $project->image->path ?? '' }}" alt=""
                                                          data-image="{{ $project->image->path ?? '' }}" class="swiper-lazy" />
                                                </div>
                                            </div>


                                            @foreach($project->galleries as $index => $gallery)
                                                <div class="swiper-slide" data-hash="{{ $index + 1 }}">
                                                    <div class="p-100">
                                                        <img  src="{{ $gallery->image->path ?? '' }}" alt=""
                                                              data-image="{{ $gallery->image->path ?? '' }}" class="swiper-lazy" />
                                                    </div>
                                                </div>
                                            @endforeach



                                        </div>
                                        <div class="swiper-button-next">
                                        </div>
                                        <div class="swiper-button-prev">
                                        </div>
                                    </div>



                                </div>

                            </div>

                            <div class="right-content col-lg-8 col-12">
                                <div class="article-details clearfix">
                                    <ul class="tag-duan">
                                        <li>Hạng mục: <span>{{ $project->hang_muc }}</span></li>
                                        <li>Chủ đầu tư: <span>{{ $project->chu_dau_tu }}</span></li>
                                        <li>Năm hoàn thiện: <span>{{ $project->nam_hoan_thien }}</span></li>
                                        <li>Khu vực: <span>{{ $project->khu_vuc }}</span> </li>
                                    </ul>
                                    <div class="rte article-content">

                                        <p>Vị trí<br />
                                            {{ $project->vi_tri }}<br />
                                            <br />
                                            Chủ đầu tư<br />
                                            {{ $project->chu_dau_tu }}&nbsp;<br />
                                            <br />
                                            Quy mô</p>
                                        <p dir=""><strong>{{ $project->quy_mo }}</strong></p>




                                    </div>


                                    <div class="rte article-content" id="post-content">
                                        {!! $project->content !!}
                                    </div>
                                </div>


                            </div>
                            <div class="blog_left_base col-lg-4 col-12 ">

                                <script>
                                    $(".open_mnu").click(function(){
                                        $(this).toggleClass('cls_mn').next().slideToggle();
                                    });
                                </script>


                                <div class="blog_noibat">
                                    <h2 class="h2_sidebar_blog">
                                        <a href="{{ route('front.projects') }}" title="Dự án liên quan">Các dự án khác</a>
                                    </h2>
                                    <div class="blog_content">

                                        @foreach($projectsRe as $projectRe)
                                            <div class="item">
                                                <div class="post-thumb">

                                                    <a class="thumb" href="{{ route('front.getProjectDetail', $projectRe->slug) }}" title="Hikari Complex">
                                                        <img class="lazyload" src="{{ $projectRe->image->path ?? '' }}"
                                                             data-src="{{ $projectRe->image->path ?? '' }}"  alt="{{ $projectRe->name }}">
                                                    </a>




                                                </div>
                                                <div class="contentright">
                                                    <h3>
                                                        <a class="line-clamp line-clamp-2" href="{{ route('front.getProjectDetail', $projectRe->slug) }}" title="{{ $projectRe->name }}">{{ $projectRe->name }}</a>
                                                    </h3>
                                                </div>

                                            </div>

                                        @endforeach


                                    </div>
                                </div>

                            </div>


                        </div>
                    </article>
                </div>
            </div>


        </section>
        <script>
            var swiperwish = new Swiper('.blog-swiper', {
                slidesPerView: 3,
                loop: false,
                grabCursor: true,
                spaceBetween: 30,
                roundLengths: true,
                slideToClickedSlide: false,
                navigation: {
                    nextEl: '.blog-lienquan .section-prev',
                    prevEl: '.blog-lienquan .section-next',
                },
                autoplay: false,
                breakpoints: {
                    300: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    500: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    640: {
                        slidesPerView: 1,
                        spaceBetween: 20
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20
                    },
                    991: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1200: {
                        slidesPerView: 4,
                        spaceBetween: 20
                    }
                }
            });

            var galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 5,
                slidesPerView: 20,
                freeMode: true,
                lazy: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                hashNavigation: true,
                slideToClickedSlide: true,
                breakpoints: {
                    300: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    500: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 5,
                        spaceBetween: 10,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 10,
                    },
                    1199: {
                        slidesPerView: 5,
                        spaceBetween: 10,
                    },
                },
                navigation: {
                    nextEl: '.gallery-thumbs .swiper-button-next',
                    prevEl: '.gallery-thumbs .swiper-button-prev',
                },
            });
            var galleryTop = new Swiper('.gallery-top', {
                spaceBetween: 0,
                lazy: true,
                hashNavigation: true,
                thumbs: {
                    swiper: galleryThumbs
                }
            });
            $(document).ready(function() {
                $("#lightgallery").lightGallery({
                    thumbnail: false
                });
            });
        </script>
    </div>
@endsection

@push('scripts')
    <link rel="preload" as="script" href="/site/assets/picbox75d3.js?1719476197344"/>
    <link rel="preload" as='style' type="text/css" href="/site/assets/picbox.scss75d3.css?1719476197344">
    <link href="/site/assets/picbox.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all"/>
    <script src="/site/assets/picbox75d3.js?1719476197344" type="text/javascript"></script>

@endpush
