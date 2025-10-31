@extends('site.layouts.master')
@section('title')Tin tức - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')

@endsection


@section('content')
    <!-- breadcrumb start -->
    <section class="pt-60p">
        <div class="section-pt">
            <div
                class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $category->image->path ?? '' }})">
                <div class="container">
                    <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">
                        <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                            <h2 class="heading-2 text-w-neutral-1 mb-3">
                                {{ $category ? $category->name : 'Tin tức' }}
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
                                    <span class="breadcrumb-current">{{ $category ? $category->name : 'Tin tức' }}</span>
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

    <!-- all blogs section start -->
    <section class="section-pb pt-60p ">
        <div class="container">
            <div class="grid 3xl:grid-cols-4 xl:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-30p">

                @foreach($blogs as $blog)
                    <div class="bg-b-neutral-3 py-24p px-30p rounded-12 group" data-aos="zoom-in">
                        <div class="overflow-hidden rounded-12">
                            <img class="w-full h-[202px] object-cover group-hover:scale-110 transition-1"
                                 src="{{ $blog->image->path ?? '' }}" alt="{{ $blog->name }}" />
                        </div>
                        <div class="flex-y justify-between flex-wrap gap-20px py-3">

                        </div>
                        <div class="flex-y flex-wrap gap-3 mb-1">

                            <p class="text-sm text-w-neutral-2">
                                {{ \Illuminate\Support\Carbon::parse($blog->created_at)->format('d/m/Y') }}
                            </p>
                        </div>
                        <a href="{{ route('front.blogDetail', $blog->slug) }}"
                           class="heading-5 text-w-neutral-1 leading-[130%] line-clamp-2 link-1">
                            {{ $blog->name }}
                        </a>
                    </div>

                @endforeach



            </div>
            <div class="flex-c mt-48p">
                {{ $blogs->links('site.pagination.paginate2') }}

            </div>
        </div>
    </section>
    <!-- all blogs section end -->

@endsection

@push('scripts')
    <script>
    </script>
@endpush
