<!-- sidebar start -->
<div>
    <style>
        /* 1) CỐ ĐỊNH BỀ RỘNG SIDEBAR (không nở khi text dài) */
        .fixed-side{
            width: 300px;           /* bạn đổi theo thiết kế */
            max-width: 88vw;        /* phòng màn nhỏ */
        }

        /* 2) Bố cục item: icon & mũi tên cố định, text chiếm phần còn lại */
        .icon-28,
        .collapse-icon{ flex:0 0 auto; }

        /* Quan trọng: cho khối chứa icon+text không đẩy nở */
        .submenu-btn,
        .sub-menu a.flex-y{ min-width:0; align-items:flex-start; }

        /* 3) TEXT: cho phép xuống dòng trong khung, không tràn, không nở khung */
        .menu-text{
            flex:1 1 auto;
            min-width:0;
            white-space:normal;         /* cho xuống dòng */
            overflow-wrap:anywhere;     /* bẻ khi không có khoảng trắng */
            word-break:break-word;      /* fallback */
            line-height:1.35;
        }

        /* 4) Nếu muốn giới hạn tối đa 2–3 dòng và thêm … (tùy chọn) */
        /*
        .menu-text{
          display:-webkit-box;
          -webkit-box-orient:vertical;
          -webkit-line-clamp:3;       // 2 hoặc 3
          overflow:hidden;
        }
        */

        /* 5) Đảm bảo anchor không làm nở khung */
        .small-nav ul li > a,
        .mobail-submenu-btn{
            width:100%;
            box-sizing:border-box;
        }

    </style>

    <!-- left sidebar start-->
    <div class="fixed top-0 left-0 lg:translate-x-0 -translate-x-full h-screen z-10 pt-32 transition-1 fixed-side">
        <div class="overflow-y-auto scrollbar-0 max-h-svh px-[18px] w-full h-full">
            <div class="grid grid-cols-1 gap-20p divide-y divide-shap mb-40p">
                <div class="small-nav">
                    <ul class="grid grid-cols-1 gap-y-3">
                        <li>
                            <a href="{{ route('front.home-page') }}"
                               class="mobail-submenu-btn flex-y gap-3 px-3 py-16p hover:bg-primary text-l-regular text-w-neutral-1 hover:text-b-neutral-4 rounded-12 justify-normal w-full transition-1">
                               <span class="icon-28">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                             stroke-linecap="round" stroke-linejoin="round"
                                             class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M5 12l-2 0l9 -9l9 9l-2 0"/>
                                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"/>
                                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"/>
                                        </svg>
                                    </span>
                                <span class="menu-text">Trang chủ</span>
                            </a>
                        </li>

                    @foreach($categories as $category)
                            @if($category->childs->count())
                                <li class="sub-menu mobail-submenu border-none pb-0">
                                <span class="mobail-submenu-btn flex-y hover:bg-primary hover:text-b-neutral-4 justify-between px-3 py-16p text-l-regular rounded-12 w-full transition-1">
                                    <span class="submenu-btn flex-y gap-3 ">
{{--                                        <span class="icon-28">--}}
{{--                                           <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"--}}
{{--                                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                                stroke-linejoin="round"--}}
{{--                                                class="icon icon-tabler icons-tabler-outline icon-tabler-device-gamepad-2">--}}
{{--                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                                            <path--}}
{{--                                                d="M12 5h3.5a5 5 0 0 1 0 10h-5.5l-4.015 4.227a2.3 2.3 0 0 1 -3.923 -2.035l1.634 -8.173a5 5 0 0 1 4.904 -4.019h3.4z"/>--}}
{{--                                            <path d="M14 15l4.07 4.284a2.3 2.3 0 0 0 3.925 -2.023l-1.6 -8.232"/>--}}
{{--                                            <path d="M8 9v2"/>--}}
{{--                                            <path d="M7 10h2"/>--}}
{{--                                            <path d="M14 10h2"/>--}}
{{--                                        </svg>--}}
{{--                                        </span>--}}
                                     <span class="menu-text">{{ $category->name }}</span>
                                    </span>



                                <span class="collapse-icon mobail-submenu-icon">
                                    <i class="ti ti-chevron-down "></i>
                                </span>
                                </span>

                                    <ul class="grid gap-y-2 px-16p ">
                                        @foreach($category->childs as $child)
                                            <li class="pt-2">
                                                <a aria-label="item" class="flex-y gap-3 px-3 py-16p hover:bg-primary text-l-regular text-w-neutral-1 hover:text-b-neutral-4 rounded-12 justify-normal w-full transition-1"
                                                   href="{{ route('front.getProductList', $child->slug) }}">
{{--                                                     <span class="icon-28">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"--}}
{{--                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                         stroke-linejoin="round"--}}
{{--                                         class="icon icon-tabler icons-tabler-outline icon-tabler-device-gamepad-2">--}}
{{--                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                                        <path--}}
{{--                                            d="M12 5h3.5a5 5 0 0 1 0 10h-5.5l-4.015 4.227a2.3 2.3 0 0 1 -3.923 -2.035l1.634 -8.173a5 5 0 0 1 4.904 -4.019h3.4z"/>--}}
{{--                                        <path d="M14 15l4.07 4.284a2.3 2.3 0 0 0 3.925 -2.023l-1.6 -8.232"/>--}}
{{--                                        <path d="M8 9v2"/>--}}
{{--                                        <path d="M7 10h2"/>--}}
{{--                                        <path d="M14 10h2"/>--}}
{{--                                    </svg>--}}
{{--                                </span>--}}
                                                    <span class="menu-text">{{ $child->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('front.getProductList', $category->slug) }}"
                                       class="mobail-submenu-btn flex-y gap-3 px-3 py-16p hover:bg-primary text-l-regular text-w-neutral-1 hover:text-b-neutral-4 rounded-12 justify-normal w-full transition-1">
{{--                                    <span class="icon-28">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"--}}
{{--                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                         stroke-linejoin="round"--}}
{{--                                         class="icon icon-tabler icons-tabler-outline icon-tabler-device-gamepad-2">--}}
{{--                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                                        <path--}}
{{--                                            d="M12 5h3.5a5 5 0 0 1 0 10h-5.5l-4.015 4.227a2.3 2.3 0 0 1 -3.923 -2.035l1.634 -8.173a5 5 0 0 1 4.904 -4.019h3.4z"/>--}}
{{--                                        <path d="M14 15l4.07 4.284a2.3 2.3 0 0 0 3.925 -2.023l-1.6 -8.232"/>--}}
{{--                                        <path d="M8 9v2"/>--}}
{{--                                        <path d="M7 10h2"/>--}}
{{--                                        <path d="M14 10h2"/>--}}
{{--                                    </svg>--}}
{{--                                </span>--}}
                                        <span class="menu-text">{{ $category->name }}</span>
                                    </a>
                                </li>
                            @endif
                    @endforeach
                    </ul>
                </div>
                <div class="pt-20p">
                    <ul class="grid grid-cols-1 gap-y-3 ">
                        @foreach($categorySpecial as $cateSpec)
                            <li>
                                <a href="{{ route('front.getProductSpecial', $cateSpec->slug) }}"
                                   class="mobail-submenu-btn flex-y gap-3 px-3 py-16p hover:bg-primary text-l-regular text-w-neutral-1 hover:text-b-neutral-4 rounded-12 justify-normal w-full transition-1">
                                <span class="icon-28">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-flame">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M12 10.941c2.333 -3.308 .167 -7.823 -1 -8.941c0 3.395 -2.235 5.299 -3.667 6.706c-1.43 1.408 -2.333 3.621 -2.333 5.588c0 3.704 3.134 6.706 7 6.706s7 -3.002 7 -6.706c0 -1.712 -1.232 -4.403 -2.333 -5.588c-2.084 3.353 -3.257 3.353 -4.667 2.235"/>
                                    </svg>
                                </span>
                                    <span class="menu-text">{{ $cateSpec->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="pt-20p">
                    <ul class="grid grid-cols-1 gap-y-3 mobail-submenu-btn">
                        @foreach($postsCategory as $postCategory)
                            <li>
                                <a href="{{ route('front.blogs', $postCategory->slug) }}"
                                   class="mobail-submenu-btn flex-y gap-3 px-3 py-16p hover:bg-primary text-l-regular text-w-neutral-1 hover:text-b-neutral-4 rounded-12 justify-normal w-full transition-1">
{{--                                        <span class="icon-28">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"--}}
{{--                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
{{--                                         stroke-linejoin="round"--}}
{{--                                         class="icon icon-tabler icons-tabler-outline icon-tabler-bookmark">--}}
{{--                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>--}}
{{--                                        <path d="M18 7v14l-6 -4l-6 4v-14a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4z"/>--}}
{{--                                    </svg>--}}
{{--                                </span>--}}
                                    <span class="menu-text">{{ $postCategory->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="pt-20p">
                    <ul class="grid grid-cols-1 gap-y-3 mobail-submenu-btn">
                        <li>
                            <a href="{{ route('front.contact') }}"
                               class="mobail-submenu-btn flex-y gap-3 px-3 py-16p hover:bg-primary text-l-regular text-w-neutral-1 hover:text-b-neutral-4 rounded-12 justify-normal w-full transition-1">
                                <span class="icon-28">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-headset">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 14v-3a8 8 0 1 1 16 0v3"/>
                                        <path d="M18 19c0 1.657 -2.686 3 -6 3"/>
                                        <path
                                            d="M4 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z"/>
                                        <path
                                            d="M15 14a2 2 0 0 1 2 -2h1a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-1a2 2 0 0 1 -2 -2v-3z"/>
                                    </svg>
                                </span>
                                Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
    <!-- left sidebar end -->
    <!-- right sidebar start -->
    <!-- right sidebar end -->
</div>
<!-- sidebar end -->
