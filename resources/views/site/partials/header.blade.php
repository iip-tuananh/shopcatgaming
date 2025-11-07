<header id="header" class="absolute w-full z-[999]" ng-controller="headerPartial">
    <style>
        #header-nav {
            padding-right: 8.5rem
        }
        @media (max-width: 768px) {
            #header-nav {
                padding-right: 0.75rem
            }
        }

        .cart-link{
            position: relative;                 /* để badge bám theo */
            display: inline-flex;
            align-items: center;
        }

        /* Huy hiệu số lượng góc phải trên */
        .cart-badge{
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            border-radius: 9999px;
            background: #ef4444;               /* đỏ */
            color: #fff;
            font-size: 11px;
            line-height: 18px;
            font-weight: 700;
            text-align: center;
            border: 2px solid #fff;            /* viền trắng để nổi bật trên nền */
            box-shadow: 0 1px 2px rgba(0,0,0,.15);
            pointer-events: none;              /* không chặn click vào link */
        }

        /* Nếu nút lớn hơn, muốn badge dịch sát góc hơn thì tăng offset:
        .cart-badge{ top:-8px; right:-8px; } */

    </style>
    <div class="mx-auto relative">
        <div id="header-nav" class="w-full px-24p bg-b-neutral-3 relative" >
            <div class="flex items-center justify-between gap-x-2 mx-auto py-20p-x">
                <nav class="relative xl:grid xl:grid-cols-12 flex justify-between items-center gap-24p text-semibold w-full">
                    <div class="3xl:col-span-6 xl:col-span-5 flex items-center 3xl:gap-x-10 gap-x-5">
                        <a href="{{ route('front.home-page') }}" class="shrink-0">
                            <img class="xl:w-[200px] sm:w-36 w-30 h-auto shrink-0" src="{{ $config->image->path ?? '' }}"
                                 alt="brand"/>
                        </a>
                        <form
                            class="hidden lg:flex items-center sm:gap-3 gap-2 min-w-[300px] max-w-[670px] w-full px-20p py-16p bg-b-neutral-4 rounded-full">
              <span class="flex-c icon-20 text-white">
                <i class="ti ti-search"></i>
              </span>


                            <input autocomplete="off" class="bg-transparent w-full" type="text" name="search"
                                   ng-model="keywords" id="search" ng-click="searchBoxOpen=true"
                                   ng-keydown="$event.keyCode===13 && search()"
                                   placeholder="Nhập từ khóa và nhấn enter..." />
                        </form>
                    </div>
                    <div class="3xl:col-span-6 xl:col-span-7 flex items-center justify-end w-full">

                        <div class="flex items-center lg:gap-x-32p gap-x-2">
                            <div class=" lg:flex items-center gap-1 shrink-0">
                                <a href="{{ route('cart.index') }}" class="cart-link btn-c btn-c-lg btn-c-dark-outline"
                                   aria-label="Giỏ hàng">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                        <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                        <path d="M17 17h-11v-14h-2"/>
                                        <path d="M6 5l14 1l-1 7h-13"/>
                                    </svg>


                                        <span class="cart-badge" aria-hidden="true" ng-cloak ng-if="cart.count > 0"><% cart.count %></span>

                                </a>

