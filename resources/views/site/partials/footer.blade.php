


<footer class="relative section-pt overflow-hidden bg-b-neutral-3" style="margin-top: 60px">
    <div class="container">
        <div class="relative z-10 lg:px-10">

            <div style="padding-top: 40px"
                class="grid 4xl:grid-cols-12 3xl:grid-cols-4 sm:grid-cols-2 grid-cols-1 4xl:gap-x-6 max-4xl:gap-40p border-y-2 border-dashed border-shap py-80p">
                <div class="4xl:col-start-1 4xl:col-end-4">
                    <img class="mb-16p" src="{{ $config->image_back->path ?? '' }}" alt="logo" style="max-width: 88%" />
                    <div class="text-base text-w-neutral-3 mb-32p">
                        {!! $config->hdmh !!}
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ $config->facebook }}" class="btn-socal-primary" title="Facebook">
                            <i class="ti ti-brand-facebook"></i>
                        </a>
                        <a href="{{ $config->twitter }}" class="btn-socal-primary" title="Tiktok">
                            <i class="ti ti-brand-tiktok"></i>
                        </a>
                        <a href="{{ $config->instagram }}" class="btn-socal-primary" title="Instagram">
                            <i class="ti ti-brand-instagram"></i>
                        </a>
                        <a href="{{ $config->youtube }}" class="btn-socal-primary" title="Youtube">
                            <i class="ti ti-brand-youtube"></i>
                        </a>
                    </div>
                </div>
                <div class="4xl:col-start-5 4xl:col-end-7">
                    <div class="flex items-center gap-24p mb-24p">
                        <h4 class="heading-4 text-w-neutral-1 whitespace-nowrap ">
                            Thông tin khác
                        </h4>
                        <span class="w-full max-w-[110px] h-0.5 bg-w-neutral-1"></span>
                    </div>
                    <ul class="grid grid-cols-1 sm:gap-y-16p gap-y-2 gap-x-32p *:flex *:items-center">
                        @foreach($polis as $poli)
                            <li
                                class="group hover:translate-x-0 -translate-x-5 inline-flex items-center gap-1 hover:text-primary transition-1 max-w-fit">
                                <i
                                    class="ti ti-chevron-right  group-hover:visible invisible text-primary group-hover:opacity-100 opacity-0 transition-1"></i>
                                <a href="{{ route('front.getPolicy', $poli->slug) }}"
                                   class="text-w-neutral-3 group-hover:text-primary transition-1">
                                    {{ $poli->title }}
                                </a>
                            </li>
                        @endforeach


                    </ul>
                </div>
                <div class="4xl:col-start-11 4xl:col-end-13">
                    <h4 class="heading-4 text-w-neutral-1 whitespace-nowrap  mb-3">
                        Email
                    </h4>
                    <a href="mailto: {{ $config->email }}" class="text-base text-w-neutral-3 mb-32p">
                      {{ $config->email }}
                    </a>
                    <h4 class="heading-5 whitespace-nowrap mb-3">
                        Hotline
                    </h4>
                    <a href="tel:{{ $config->hotline }}" class="text-base text-w-neutral-3">
                        {{ $config->hotline }}
                    </a>
                </div>
            </div>
            <div class="flex items-center justify-between flex-wrap gap-24p py-30p">
                <div class="flex items-center flex-wrap">
                    <p class="text-base text-w-neutral-3">
                        Copyright ©
                        <span class="currentYear span"></span>
                    </p>
                    <div class="w-1px h-4 bg-shap mx-24p"></div>
                    <p class="text-base text-white">
                         <a href="https://themeforest.net/user/uiaxis/portfolio"
                                       class="text-primary hover:underline a"> {{ $config->short_name_company }}</a>
                    </p>
                </div>

            </div>
        </div>
{{--        <div class="absolute right-0 top-0 xl:block hidden" data-aos="zoom-out-right" data-aos-duration="800">--}}
{{--            <img class="3xl:w-[580px] xxl:w-[500px] xl:w-[400px]" src="assets/images/photos/footerIllustration.webp"--}}
{{--                 alt="footer" />--}}
{{--        </div>--}}
    </div>
</footer>
