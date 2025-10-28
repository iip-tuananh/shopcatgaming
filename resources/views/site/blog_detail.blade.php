@extends('site.layouts.master')
@section('title'){{ $blog->name }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/assets/styles/editor-content.css">

@endsection

@section('content')

    <!-- breadcrumb start -->
    <section class="pt-60p">
        <div class="section-pt">
            <div
                class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ @$blog->category->image->path ?? '' }})">
                <div class="container">
                    <div class="grid grid-cols-12 gap-30p relative xl:py-[130px] md:py-30 sm:py-25 py-20 z-[2]">
                        <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                            <h2 class="heading-2 text-w-neutral-1 mb-3">
                                {{ $blog->name }}
                            </h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('front.home-page') }}" class="breadcrumb-link">
                                        Trang chủ
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                            <span class="breadcrumb-icon">
                                                <i class="ti ti-chevrons-right"></i>
                                            </span>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('front.blogs', $blog->category->slug ?? '') }}" class="breadcrumb-link">
                                        {{ $blog->category->name ?? '' }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                            <span class="breadcrumb-icon">
                                                <i class="ti ti-chevrons-right"></i>
                                            </span>
                                </li>
                                <li class="breadcrumb-item">
                                    <span class="breadcrumb-current">{{ $blog->name }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="overlay-11"></div>
            </div>
        </div>
    </section>
    <!-- breadcrumb end -->

    <!-- saved details start -->
    <section class="section-pb relative overflow-visible pt-60p">
        <div class="container">
            <div class="grid grid-cols-12 gap-x-30p gap-y-10">
                <div class="4xl:col-span-9 xxl:col-span-8 col-span-12">
                    <div>
                        <div class="glitch-effect rounded-24 overflow-hidden" data-aos="fade-up">

                        </div>

                        <div data-aos="fade-up">
                            <h2 class="heading-2 mb-3">
                                {{ $blog->name }}
                            </h2>
                        </div>

                        <div class="editor-content">
                            {!! $blog->body !!}
                        </div>


                        <div class="flex-y flex-wrap justify-between gap-20p py-16p border-y border-shap/70 mb-30p"
                             data-aos="fade-up">
                            <h3 class="heading-3">
                                Chia sẻ
                            </h3>
                            <div class="flex items-center gap-3">
                                <a href="#" class="btn-socal-primary">
                                    <i class="ti ti-brand-facebook"></i>
                                </a>
                                <a href="#" class="btn-socal-primary">
                                    <i class="ti ti-brand-twitch"></i>
                                </a>
                                <a href="#" class="btn-socal-primary">
                                    <i class="ti ti-brand-instagram"></i>
                                </a>
                                <a href="#" class="btn-socal-primary">
                                    <i class="ti ti-brand-discord"></i>
                                </a>
                                <a href="#" class="btn-socal-primary">
                                    <i class="ti ti-brand-youtube"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="4xl:col-span-3 xxl:col-span-4 col-span-12">
                    <div class="xxl:sticky xxl:top-24">
                        <div class="grid grid-cols-1 gap-30p *:bg-b-neutral-3 *:rounded-12 *:px-32p *:py-24p">
                            <div data-aos="fade-up">
                                <h4 class="heading-4 text-w-neutral-1 mb-20p">
                                    Bài viết mới nhất
                                </h4>
                                <div class="grid grid-cols-1 gap-20p">
                                    @foreach($othersBlog as $otherBlog)
                                        <div class="flex-y gap-2.5">
                                            <img class="w-28 h-[90px] rounded-10"
                                                 src="{{ $otherBlog->image->path ?? '' }}" alt="image" />
                                            <div>
                                                <div class="flex items-center gap-2 mb-2.5">
                                                    <i class="ti ti-calendar-time text-primary icon-24"></i>
                                                    <span class="span text-sm text-w-neutral-4">
                                                      {{ \Illuminate\Support\Carbon::parse($otherBlog->created_at)->format('d/m/Y') }}
                                                        </span>
                                                </div>
                                                <a href="{{ route('front.blogDetail', $otherBlog->slug) }}" class="text-base text-w-neutral-1 line-clamp-2 link-1">
                                                    {{ $otherBlog->name }}
                                                </a>
                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
                            <div data-aos="fade-up">
                                <h4 class="heading-4 text-w-neutral-1 mb-20p">
                                    Danh mục
                                </h4>
                                <ul
                                    class="grid grid-cols-1 gap-16p *:flex-y *:justify-between text-m-regular text-w-neutral-1">
                                    @foreach($categories as $cate)
                                        <li><a href="{{ route('front.blogs', $cate->slug) }}" class="hover:text-secondary transition-1">{{ $cate->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- saved details end -->



@endsection

@push('scripts')
    <script>
    </script>
@endpush