{{--                                <div class="relative hidden lg:block">--}}
{{--                                    <a href="chat.html" class="btn-c btn-c-lg btn-c-dark-outline">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                             viewBox="0 0 24 24" fill="none"--}}
{{--                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                             stroke-linejoin="round"--}}
{{--                                             class="icon icon-tabler icons-tabler-outline icon-tabler-bell">--}}
{{--                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                                            <path--}}
{{--                                                d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>--}}
{{--                                            <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                                </div>--}}
                            </div>

                            <button class="lg:hidden btn-c btn-c-lg btn-c-dark-outline nav-toggole shrink-0">
                                <i class="ti ti-menu-2"></i>
                            </button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <nav class="w-full flex justify-between items-center">
            <div
                class="small-nav fixed top-0 left-0 h-screen w-full shadow-lg z-[999] transform transition-transform ease-in-out invisible md:translate-y-full max-md:-translate-x-full duration-500">
                <div class="absolute z-[5] inset-0 bg-b-neutral-3 flex-col-c min-h-screen max-md:max-w-[400px]">
                    <div class="container max-md:p-0 md:overflow-y-hidden overflow-y-scroll scrollbar-sm lg:max-h-screen">
                        <div class="p-40p">
                            <div class="flex justify-between items-center mb-10">
                                <a href="{{ route('front.home-page') }}">
                                    <img class="w-[142px]" src="{{ $config->image->path ?? '' }}" alt="GameCo"/>
                                </a>
                                <button class="nav-close btn-c btn-c-md btn-c-primary">
                                    <i class="ti ti-x"></i>
                                </button>
                            </div>
                            <div class="grid grid-cols-12 gap-x-24p gap-y-10 sm:p-y-48p">
                                <div class="xl:col-span-8 md:col-span-7 col-span-12">
                                    <div
                                        class="overflow-y-scroll overflow-x-hidden scrollbar scrollbar-sm xl:max-h-[532px] md:max-h-[400px] md:pr-4">
                                        <ul class="flex flex-col justify-center items-start gap-20p text-w-neutral-1">
                                            <li class="mobail-menu">
                                                <a href="{{ route('front.home-page') }}">Trang chủ</a>
                                            </li>
                                            @foreach($categories as $category)
                                                @if($category->childs->count())
                                                    <li class="sub-menu mobail-submenu">
                                                            <span class="mobail-submenu-btn">
                                                              <span class="submenu-btn">{{ $category->name }}</span>
                                                              <span class="collapse-icon mobail-submenu-icon">
                                                                <i class="ti ti-chevron-down"></i>
                                                              </span>
                                                            </span>
                                                        <ul class="grid gap-y-2 px-16p">
                                                            @foreach($category->childs as $child)
                                                                <li class="pt-2">
                                                                    <a aria-label="item"
                                                                       class="text-base hover:text-primary transition-1"
                                                                       href="{{ route('front.getProductList', $child->slug) }}">
                                                                        - {{ $child->name }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @else
                                                    <li class="mobail-menu">
                                                        <a href="{{ route('front.getProductList', $category->slug) }}">{{ $category->name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach



                                            @foreach($postsCategory as $postCategory)
                                                <li class="mobail-menu">
                                                    <a href="{{ route('front.blogs', $postCategory->slug) }}">{{ $postCategory->name }}</a>
                                                </li>
                                            @endforeach


                                            <li class="mobail-menu">
                                                <a href="{{ route('front.contact') }}">Liên hệ</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="xl:col-span-4 md:col-span-5 col-span-12">
                                    <div class="flex flex-col items-baseline justify-between h-full">
                                        <form
                                            class="w-full flex items-center justify-between px-16p py-2 pr-1 border border-w-neutral-4/60 rounded-full">
                                            <input class="placeholder:text-w-neutral-4 bg-transparent w-full"
                                                   type="text" name="search-media" ng-model="keywords"
                                                   placeholder="Nhập từ khóa..." id="search-media"/>
                                            <button type="button" class="btn-c btn-c-md text-w-neutral-4" ng-click="search()">
                                                <i class="ti ti-search"></i>
                                            </button>
                                        </form>




                                        <div class="mt-40p">
                                            <img class="mb-16p" src="{{ $config->image->path ?? '' }}" alt="logo"/>
                                            <p class="text-base text-w-neutral-3 mb-32p">
                                                {{ $config->introduction }}
                                            </p>
                                            <div class="flex items-center flex-wrap gap-3">
                                                <a href="{{ $config->facebook }}" class="btn-socal-primary">
                                                    <i class="ti ti-brand-facebook"></i>
                                                </a>
                                                <a href="{{ $config->twitter }}" class="btn-socal-primary">
                                                    <i class="ti ti-brand-twitch"></i>
                                                </a>
                                                <a href="{{ $config->instagram }}" class="btn-socal-primary">
                                                    <i class="ti ti-brand-instagram"></i>
                                                </a>
                                                <a href="{{ $config->youtube }}" class="btn-socal-primary">
                                                    <i class="ti ti-brand-youtube"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-close min-h-[200vh] navbar-overly"></div>
            </div>
        </nav>
    </div>
</header>
