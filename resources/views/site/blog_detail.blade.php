@extends('site.layouts.master')
@section('title'){{ $blog->name }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/assets/styles/editor-content.css?v=5.0">
    <style>
        .toc-container {

            padding: 12px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }
        .toc-title {
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 1.25rem;
        }
        /* Nút Ẩn/Hiện */
        .toc-toggle {
            margin-left: auto;
            font-size: 1.075rem;
            font-weight: 400;
            text-decoration: none;
            cursor: pointer;
            color: #f29620;
        }
        #toc-list li {
            margin-bottom: 4px;
        }
        #toc-list li a {
            color: #f29620;
            text-decoration: none;
        }
        #toc-list li a:hover {
            text-decoration: underline;
        }

        /* Khi scroll, bạn có thể highlight mục đang ở viewport */
        #toc-list li.active > a {
            font-weight: bold;
        }

    </style>
@endsection

@section('content')

    <!-- breadcrumb start -->
    <section class="pt-60p">
        <div class="section-pt">
{{--            <div--}}
{{--                class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ @$blog->category->image->path ?? '' }})">--}}
{{--                <div class="container">--}}
{{--                    <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">--}}
{{--                        <div class="lg:col-start-2 lg:col-end-12 col-span-12">--}}
{{--                            <h2 class="heading-2 text-w-neutral-1 mb-3">--}}
{{--                                {{ $blog->name }}--}}
{{--                            </h2>--}}
{{--                            <ul class="breadcrumb">--}}
{{--                                <li class="breadcrumb-item">--}}
{{--                                    <a href="{{ route('front.home-page') }}" class="breadcrumb-link">--}}
{{--                                        Trang chủ--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                </li>--}}
{{--                                <li class="breadcrumb-item">--}}
{{--                                    <a href="{{ route('front.blogs', $blog->category->slug ?? '') }}" class="breadcrumb-link">--}}
{{--                                        {{ $blog->category->name ?? '' }}--}}
{{--                                    </a>--}}
{{--                                </li>--}}
{{--                                <li class="breadcrumb-item">--}}
{{--                                            <span class="breadcrumb-icon">--}}
{{--                                                <i class="ti ti-chevrons-right"></i>--}}
{{--                                            </span>--}}
{{--                                </li>--}}
{{--                                <li class="breadcrumb-item">--}}
{{--                                    <span class="breadcrumb-current">{{ $blog->name }}</span>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="overlay-11"></div>--}}
{{--            </div>--}}


            <div class="category-hero relative rounded-24 overflow-hidden">
                <picture>
                    <img
                        src="{{ @$blog->category->image->path ?? '' }}"
                        class="hero-img"
                        loading="lazy"
                    >
                </picture>

                <div class="container hero-content">
                    <div class="grid grid-cols-12 gap-30p relative hero-content- z-[2]">
                        <div class="lg:col-start-2 lg:col-end-12 col-span-12">
                            <h2 class="heading-2 text-w-neutral-1 mb-3">
{{--                                {{ $blog->name }}--}}
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
                                    <a href="{{ route('front.blogs', $blog->category->slug ?? '') }}" class="breadcrumb-link">
                                        {{ $blog->category->name ?? '' }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                            <span class="breadcrumb-icon">
                                                <i class="ti ti-chevrons-right"></i>
                                            </span>
                                </li>
                                <li class="breadcrumb-item">
                                    <span class="breadcrumb-current">{{ $blog->name }}</span>
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

    <!-- saved details start -->
    <section class="section-pb relative overflow-visible pt-60p">
        <div class="container">
            <div class="grid grid-cols-12 gap-x-30p gap-y-10">
                <div class="4xl:col-span-9 xxl:col-span-8 col-span-12">
                    <div>
                        <div class="glitch-effect rounded-24 overflow-hidden" data-aos="fade-up">

                        </div>

                        <div data-aos="fade-up">
                            <h2 class="heading-2 mb-3">
                                {{ $blog->name }}
                            </h2>
                        </div>

                        <div class="toc-container mb-4" style="margin-bottom: 10px">
                            <h4 class="toc-title">Mục lục
                                <a href="#" id="toc-toggle" class="toc-toggle">Ẩn</a>
                            </h4>

                            <ul id="toc-list" class="list-unstyled"></ul>
                        </div>

                        <div class="editor-content" id="post-content">

                            {!! normalizeResponsiveImages($blog->body) !!}

                        </div>


{{--                        <div class="flex-y flex-wrap justify-between gap-20p py-16p border-y border-shap/70 mb-30p"--}}
{{--                             data-aos="fade-up">--}}
{{--                            <h3 class="heading-3">--}}
{{--                                Chia sẻ--}}
{{--                            </h3>--}}
{{--                            <div class="flex items-center gap-3">--}}
{{--                                <a href="#" class="btn-socal-primary">--}}
{{--                                    <i class="ti ti-brand-facebook"></i>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn-socal-primary">--}}
{{--                                    <i class="ti ti-brand-twitch"></i>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn-socal-primary">--}}
{{--                                    <i class="ti ti-brand-instagram"></i>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn-socal-primary">--}}
{{--                                    <i class="ti ti-brand-discord"></i>--}}
{{--                                </a>--}}
{{--                                <a href="#" class="btn-socal-primary">--}}
{{--                                    <i class="ti ti-brand-youtube"></i>--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}

                    </div>
                </div>
                <div class="4xl:col-span-3 xxl:col-span-4 col-span-12">
                    <div class="xxl:sticky xxl:top-24">
                        <div class="grid grid-cols-1 gap-30p *:bg-b-neutral-3 *:rounded-12 *:px-32p *:py-24p">
                            <div data-aos="fade-up">
                                <h4 class="heading-4 text-w-neutral-1 mb-20p">
                                    Bài viết mới nhất
                                </h4>
                                <div class="grid grid-cols-1 gap-20p">
                                    @foreach($othersBlog as $otherBlog)
                                        <div class="flex-y gap-2.5">
                                            <img class="w-28 h-[90px] rounded-10" style="height: auto"
                                                 src="{{ $otherBlog->image->path ?? '' }}" alt="image" />
                                            <div>
                                                <a href="{{ route('front.blogDetail', $otherBlog->slug) }}" class="text-base text-w-neutral-1 line-clamp-2 link-1"
                                                   title="{{ $otherBlog->name }}"
                                                >
                                                    {{ $otherBlog->name }}
                                                </a>

                                                <div class="flex items-center gap-2 mb-2.5">
                                                    <i class="ti ti-calendar-time text-primary icon-24"></i>
                                                    <span class="span text-sm text-w-neutral-4">
                                                      {{ \Illuminate\Support\Carbon::parse($otherBlog->created_at)->format('d/m/Y') }}
                                                        </span>
                                                </div>

                                            </div>
                                        </div>

                                    @endforeach

                                </div>
                            </div>
{{--                            <div data-aos="fade-up">--}}
{{--                                <h4 class="heading-4 text-w-neutral-1 mb-20p">--}}
{{--                                    Danh mục--}}
{{--                                </h4>--}}
{{--                                <ul--}}
{{--                                    class="grid grid-cols-1 gap-16p *:flex-y *:justify-between text-m-regular text-w-neutral-1">--}}
{{--                                    @foreach($categories as $cate)--}}
{{--                                        <li><a href="{{ route('front.blogs', $cate->slug) }}" class="hover:text-secondary transition-1">{{ $cate->name }}</a></li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- saved details end -->



@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const content   = document.getElementById("post-content");
            const tocList   = document.getElementById("toc-list");
            const tocToggle = document.getElementById("toc-toggle");
            if (!content || !tocList || !tocToggle) return;

            // === 0) Lấy chiều cao header cố định (đổi selector cho đúng site của bạn) ===
            const headerEl = document.querySelector(".site-header, .header, [data-sticky-header]");
            const getHeaderH = () => (headerEl ? headerEl.offsetHeight : 80); // fallback 80px
            const EXTRA_GAP = 8; // khoảng cách thở

            // 1) Sinh TOC
            const headings = content.querySelectorAll("h1,h2,h3,h4,h5,h6");
            if (headings.length === 0) {
                tocList.innerHTML = "<li>Chưa có mục nào</li>";
            } else {
                headings.forEach((head, idx) => {
                    if (!head.id) head.id = "heading-" + idx;

                    // CSS scroll-margin để hỗ trợ cả các cuộn khác ngoài click TOC
                    head.style.scrollMarginTop = (getHeaderH() + EXTRA_GAP) + "px";

                    const level = parseInt(head.tagName.substring(1), 10);
                    const li = document.createElement("li");
                    li.style.paddingLeft = ((level - 1) * 12) + "px";
                    const a  = document.createElement("a");
                    a.href = "#" + head.id;
                    a.textContent = head.textContent.trim();
                    li.appendChild(a);
                    tocList.appendChild(li);
                });
            }

            // 2) Smooth scroll WITH OFFSET (tránh che tiêu đề)
            tocList.addEventListener("click", function (e) {
                const link = e.target.closest("a");
                if (!link) return;
                e.preventDefault();

                const id = link.getAttribute("href").slice(1);
                const target = document.getElementById(id);
                if (!target) return;

                const headerH = getHeaderH();
                const top = target.getBoundingClientRect().top + window.pageYOffset - headerH - EXTRA_GAP;

                window.scrollTo({ top, behavior: "smooth" });
                history.pushState(null, "", "#" + id);
            });

            // 3) Highlight mục active khi scroll (so với mép dưới header)
            const markActive = () => {
                const headerH = getHeaderH();
                const probeY = headerH + 10;
                let currentId = null;

                headings.forEach(h => {
                    const rect = h.getBoundingClientRect();
                    if (rect.top <= probeY) currentId = h.id;
                });

                document.querySelectorAll("#toc-list li").forEach(li => {
                    li.classList.toggle(
                        "active",
                        li.querySelector("a")?.getAttribute("href") === "#" + currentId
                    );
                });
            };
            window.addEventListener("scroll", markActive, { passive: true });
            markActive();

            // 4) Toggle Ẩn/Hiện TOC
            tocToggle.addEventListener("click", function (e) {
                e.preventDefault();
                const hidden = tocList.style.display === "none";
                tocList.style.display = hidden ? "" : "none";
                tocToggle.textContent = hidden ? "Ẩn" : "Hiện";
            });

            // 5) Recompute nếu header thay đổi chiều cao (ví dụ sticky co giãn)
            window.addEventListener("resize", () => {
                headings.forEach(h => h.style.scrollMarginTop = (getHeaderH() + EXTRA_GAP) + "px");
            });
        });
    </script>

@endpush
