@extends('site.layouts.master')
@section('title')Dự án - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link href="/site/assets/breadcrumb_style.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all"/>
    <link href="/site/assets/paginate.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all"/>
    <link href="/site/assets/blog_article_style.scss75d3.css?1719476197344" rel="stylesheet" type="text/css"
          media="all"/>
    <link href="/site/assets/sidebar_style.scss75d3.css?1719476197344" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')

    <div class="bodywrap">
        <section class="bread-crumb" style="background-image: url({{ $banner->image->path ?? '' }});">

            <div class="container">
                <div class="title-bread-crumb">

                    Dự án

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

                    <li><strong><span>Dự án</span></strong></li>

                </ul>
            </div>
        </section>
        <div class="blog_wrapper layout-blog" itemscope itemtype="https://schema.org/Blog">
            <meta itemprop="name" content="Dự án">
            <meta itemprop="description" content="">
            <div class="container">
                <h1 class="title-page d-none">
                    <img width="72" height="43" src="/site/assets/icon-title75d3.png?1719476197344" alt="">
                    <span>Dự án</span>
                </h1>
                <div class="row">


                    <div class="right-content col-lg-8 col-xl-9 col-12">

                        <div class="list-blogs">

                            <div class="row row-fix">

                                @foreach($projects as $project)
                                    <div class="col-12 col-md-6 col-lg-6 col-fix">
                                        <div class="item-blog-duan">
                                            <div class="block-thumb">

                                                <a class="thumb" href="{{ route('front.getProjectDetail', $project->slug) }}" title="{{ $project->name }}">
                                                    <img width="400" height="300" class="lazyload"
                                                         src="{{ $project->image->path ?? '' }}"
                                                         data-src="{{ $project->image->path ?? '' }}"
                                                         alt="{{ $project->name }}">
                                                </a>

                                            </div>
                                            <div class="block-content">
                                                <h3>
                                                    <a class="line-clamp line-clamp-1" href="{{ route('front.getProjectDetail', $project->slug) }}"
                                                       title="{{ $project->name }}">{{ $project->name }}</a>
                                                </h3>
                                                <ul>
                                                    <li>Hạng mục: <span>{{ $project->hang_muc }}</span></li>
                                                    <li>Chủ đầu tư: <span>{{ $project->chu_dau_tu }}</span></li>
                                                    <li>Năm hoàn thiện: <span>{{ $project->nam_hoan_thien }}</span></li>
                                                    <li>Khu vực:<span>{{ $project->khu_vuc }}</span></li>
                                                </ul>

                                            </div>

                                        </div>
                                    </div>

                                @endforeach

                            </div>
                            <div class="text-center">

                            </div>
                            <div class="pagenav">
                                {{ $projects->links('site.pagination.paginate2') }}
                            </div>
                        </div>

                    </div>
                    <div class="blog_left_base col-lg-4 col-xl-3">



                        <div class="blog_noibat">


                            <h2 class="h2_sidebar_blog">
                                <a href="{{ route('front.projects') }}" title="Dự án nổi bật">Dự án nổi bật</a>
                            </h2>
                            <div class="blog_content">

                                @foreach($projectsHighlights as $projectsHighlight)
                                    <div class="item">
                                        <div class="post-thumb">

                                            <a class="thumb" href="{{ route('front.getProjectDetail', $projectsHighlight->slug) }}" title="{{ $projectsHighlight->name }}">
                                                <img class="lazyload" src="{{ $projectsHighlight->image->path ?? '' }}"
                                                     data-src="{{ $projectsHighlight->image->path ?? '' }}"
                                                     alt="{{ $projectsHighlight->name }}">
                                            </a>


                                        </div>
                                        <div class="contentright">
                                            <h3>
                                                <a class="line-clamp line-clamp-2" href="{{ route('front.getProjectDetail', $projectsHighlight->slug) }}"
                                                   title="{{ $projectsHighlight->name }}">{{ $projectsHighlight->name }}</a>
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
