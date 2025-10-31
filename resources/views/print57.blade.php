<footer class="section-pt overflow-hidden bg-b-neutral-3">
    <div class="container relative">
        <div class="relative z-10 lg:mx-60p">
            <div class="grid grid-cols-12 gap-24p">
                <div class="xl:col-span-5 col-span-12">
                    <div class="" style="max-width: 220px">
                        <a href="{{ route('front.home-page') }}" class="heading-4 text-w-neutral-1 inline-flex gap-20p mb-24p">
                            <img src="{{ $config->image_back->path ?? '' }}" alt="logo"/>
                        </a>

                    </div>
                </div>

            </div>
            <div
                class="grid xl:grid-cols-4 xsm:grid-cols-2 grid-cols-1 gap-x-30p gap-y-40p border-b-2 border-dashed border-shap py-20p">

                {{--                <div>--}}
                {{--                    <h4 class="heading-4 text-w-neutral-1 mb-32p">--}}
                {{--                        Danh mục--}}
                {{--                    </h4>--}}
                {{--                    <ul--}}
                {{--                        class="grid grid-cols-1 sm:gap-y-16p gap-y-2 gap-x-32p *:flex *:items-center text-base font-poppins">--}}
                {{--                        @foreach($categories as $category)--}}
                {{--                            <li--}}
                {{--                                class="group hover:translate-x-0 -translate-x-5 inline-flex items-center gap-1 hover:text-primary transition-1 max-w-fit">--}}
                {{--                                <i--}}
                {{--                                    class="ti ti-chevron-right  group-hover:visible invisible text-primary group-hover:opacity-100 opacity-0 transition-1"></i>--}}
                {{--                                <a href="{{ route('front.getProductList', $category->slug) }}" class="text-w-neutral-3 group-hover:text-primary transition-1">--}}
                {{--                                    {{ $category->name }}--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                        @endforeach--}}

                {{--                    </ul>--}}
                {{--                </div>--}}
                {{--                <div>--}}
                {{--                    <h4 class="heading-4 text-w-neutral-1 mb-32p">--}}
                {{--                        Tin tức--}}
                {{--                    </h4>--}}
                {{--                    <ul--}}
                {{--                        class="grid grid-cols-1 sm:gap-y-16p gap-y-2 gap-x-32p *:flex *:items-center text-base font-poppins">--}}
                {{--                        @foreach($postsCategory as $postCategory)--}}
                {{--                            <li--}}
                {{--                                class="group hover:translate-x-0 -translate-x-5 inline-flex items-center gap-1 hover:text-primary transition-1 max-w-fit">--}}
                {{--                                <i--}}
                {{--                                    class="ti ti-chevron-right  group-hover:visible invisible text-primary group-hover:opacity-100 opacity-0 transition-1"></i>--}}
                {{--                                <a href="{{ route('front.blogs', $postCategory->slug) }}" class="text-w-neutral-3 group-hover:text-primary transition-1">--}}
                {{--                                    {{ $postCategory->name }}--}}
                {{--                                </a>--}}
                {{--                            </li>--}}
                {{--                        @endforeach--}}


                {{--                    </ul>--}}
                {{--                </div>--}}

                <div>
                    <h4 class="heading-4 text-w-neutral-1 mb-32p">
                        Thông tin khác
                    </h4>
                    <ul
                        class="grid grid-cols-1 sm:gap-y-16p gap-y-2 gap-x-32p *:flex *:items-center text-base font-poppins">
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
                <div>
                    <h4 class="heading-4 text-w-neutral-1 mb-32p">
                        Liên hệ
                    </h4>
                    <p class="text-base text-w-neutral-3 mb-3 max-w-[230px] w-full">
                        {!! $config->hdmh !!}
                    </p>
                    <span class="text-m-medium text-primary mb-60p">
                    </span>
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
            </div>
            <div class="flex items-center justify-center text-center flex-wrap gap-y-3 py-30p">
                <p class="text-base text-w-neutral-3">
                    Copyright ©
                    <span class="currentYear span"></span>
                </p>
                <div class="w-1px h-4 bg-shap mx-3"></div>
                <p class="text-base text-w-neutral-3">
                    <a href="#!" class="text-primary hover:underline a">
                        {{ $config->short_name_company }}</a>
                </p>
            </div>
        </div>
    </div>
</footer>
