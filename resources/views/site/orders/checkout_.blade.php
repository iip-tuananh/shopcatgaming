@extends('site.layouts.master')
@section('title')
    {{ $config->web_title }} - Thanh toán đơn hàng
@endsection

@section('css')

    <style>
        /* ===== Fulfillment styles ===== */
        .checkout-fulfillment{
            --cf-border:#e5e7eb;
            --cf-text:#111827;
            --cf-muted:#6b7280;
            --cf-bg:#f8fafc;
            --cf-active:#f1f5f9;
            --cf-primary:#111827;
            margin-bottom: 20px;
        }
        .checkout-fulfillment .cf-head{margin-bottom:12px}
        .checkout-fulfillment .cf-title{
            font-size:20px; font-weight:700; color:var(--cf-text); margin:0 0 4px
        }
        .checkout-fulfillment .cf-sub{
            margin:0; color:#fff; font-size:15px
        }

        .cf-toggle{
            display:flex; gap:12px; flex-wrap:wrap;
        }
        .cf-btn{
            flex:1 1 220px;
            display:flex; align-items:center; justify-content:center; gap:8px;
            padding:12px 14px;
            border:1px solid var(--cf-border);
            border-radius:10px;
            background:#fff;
            color:var(--cf-text);
            font-weight:600;
            transition:all .2s ease;
        }
        .cf-btn .cf-ico{display:inline-block; line-height:1}
        .cf-btn:hover{background:var(--cf-active)}
        .cf-btn.is-active{
            color: #fff;
            background:#f29620;
            border-color:#cbd5e1;
            box-shadow:0 0 0 2px rgba(0,0,0,0.02) inset;
        }

        .cf-panel{margin-top:14px}
        .cf-panel.is-hidden{display:none}

        .cf-block-title{
            font-size:16px; font-weight:700; margin:8px 0 10px; color:var(--cf-text)
        }

        /* Pickup card */
        .cf-pickup-card{
            display:block;
            border:1px solid var(--cf-border);
            border-radius:10px;
            background:#fff;
            padding:14px;
            cursor:pointer;
            transition: border-color .2s ease, box-shadow .2s;
        }
        .cf-pickup-card:hover{border-color:#cbd5e1}
        .cf-pickup-body{
            display:flex; align-items:center; justify-content:space-between; gap:10px;
        }
        .cf-pickup-left{display:flex; align-items:flex-start; gap:12px}
        .cf-radio{
            width:18px; height:18px; border-radius:999px;
            border:2px solid var(--cf-primary); position:relative; margin-top:2px;
        }
        .cf-pickup-card input:checked + .cf-pickup-body .cf-radio::after{
            content:""; position:absolute; inset:3px; border-radius:999px; background:var(--cf-primary);
        }
        .cf-pickup-info{display:flex; flex-direction:column; gap:4px}
        .cf-pickup-name{font-weight:700; color:var(--cf-text)}
        .cf-pickup-addr{color:var(--cf-muted); font-size:16px; display:flex; gap:6px; align-items:flex-start}
        .cf-pickup-right{color:#059669; font-weight:700}

        .sr-only{
            position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden;
            clip:rect(0,0,0,0); white-space:nowrap; border:0;
        }

        /* Responsive */
        @media (max-width: 576px){
            .cf-btn{flex:1 1 100%}
            .cf-pickup-body{flex-direction:column; align-items:flex-start}
            .cf-pickup-right{margin-top:6px}
        }

    </style>

    <style>
        /* ===== layout: 3 cột desktop, 1 cột mobile ===== */
        .address-row{
            display:grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 16px;
        }
        .address-row > select{
            grid-column: span 12 / span 12;
        }
        @media (min-width: 768px){
            .address-row > select{ grid-column: span 4 / span 4; }
        }

        /* ===== select style (dark) ===== */
        :root{
            --field-bg:#101215;          /* nền ô nhập */
            --field-bd:#2a2f37;          /* viền */
            --field-fg:#e5e7eb;          /* chữ */
            --field-ph:#9ca3af;          /* placeholder */
            --field-focus:#f59e0b;       /* primary khi focus */
        }

        .select-control{
            width:100%;
            height:46px;                 /* khớp chiều cao input */
            padding:0 40px 0 12px;       /* chừa chỗ cho mũi tên */
            border:1px solid var(--field-bd);
            border-radius:12px;
            /*background: #fff;*/
            color: #fff;
            line-height:46px;
            outline:none;

            /* Ẩn native arrow và dùng SVG */
            appearance:none;
            -webkit-appearance:none;
            background-image: url("data:image/svg+xml;utf8,\
  <svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='%23A3AAB7' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat:no-repeat;
            background-position: right 12px center;
            background-size: 20px 20px;
        }

        .select-control:hover{
            border-color:#3a404a;
        }
        .select-control:focus{
            border-color: #f29620;
            box-shadow: 0 0 0 3px rgba(245,158,11,.18);
        }

        /* Trạng thái disabled */
        .select-control:disabled{
            opacity:.6; cursor:not-allowed;
        }

        /* Trạng thái lỗi (nếu bạn thêm .is-invalid vào parent) */
        .is-invalid .select-control{
            border-color:#ef4444;
            box-shadow:0 0 0 3px rgba(239,68,68,.15);
        }

        /* Tùy chọn dropdown (khả dụng tùy trình duyệt) */
        select.select-control option{
            background:#0f1115;
            color:#e5e7eb;
        }




        /* Khung ngoài */
        .content-box{
            border:1px solid #e5e7eb;
            border-radius:10px;
            overflow:hidden;       /* bo viền liền mạch giữa các dòng */
            background:#fff;
        }

        /* Mỗi dòng */
        .content-box-row .radio-label{
            display:flex;
            align-items:center;
            gap:14px;
            width:100%;
            padding:14px 16px;
            cursor:pointer;
            user-select:none;
        }
        .content-box-row + .content-box-row .radio-label{
            border-top:1px solid #e5e7eb; /* đường kẻ giữa các dòng */
        }

        /* Radio custom (ẩn input gốc) */
        .payment-method-checkbox{
            width:22px; height:22px; position:relative; flex:0 0 22px;
        }
        .payment-method-checkbox .input-radio{
            position:absolute; inset:0;
            opacity:0; cursor:pointer;
        }
        /* vòng tròn */
        .payment-method-checkbox::before{
            content:"";
            position:absolute; inset:0;
            border:2px solid #cbd5e1;
            border-radius:50%;
            background:#fff;
        }
        /* chấm chọn */
        .payment-method-checkbox::after{
            content:"";
            position:absolute; inset:4px;
            border-radius:50%;
            background:#f29620;       /* màu active */
            transform:scale(0);
            transition:transform .15s ease;
        }

        /* Hàng đang chọn */
        .radio-label:has(.input-radio:checked){
            background:#f8fafc;
        }
        .radio-label:has(.input-radio:checked) .payment-method-checkbox::before{
            border-color:#f29620;
        }
        .radio-label:has(.input-radio:checked) .payment-method-checkbox::after{
            transform:scale(1);
        }

        /* Icon phương thức */
        .radio-content-input{
            display:flex; align-items:center; gap:12px;
        }
        .radio-content-input .main-img{
            width:36px; height:36px;
            border-radius:8px;
            background:#fff;
            padding:4px;
            box-shadow:0 0 0 1px #e5e7eb inset;
            object-fit:contain;
        }

        /* Tiêu đề */
        .radio-label-primary{
            font-size:15px;
            color:#111827;
        }

        /* Hover */
        .content-box-row .radio-label:hover{
            background:#f9fafb;
        }



        /* trạng thái bình thường, giữ style cũ nếu đã có */

        /* trạng thái lỗi: viền đỏ + icon cảnh báo ở mép phải */
        .border-input-1.is-invalid{
            border-color:#ef4444;
            box-shadow:0 0 0 3px rgba(239,68,68,.15);
            padding-right:40px;              /* chừa chỗ cho icon */
            background-image: url("data:image/svg+xml;utf8,\
  <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ef4444' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><circle cx='12' cy='12' r='10'/><line x1='12' y1='8' x2='12' y2='13'/><circle cx='12' cy='17' r='1.2'/></svg>");
            background-repeat:no-repeat;
            background-position: right 12px center;
            background-size: 20px 20px;
        }

        /* Base select (giữ icon ▼) */
        .select-control{
            width:100%;
            height:46px;
            padding:0 40px 0 12px;            /* chừa chỗ cho ▼ */
            border:1px solid #e5e7eb;
            border-radius:12px;
            background:black;
            color:#fff;
            line-height:46px;
            outline:none;

            appearance:none;
            -webkit-appearance:none;

            background-repeat:no-repeat;
            background-position:right 12px center;
            background-size:20px 20px;

            /* chevron ▼ (đÃ ENCODE) */
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2399A2AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        }

        .select-control:focus{
            border-color:#f29620;
            box-shadow:0 0 0 3px rgba(37,99,235,.15);
        }

        /* Trạng thái lỗi: viền đỏ + ⚠ + giữ chevron ▼ (2 lớp background) */
        .select-control.is-invalid{
            border-color:#ef4444;
            box-shadow:0 0 0 3px rgba(239,68,68,.15);
            padding-right:64px;                        /* chừa chỗ cho 2 icon */

            background-repeat:no-repeat, no-repeat;
            /* ⚠ ở mép phải, ▼ lùi vào 40px */
            background-position:right 12px center, right 40px center;
            background-size:18px 18px, 20px 20px;

            /* ⚠ + ▼ (ĐỀU ENCODE) */
            background-image:
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ef4444' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='12' cy='12' r='10'/%3E%3Cline x1='12' y1='8' x2='12' y2='13'/%3E%3Ccircle cx='12' cy='17' r='1.2'/%3E%3C/svg%3E"),
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2399A2AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        }



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
{{--                                    Thanh toán đơn hàng--}}
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
{{--                                        <span class="breadcrumb-current">Thanh toán</span>--}}
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
                                    Thanh toán đơn hàng
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
                                        <span class="breadcrumb-current">Thanh toán</span>
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
                                class="xxl:col-span-7 xl:col-span-6 col-span-10 xl:order-1 order-2 bg-b-neutral-3 p-40p rounded-12 ">

                                <section class="checkout-fulfillment" id="checkoutFulfillment" ng-init="form.fulfillment_method = form.fulfillment_method || 'delivery'">
                                    <div class="cf-head">
                                        <div class="section-header">
                                            <h2 class="section-title">Chuyển đến
                                            </h2>
                                            <br>
                                        </div>

                                        <p class="cf-sub">Chọn cách bạn muốn nhận đơn hàng của mình.</p>
                                    </div>

                                    <div class="cf-toggle" role="tablist" aria-label="Chọn phương thức nhận hàng">
                                        <button type="button" ng-click="setFulfillmentMethod('delivery')"
                                                class="cf-btn is-active"
                                                id="btnDelivery"
                                                role="tab" aria-selected="true" aria-controls="panelDelivery">
                                            <span class="cf-ico" aria-hidden="true">🚚</span>
                                            <span>Giao hàng</span>
                                        </button>

                                        <button type="button"  ng-click="setFulfillmentMethod('pickup')"
                                                id="btnPickup" class="cf-btn "
                                                role="tab" aria-selected="false" aria-controls="panelPickup">
                                            <span class="cf-ico" aria-hidden="true">🏬</span>
                                            <span>Nhận hàng tại cửa hàng</span>
                                        </button>
                                    </div>

                                    <!-- Trạng thái để submit về server / đọc ở Angular -->
                                    <input type="hidden" name="fulfillment_method"
                                           value="delivery"
                                           id="fulfillmentMethod"
                                           ng-model="form.fulfillment_method">

                                    <!-- Panel mô tả cho từng phương thức (có thể tùy biến) -->
                                    <div id="panelDelivery" class="cf-panel" role="tabpanel" aria-labelledby="btnDelivery">
                                        <!-- Có thể thêm ghi chú phí ship / thời gian giao nếu bạn muốn -->
                                    </div>

                                    <div id="panelPickup" class="cf-panel is-hidden" role="tabpanel" aria-labelledby="btnPickup" ng-show="isPickup()">

                                        <h4 class="section-title heading-4 text-w-neutral-1 ">
                                            Địa điểm lấy hàng

                                        </h4>
                                        <br>
                                        <label class="cf-pickup-card">
                                            <input class="sr-only" type="radio" name="pickup_place" value="store-1" checked>
                                            <div class="cf-pickup-body">
                                                <div class="cf-pickup-left">
                                                    <span class="cf-radio" aria-hidden="true"></span>
                                                    <div class="cf-pickup-info">
                                                        <div class="cf-pickup-name">Cửa hàng</div>
                                                        <div class="cf-pickup-addr">
                                                            <span class="cf-pin" aria-hidden="true">📍</span>
                                                            {{ $config->address_company }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cf-pickup-right">MIỄN PHÍ</div>
                                            </div>
                                        </label>
                                    </div>
                                </section>


                                <div>
                                    <h4 class="heading-4 text-w-neutral-1 mb-20p">
                                        Thông tin người đặt và giao hàng
                                    </h4>

                                    <div class="bg-b-neutral-4 px-40p py-32p rounded-12 mb-40p">
                                        <div class="grid grid-cols-12 gap-20p mb-24p">
                                            <input
                                                class="col-span-12 border-input-1"
                                                type="text"
                                                name="customer_name"
                                                placeholder="Họ và tên"
                                                ng-model="form.customer_name"

                                                ng-class="{'is-invalid': (errors && errors['customer_name'])}"
                                                ng-attr-aria-invalid="<% (errors && errors['customer_name']) ? 'true' : 'false' %>"
                                                ng-attr-title="<% (errors && errors['customer_name']) ? errors['customer_name'][0] : null %>"
                                            />



                                            <input class="sm:col-span-6 col-span-12 border-input-1" type="text"
                                                   name="customer_email" placeholder="Email" ng-model="form.customer_email"

                                                   ng-class="{'is-invalid': (errors && errors['customer_email'])}"
                                                   ng-attr-aria-invalid="<% (errors && errors['customer_email']) ? 'true' : 'false' %>"
                                                   ng-attr-title="<% (errors && errors['customer_email']) ? errors['customer_email'][0] : null %>"
                                            />


                                            <input class="sm:col-span-6 col-span-12 border-input-1" type="text"
                                                   name="customer_phone" placeholder="Số điện thoại"  ng-model="form.customer_phone"

                                                   ng-class="{'is-invalid': (errors && errors['customer_phone'])}"
                                                   ng-attr-aria-invalid="<% (errors && errors['customer_phone']) ? 'true' : 'false' %>"
                                                   ng-attr-title="<% (errors && errors['customer_phone']) ? errors['customer_phone'][0] : null %>"
                                            />




                                            <input class="col-span-12 border-input-1" type="text" name="customer_address"
                                                   placeholder="Địa chỉ"  ng-model="form.customer_address"

                                                   ng-class="{'is-invalid': (errors && errors['customer_address'])}"
                                                   ng-attr-aria-invalid="<% (errors && errors['customer_address']) ? 'true' : 'false' %>"
                                                   ng-attr-title="<% (errors && errors['customer_address']) ? errors['customer_address'][0] : null %>"
                                            />


                                            <!-- ROW: Tỉnh / Quận / Phường -->

                                                <select class="select-control col-span-4" id="customer_shipping_province"
                                                        ng-model="form.customer_province" ng-change="changeProvince()"

                                                        ng-class="{'is-invalid': (errors && errors['customer_province'])}"
                                                        ng-attr-aria-invalid="<% (errors && errors['customer_province']) ? 'true' : 'false' %>"
                                                        ng-attr-title="<% (errors && errors['customer_province']) ? errors['customer_province'][0] : null %>"
                                                >
                                                    <option value="">Tỉnh / thành</option>
                                                    <option ng-repeat="province in provinces" ng-value="province.code"><% province.name %></option>
                                                </select>

                                                <select class="select-control col-span-4" id="customer_shipping_district"
                                                        ng-model="form.customer_district" ng-change="changeDistrict()"

                                                        ng-class="{'is-invalid': (errors && errors['customer_district'])}"
                                                        ng-attr-aria-invalid="<% (errors && errors['customer_district']) ? 'true' : 'false' %>"
                                                        ng-attr-title="<% (errors && errors['customer_district']) ? errors['customer_district'][0] : null %>"
                                                >
                                                    <option value="">Quận / huyện</option>
                                                    <option ng-repeat="district in district_options" ng-value="district.code"><% district.name %></option>
                                                </select>

                                                <select class="select-control col-span-4" id="customer_shipping_ward"
                                                        ng-model="form.customer_ward" ng-change="changeWard()"

                                                        ng-class="{'is-invalid': (errors && errors['customer_ward'])}"
                                                        ng-attr-aria-invalid="<% (errors && errors['customer_ward']) ? 'true' : 'false' %>"
                                                        ng-attr-title="<% (errors && errors['customer_ward']) ? errors['customer_ward'][0] : null %>"
                                                >
                                                    <option value="">Phường / xã</option>
                                                    <option ng-repeat="ward in ward_options" ng-value="ward.code"><% ward.name %></option>
                                                </select>


                                            <input class="col-span-12 border-input-1" type="text" name="customer_required"
                                                      placeholder="Ghi chú"   ng-model="form.customer_required" />
                                        </div>


                                    </div>

                                </div>

                                <div>
                                    <h4 class="heading-4 text-w-neutral-1 mb-20p">
                                        Phương thức thanh toán
                                    </h4>

                                    <div class="bg-b-neutral-4 px-20p py-20p rounded-12 mb-40p">
                                        <div class="section-content" ng-init="form.payment_method = form.payment_method || 1">
                                            <div class="content-box">

                                                <!-- COD -->
                                                <div class="radio-wrapper content-box-row">
                                                    <label class="radio-label" for="pm_cod">
                                                        <div class="radio-input payment-method-checkbox">
                                                            <input id="pm_cod" class="input-radio"
                                                                   type="radio" name="payment_method"
                                                                   ng-model="form.payment_method" ng-value="1">
                                                        </div>
                                                        <div class="radio-content-input">
                                                            <img class="main-img" src="https://hstatic.net/0/0/global/design/seller/image/payment/cod.svg?v=6">
                                                            <div>
                                                                <span class="radio-label-primary">Thanh toán khi giao hàng (COD)</span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>

                                                <!-- QR -->
                                                <div class="radio-wrapper content-box-row">
                                                    <label class="radio-label" for="pm_qr">
                                                        <div class="radio-input payment-method-checkbox">
                                                            <input id="pm_qr" class="input-radio"
                                                                   type="radio" name="payment_method"
                                                                   ng-model="form.payment_method" ng-value="2">
                                                        </div>
                                                        <div class="radio-content-input">
                                                            <img class="main-img" src="https://hstatic.net/0/0/global/design/seller/image/payment/other.svg?v=6">
                                                            <div>
                                                                <span class="radio-label-primary">Thanh toán chuyển khoản ngân hàng</span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                    <div class="flex-y flex-wrap gap-3">
{{--                                        <a href="javascript:void(0)" class="btn btn-md btn-primary rounded-12" ng-click="submitOrder()" ng-disabled="loading">--}}
{{--                                            Hoàn tất đơn hàng--}}
{{--                                        </a>--}}

                                        <button type="button"
                                                class="btn btn-md btn-primary rounded-12"
                                                ng-click="submitOrder()"
                                                ng-disabled="loading">
                                            <span ng-if="!loading">Hoàn tất đơn hàng</span>
                                            <span ng-if="loading">Đang xử lý…</span>
                                        </button>


                                        <a href="{{ route('cart.index') }}" class="btn btn-md btn-neutral-4 rounded-12">
                                           Về giỏ hàng
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="xxl:col-span-3 xl:col-span-4 col-span-10 order-1 xl:order-2">
                                <div class="xl:sticky xl:top-30">
                                    <div class="grid grid-cols-1 gap-y-20p mb-20p">

                                        <div class="bg-b-neutral-3 flex-y gap-16p  rounded-12"
                                             style="padding: 10px;  "
                                             ng-repeat="item in cart">
                                            <div class="relative bg-b-neutral-2 rounded-4">
                                                <img class="size-[74px]"  ng-src="<% item.attributes.image %>"
                                                     alt="product" style="max-width: 80px; height: auto"/>
                                                <span class="absolute -top-3 -right-3 badge-box-neutral-1">
                                                     <% item.quantity | number %>
                                                </span>
                                            </div>
                                            <div>
                                                <a href="#!" class="heading-6 text-w-neutral-1 link-1 mb-1">
                                                    <% item.name %>
                                                    <br ng-if="item.attributes && item.attributes.type && item.attributes.type.type_title">

                                                    <small class="cart-variant text-muted"
                                                           ng-if="item.attributes && item.attributes.type && item.attributes.type.type_title">
                                                        Phân loại:
                                                        <span ng-bind="item.attributes.type.type_title"></span>
                                                    </small>
                                                    <br ng-if="item.attributes && item.attributes.attributes">
                                                    <small class="cart-variant text-muted"
                                                           ng-if="item.attributes && item.attributes.attributes">
                                                        <span ng-bind="item.attributes.attributes"></span>
                                                    </small>


                                                </a>

                                                <h5 class="heading-6 text-w-neutral-1 mb-3">
                                                    <% (+item.price > 0)
                                                    ? (((+item.price) * (+item.quantity || 1)) | number) + '₫'
                                                    : 'Liên hệ' %>
                                                </h5>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="bg-b-neutral-3 py-32p px-40p rounded-12">
                                        <div class="flex-y justify-between gap-3 mb-3">
            <span class="text-l-medium text-w-neutral-1">
                Tạm tính
            </span>
                                            <span class="text-l-medium text-w-neutral-1">
               <% total | number %>₫
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
               <% ship_cost | number %>₫
            </span>
                                        </div>

                                        <div class="flex-y justify-between gap-3 pt-20p border-t border-shap">
            <span class="text-l-medium text-w-neutral-1">
               Tổng cộng
            </span>
                                            <span class="text-l-medium text-w-neutral-1">
                <% total + ship_cost | number %>₫
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
    <script>
        app.controller('CheckoutController', function($scope, $http, $timeout) {
            $scope.cart = @json($cartCollection);
            $scope.ship_cost = 35000;

            $scope.total = @json($total);
            $scope.provinces = @json($provinces);
            $scope.districts = @json($districts);
            $scope.wards = @json($wards);
            $scope.loading = false;

            $scope.form = {
                customer_province: '',
                customer_district: '',
                customer_ward: '',
                ship_cost: $scope.ship_cost,
                fulfillment_method: 'delivery'
            }



            $scope.setFulfillmentMethod = function (mode) {
                if (mode !== 'delivery' && mode !== 'pickup') return;
                $scope.form.fulfillment_method = mode;
            };
            $scope.isDelivery = function(){ return $scope.form.fulfillment_method === 'delivery'; };
            $scope.isPickup   = function(){ return $scope.form.fulfillment_method === 'pickup'; };


            function syncFulfillmentUI(){
                var wrap          = document.getElementById('checkoutFulfillment');
                if (!wrap) return;

                var btnDelivery   = wrap.querySelector('#btnDelivery');
                var btnPickup     = wrap.querySelector('#btnPickup');
                var panelDelivery = wrap.querySelector('#panelDelivery');
                var panelPickup   = wrap.querySelector('#panelPickup');

                var isDelivery = $scope.form.fulfillment_method === 'delivery';

                // toggle class & aria
                if (btnDelivery && btnPickup) {
                    btnDelivery.classList.toggle('is-active', isDelivery);
                    btnPickup.classList.toggle('is-active', !isDelivery);
                    btnDelivery.setAttribute('aria-selected', String(isDelivery));
                    btnPickup.setAttribute('aria-selected', String(!isDelivery));
                }
                if (panelDelivery && panelPickup) {
                    panelDelivery.classList.toggle('is-hidden', !isDelivery);
                    panelPickup.classList.toggle('is-hidden', isDelivery);
                }
            }

            $scope.$watch('form.fulfillment_method', function(){ $timeout(syncFulfillmentUI, 0); });




            $scope.discount = {
                code: '',
                value: 0,
            }

            $scope.district_options = [];
            $scope.ward_options = [];

            $scope.changeProvince = function() {
                $scope.district_options = $scope.districts.filter(function(district) {
                    return district.parent_code == $scope.form.customer_province;
                });
            }

            $scope.changeDistrict = function() {
                $scope.ward_options = $scope.wards.filter(function(ward) {
                    return ward.parent_code == $scope.form.customer_district;
                });
            }

            $scope.submitOrder = function() {
                if ($scope.loading) return;
                $scope.loading = true;

                let data = $scope.form;
                data.items = $scope.cart;

                $scope.errors = {};
                $.ajax({
                    url: '{{ route('cart.submit.order') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            if(response.payment_method == 1) {
                                window.location.href = '{{route('cart.checkoutCod')}}';
                            } else {
                                window.location.href = '{{route('cart.checkoutQr')}}';
                            }
                        } else {
                            $scope.errors = response.errors;
                            toastr.error(response.message);
                            $scope.loading = false;
                        }
                    },
                    error: function(response) {
                        toastr.error('Thao tác thất bại');
                        $scope.loading = false;
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }




        });
    </script>
    <script>
        $(document).ready(function() {
            function togglePopupCoupons() {
                if ($('.hrv-coupons-popup').hasClass('active-popup') && $('.hrv-coupons-popup-site-overlay')
                    .hasClass('active-popup')) {
                    $('.hrv-coupons-popup').removeClass('active-popup');
                    $('.hrv-coupons-popup-site-overlay').removeClass('active-popup');
                    $('[class*="hrv-discount-code-"]').removeClass('open-more');
                    if ($(window).width() < 768) {
                        $('body').css('overflow', '');
                    }
                } else {
                    $('.hrv-coupons-popup').addClass('active-popup');
                    $('.hrv-coupons-popup-site-overlay').addClass('active-popup');

                    if ($(window).width() < 768) {
                        $('body').css('overflow', 'hidden');
                    }
                }
            }
            $(document).on('click', '#show_all_coupon', function() {
                var coupons = $('.coupon_item').length;
                var parentDOM = $(this).parents('div[class*="hrv-discount-code-"]');
                if (!parentDOM.hasClass('open-more')) {
                    parentDOM.find('.coupon_item').removeClass('hidden');
                    parentDOM.addClass('open-more');
                    $(this).find('span:first-child').html('Thu gọn');
                } else {
                    parentDOM.find('.coupon_item:nth-child(n+3):nth-child(-n+' + coupons + ')').addClass(
                        'hidden');
                    parentDOM.removeClass('open-more');
                    $(this).find('span:first-child').html('Xem thêm');
                }
            });

            $('body').on('click', '.order-summary-section-display-discount .hrv-discount-choose-coupons',
                function() {
                    togglePopupCoupons();
                    // renderCoupons();
                })

            $('body').on('click', '.hrv-coupons-close-popup svg', function() {
                togglePopupCoupons();
            })

            $('body').on('click', '.hrv-discount-code-web .btn_apply_line_coupon', function() {
                var codeCoupons = $(this).data('code');
                togglePopupCoupons();
                $('input[id="discount.code"]').val(codeCoupons).trigger("change");
                $('form#form_discount_add button.field-input-btn.btn.btn-default').removeClass(
                    'btn-disabled');
                $('form#form_discount_add button.field-input-btn.btn.btn-default').trigger('click');
            })

            $('body').on('click', '.coupon_layer', function() {
                $(this).siblings('.btn_apply_line_coupon').trigger('click');
            });

            $(document).on('click', '.coupon_more', function() {
                $(this).parent().siblings('.coupon_desc_short').toggleClass('close');
                $(this).toggleClass('open');
            });

            $(document).on('click', '.hrv-coupons-popup-site-overlay', function() {
                togglePopupCoupons();
            });
        })

    </script>
@endpush
