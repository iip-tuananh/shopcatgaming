@extends('site.layouts.master')
@section('title')Giới thiệu - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')

@endsection

@section('content')
    <div class="breadcumb-wrapper" data-bg-src="{{ $banner->image->path ?? '/site/assets/img/bg/breadcumb-bg.jpg' }}">
        <div class="container">
            <div class="breadcumb-content"><h1 class="breadcumb-title">Về chúng tôi</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                    <li>Về chúng tôi</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="space">
        <div class="container">
            <div class="row justify-content-center">
                {!! $config->web_des !!}
            </div>

        </div>
    </div>




@endsection

@push('scripts')
    <script>

    </script>
@endpush
