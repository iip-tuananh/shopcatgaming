@extends('site.layouts.master')
@section('title'){{ $policy->title }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/assets/styles/editor-content.css?v=2.0">

@endsection

@section('content')

    <!-- breadcrumb start -->
    <section class="pt-60p">
        <div class="section-pt">
            <div
                class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $banner->image->path ?? '' }})">
                <div class="container">
                    <div class="grid grid-cols-12 gap-30p relative xl:py-[130px] md:py-30 sm:py-25 py-20 z-[2]">
                        <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                            <h2 class="heading-2 text-w-neutral-1 mb-3">
                               {{ $policy->title }}
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
                                    <span class="breadcrumb-current">{{ $policy->title }}</span>
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

    <!-- terms conditions section start -->
    <section class="section-pb pt-60p">
        <div class="container">
            <div class="grid grid-cols-12 gap-30p">
                <div class="4xl:col-start-3 4xl:col-end-11 xl:col-start-2 xl:col-end-12 col-span-12">
                    <div class="grid grid-cols-1 gap-y-40p">
                        <div data-aos="fade-up">
                            <h3 class="heading-3 text-w-neutral-1 mb-3">
                                {{ $policy->title }}
                            </h3>

                        </div>

                        <div class="editor-content">
                            {!! $policy->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@push('scripts')
    <script>
    </script>
@endpush
