@extends('site.layouts.master')
@section('title')
    {{$config->web_title}} - Đơn hàng#{{$order->code}}
@endsection

@section('css')
<style>
    /* ===== Dark tokens ===== */
    :root{
        --dk-bg:#0f1115;
        --dk-panel:#111318;
        --dk-panel-2:#0c0f14;
        --dk-text:#e5e7eb;
        --dk-muted:#9aa4b2;
        --dk-border:#2a2f37;
        --dk-accent:#f59e0b;         /* màu nhấn (brand) */
        --dk-ring:rgba(245,158,11,.18);
        --dk-shadow:0 10px 30px rgba(0,0,0,.45);
    }

    /* ===== Layout chung ===== */
    .main-content{ color:var(--dk-text); }
    .section{ background:transparent; }
    .section .section-content{ color:var(--dk-text); }

    /* ===== Header “Đặt hàng thành công” ===== */
    .os-header{
        display:flex; gap:16px; align-items:center;
        padding:14px 0; border-bottom:1px solid var(--dk-border);
    }
    .os-header-title{ color:var(--dk-text); margin:0 0 4px; }
    .os-order-number{ color:var(--dk-muted); display:block; }
    .os-description{ color:#cbd5e1; display:block; margin-top:2px; }

    .hanging-icon.checkmark{ color:var(--dk-accent); }
    .hanging-icon.checkmark .checkmark_circle,
    .hanging-icon.checkmark .checkmark_check{
        stroke:var(--dk-accent);     /* ghi đè stroke="#000" trong SVG */
    }

    /* ===== Card / content-box ===== */
    .content-box{
        background:var(--dk-panel);
        border:1px solid var(--dk-border);
        border-radius:12px;
        box-shadow:var(--dk-shadow);
        overflow:hidden;
    }
    .content-box-row{ color:var(--dk-text); }
    .content-box-row-padding{ padding:14px 16px; }
    .content-box-row + .content-box-row{ border-top:1px solid var(--dk-border); }

    .content-box h2{ margin:0; font-size:18px; color:var(--dk-text); }
    .section-content-column h3{
        margin:12px 0 6px; font-size:15px; color:#dbe2ea;
    }
    .section-content-column p{ margin:6px 0; color:#cbd5e1; }

    /* ===== Button / footer ===== */
    .step-footer{ display:flex; align-items:center; justify-content:space-between; gap:16px; margin-top:18px; }
    .step-footer-continue-btn.btn{
        background:var(--dk-accent); color:#0b0d10; border:0;
        padding:10px 16px; border-radius:12px; text-decoration:none; display:inline-flex; align-items:center;
        transition:filter .15s ease, transform .04s ease-in-out;
    }
    .step-footer-continue-btn.btn:hover{ filter:brightness(.98); }
    .step-footer-continue-btn.btn:active{ transform:translateY(1px); }

    .step-footer-info{ color:var(--dk-muted); margin:0; }
    .step-footer-info a{ color:#f8d089; text-decoration:underline; text-underline-offset:2px; }
    .step-footer-info a:hover{ text-decoration:none; }

    /* ===== Links & focus ===== */
    a{ color:#f8d089; }
    a:focus-visible,
    .step-footer-continue-btn.btn:focus-visible{
        outline:none; box-shadow:0 0 0 4px var(--dk-ring);
    }

    /* ===== Small screens ===== */
    @media (max-width: 640px){
        .os-header{ align-items:flex-start; }
        .step-footer{ flex-direction:column; align-items:stretch; }
    }



    /* khoảng trống tổng thể */
    .main-content{ padding:16px; }
    @media (min-width:768px){ .main-content{ padding:24px; }}

    /* header trên cùng */
    .os-header{
        padding:16px 20px;            /* thêm đệm hai bên */
        margin-bottom:12px;
    }

    /* card Thông tin đơn hàng: thêm inset cho viền */
    .content-box{ padding:12px; }    /* tạo khoảng cách với mép viền card */

    /* các hàng bên trong card */
    .content-box-row-padding{ padding:16px 18px; }
    @media (max-width:640px){
        .content-box{ padding:10px; }
        .content-box-row-padding{ padding:12px 14px; }
    }

    /* footer bên dưới: tách khỏi card & mép */
    .step-footer{ margin-top:16px; padding:0 4px; }

</style>

@endsection

@section('content')
    <main ng-controller="CheckoutController">

        <!-- breadcrumb start -->
        <section class="pt-60p">
            <div class="section-pt">
{{--                <div--}}
{{--                    class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $banner->image->path ?? '' }})">--}}
{{--                    <div class="container">--}}
{{--                        <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">--}}
{{--                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">--}}
{{--                                <h2 class="heading-2 text-w-neutral-1 mb-3">--}}
{{--                                    Thanh toán thành công--}}
{{--                                </h2>--}}
{{--                                <ul class="breadcrumb">--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                        <a href="{{ route('front.home-page') }}" class="breadcrumb-link">--}}
{{--                                            Trang chủ--}}
{{--                                        </a>--}}
{{--                                    </li>--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                    </li>--}}
{{--                                    <li class="breadcrumb-item">--}}
{{--                                        <span class="breadcrumb-current">Thanh toán thành công</span>--}}
{{--                                    </li>--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="overlay-11"></div>--}}
{{--                </div>--}}


                <div class="category-hero relative rounded-24 overflow-hidden">
                    <picture>
                        <img
                            src="{{ $banner->image->path ?? '' }}"
                            class="hero-img"
                            loading="lazy"
                        >
                    </picture>

                    <div class="container hero-content">
                        <div class="grid grid-cols-12 gap-30p relative hero-content- z-[2]">
                            <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                                <h2 class="heading-2 text-w-neutral-1 mb-3">
                                    Thanh toán thành công
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
                                        <span class="breadcrumb-current">Thanh toán thành công</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="overlay-11" aria-hidden="true"></div>
                </div>

            </div>
        </section>
        <!-- breadcrumb end -->



        <!-- checkout section start -->
        <section class="section-pb pt-15 overflow-visible">
            <div class="container">
                <div class="grid grid-cols-12 gap-30p">
                    <div class="3xl:col-start-2 3xl:col-end-12 col-span-12">
                        <form class="grid grid-cols-10 gap-x-30p gap-y-10">
                            <div
                                class="xxl:col-span-7 xl:col-span-6 col-span-10 xl:order-1 order-2 bg-b-neutral-3 p-10p rounded-12 ">

                                <div class="main-content">
                                    <div >
                                        <div class="section">
                                            <div class="section-header os-header">
                                                <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#000" stroke-width="2" class="hanging-icon checkmark">
                                                    <path class="checkmark_circle" d="M25 49c13.255 0 24-10.745 24-24S38.255 1 25 1 1 11.745 1 25s10.745 24 24 24z"></path>
                                                    <path class="checkmark_check" d="M15 24.51l7.307 7.308L35.125 19"></path>
                                                </svg>
                                                <div class="os-header-heading">
                                                    <h2 class="os-header-title">
                                                        Đặt hàng thành công
                                                    </h2>
                                                    <span class="os-order-number">
                            Mã đơn hàng #{{$order->code}}
                            </span>
                                                    <span class="os-description">
                            Cám ơn bạn đã mua hàng!
                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="thank-you-additional-content">
                                            <script src="https://qr.sepay.vn/haravan.js?d=eyJiYW5rX2JpbiI6OTcwNDIyLCJiYW5rX2NvZGUiOiJNQiIsImFjY291bnRfbnVtYmVyIjoiMTkwMDEzNjg2OCIsInByZWZpeCI6IkRIIiwiYmFua19icmFuZF9uYW1lIjoiTUJCYW5rIiwiYWNjb3VudF9uYW1lIjoiQlVJIFRISSBQSFVPTkcgQU5IIn0="></script>
                                        </div>
                                        <div class="section thank-you-checkout-info">
                                            <div class="section-content">
                                                <div class="content-box">
                                                    <div class="content-box-row content-box-row-padding content-box-row-no-border">
                                                        <h2>Thông tin đơn hàng</h2>
                                                    </div>
                                                    <div class="content-box-row content-box-row-padding">
                                                        <div class="section-content">
                                                            <div class="section-content-column">
                                                                <h3>Thông tin giao hàng</h3>
                                                                {{$order->customer_name}}
                                                                </br>
                                                                {{$order->customer_phone}}
                                                                </br>
                                                                <p>
                                                                    {{$order->customer_address}}
                                                                </p>
                                                                <h3>Phương thức thanh toán</h3>
                                                                <p>
                                                                    @if (request()->query('method') === 'qr')
                                                                        Thanh toán chuyển khoản
                                                                    @else
                                                                        Thanh toán khi nhận hàng
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step-footer">
                                            <a href="{{route('front.home-page')}}" class="step-footer-continue-btn btn">
                                                <span class="btn-content">Tiếp tục mua hàng</span>
                                            </a>
                                            <p class="step-footer-info">
                                                <i class="icon icon-os-question"></i>
                                                <span>
                        Cần hỗ trợ? <a href="mailto:{{$config->email}}">Liên hệ chúng tôi</a>
                        </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="xxl:col-span-3 xl:col-span-4 col-span-10 order-1 xl:order-2">
                                <div class="xl:sticky xl:top-30">
                                    <div class="grid grid-cols-1 gap-y-20p mb-20p">
                                        @foreach($order->details as $detail)

                                            <div class="bg-b-neutral-3 flex-y gap-16p  rounded-12"
                                                 style="padding: 10px;  "
                                            >
                                                <div class="relative bg-b-neutral-2 rounded-4">
                                                    <img class="size-[74px]"  src="{{ @$detail->product->image->path ?? '' }}"
                                                         alt="product" style="max-width: 80px; height: auto"/>
                                                    <span class="absolute -top-3 -right-3 badge-box-neutral-1">
                                                 {{ $detail->qty }}
                                                </span>
                                                </div>
                                                <div>
                                                    <a href="#!" class="heading-6 text-w-neutral-1 link-1 mb-1">
                                                        {{ $detail->product->name ?? '' }}
                                                        @if($detail->type)
                                                            <br>
                                                            <small class="cart-variant text-muted">
                                                                Phân loại:
                                                                <span>{{ $detail->type }}</span>
                                                            </small>
                                                        @endif

                                                        @if($detail->attributes)
                                                            <br>
                                                            <small class="cart-variant text-muted">
                                                                <span>{{ $detail->attributes }}</span>
                                                            </small>
                                                        @endif

                                                    </a>

                                                    <h5 class="heading-6 text-w-neutral-1 mb-3">
                                                        @if( $detail->price > 0)
                                                            {{ formatCurrency( $detail->price ) }}₫
                                                        @else
                                                            Liên hệ
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>

                                        @endforeach

                                    </div>

                                    <div class="bg-b-neutral-3 py-32p px-40p rounded-12">
                                        <div class="flex-y justify-between gap-3 mb-3">
            <span class="text-l-medium text-w-neutral-1">
                Tạm tính
            </span>
                                            <span class="text-l-medium text-w-neutral-1">
                {{ formatCurrency($order->total_before_discount) }}₫
            </span>
                                        </div>
                                        <div class="flex-y justify-between gap-3 mb-20p">
            <span class="text-l-medium text-w-neutral-1">
                Giảm giá
            </span>
                                            <span class="text-l-medium text-w-neutral-1">
              0
            </span>
                                        </div>

                                        <div class="flex-y justify-between gap-3 mb-3">
            <span class="text-l-medium text-w-neutral-1">
                Phí ship
            </span>
                                            <span class="text-l-medium text-w-neutral-1">
                {{ formatCurrency($order->ship_cost)  }}₫
            </span>
                                        </div>

                                        <div class="flex-y justify-between gap-3 pt-20p border-t border-shap">
            <span class="text-l-medium text-w-neutral-1">
               Tổng cộng
            </span>
                                            <span class="text-l-medium text-w-neutral-1">
                 {{ formatCurrency($order->total_after_discount) }}₫
            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- checkout section end -->

    </main>

@endsection

@push('scripts')

@endpush
