@extends('site.layouts.master')
@section('title')
    Liên hệ - {{ $config->web_title }}
@endsection
@section('description')
    {{ strip_tags(html_entity_decode($config->introduction)) }}
@endsection
@section('image')
    {{@$config->image->path ?? ''}}
@endsection

@section('css')

    <style>
        .invalid-feedback {
            margin-bottom: 10px;
            margin-top: 5px;
            width: 100%;
            font-size: 100%;
            color: #dc3545;
        }

        /* Bọc icon: ép đúng kích thước và canh giữa tuyệt đối */
        .size-80p{
            display:grid;                 /* grid giúp canh giữa tuyệt đối */
            place-items:center;           /* cả ngang lẫn dọc */
            margin-inline:auto;           /* nằm giữa card */
            box-sizing:border-box;        /* để viền không làm lệch kích thước */
        }

        /* Bản thân icon */
        .size-80p i{
            display:block;
            font-size:32px;               /* tuỳ bộ icon của bạn, 32–36px là đẹp */
            line-height:1;                /* bỏ khoảng thừa theo font */
        }




    </style>
@endsection

@section('content')
    <!-- breadcrumb start -->
    <section class="pt-60p">
        <div class="section-pt">
            <div
                class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $banner->image->path ?? '' }})">
                <div class="container">
                    <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">
                        <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                            <h2 class="heading-2 text-w-neutral-1 mb-3">
                                Liên hệ
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
                                    <span class="breadcrumb-current">Liên hệ</span>
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

    <!-- contact us section start -->
    <section class="section-py" ng-controller="AboutPage">
        <div class="container">

            <div class="grid grid-cols-12 gap-30p">
                <div class="3xl:col-start-3 xxl:col-start-2 3xl:col-end-11 xxl:col-end-12 col-span-12">
                    <h2 class="heading-2 text-center text-w-neutral-1 mb-48p">
                        Liên hệ với chúng tôi
                    </h2>

                    <div class="grid lg:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-30p mb-60p">
                        <div class="contact-card bg-b-neutral-3 rounded-4 text-center p-32p">
    <span class="flex-c size-80p rounded-full border border-primary text-primary icon-40 mb-32p">
      <i class="ti ti-map-pin-filled"></i>
    </span>
                            <h5 class="heading-5 text-w-neutral-1 mb-3">Địa chỉ</h5>
                            <a href="#" class="contact-data text-m-regular text-body" title="{{ $config->address_company }}">
                                {{ $config->address_company }}
                            </a>
                        </div>

                        <div class="contact-card bg-b-neutral-3 rounded-4 text-center p-32p">
    <span class="flex-c size-80p rounded-full border border-primary text-primary icon-40 mb-32p">
      <i class="ti ti-mail-opened-filled"></i>
    </span>
                            <h5 class="heading-5 text-w-neutral-1 mb-3">Email</h5>
                            <a href="mailto:{{ $config->email }}" class="contact-data text-m-regular text-body" title="{{ $config->email }}">
                                {{ $config->email }}
                            </a>
                        </div>

                        <div class="contact-card bg-b-neutral-3 rounded-4 text-center p-32p">
    <span class="flex-c size-80p rounded-full border border-primary text-primary icon-40 mb-32p">
      <i class="ti ti-phone-call"></i>
    </span>
                            <h5 class="heading-5 text-w-neutral-1 mb-3">Hotline</h5>
                            <a href="tel:{{ $config->hotline }}" class="contact-data text-m-regular text-body" title="{{ $config->hotline }}">
                                {{ $config->hotline }}
                            </a>
                        </div>
                    </div>


                    <div class="bg-b-neutral-3 rounded-4 p-40p">
                        <form id="form-contact" ng-cloak>
                            <div class="grid grid-cols-8 gap-30p mb-48p">
                                <div class="sm:col-span-4 col-span-8">
                                    <label for="name" class="label label-md font-normal text-white mb-3">
                                        Họ tên*
                                    </label>
                                    <input class="box-input-4" type="text" name="name" id="name"
                                           placeholder="Name" />

                                    <div class="invalid-feedback d-block" ng-if="errors['name']"><% errors['name'][0] %></div>
                                </div>
{{--                                <div class="sm:col-span-4 col-span-8">--}}
{{--                                    <label for="contactEmail"--}}
{{--                                           class="label label-md font-normal text-white mb-3">--}}
{{--                                        Email--}}
{{--                                    </label>--}}
{{--                                    <input class="box-input-4" type="text" name="email" id="contactEmail"--}}
{{--                                           placeholder="Email" />--}}
{{--                                    <div class="invalid-feedback d-block" ng-if="errors['email']"><% errors['email'][0] %></div>--}}
{{--                                </div>--}}
                                <div class="sm:col-span-4 col-span-8">
                                    <label for="phone" class="label label-md font-normal text-white mb-3">
                                        Số điện thoại*
                                    </label>
                                    <input class="box-input-4" type="text" name="phone" id="phone"
                                           placeholder="--- --- ---" />
                                    <div class="invalid-feedback d-block" ng-if="errors['phone']"><% errors['phone'][0] %></div>
                                </div>

                                <div class="col-span-8">
                                    <label for="subject" class="label label-md font-normal text-white mb-3">
                                        Lời nhắn*
                                    </label>
                                    <textarea class="box-input-4 h-[156px]" name="message" id="message"
                                              placeholder="Message"></textarea>
                                    <div class="invalid-feedback d-block" ng-if="errors['message']"><% errors['message'][0] %></div>

                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary rounded-12 w-full" ng-click="submitContact()">
                               Gửi tin nhắn
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact us section end -->


@endsection

@push('scripts')
    <script>
        app.controller('AboutPage', function ($rootScope, $scope, $sce, $interval) {
            $scope.errors = [];
            $scope.submitContact = function () {
                var url = "{{route('front.submitContact')}}";
                var data = jQuery('#form-contact').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            jQuery('#form-contact')[0].reset();
                            $scope.errors = [];
                            $scope.$apply();
                        } else {
                            $scope.errors = response.errors;
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }
        })

    </script>
@endpush
