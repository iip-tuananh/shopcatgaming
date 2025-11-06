@extends('site.layouts.master')
@section('title')
    {{ $config->web_title }} - Thanh toán đơn hàng
@endsection

@section('css')

    <style>
        :root{
            --qr-radius:14px;
            --qr-border:#e8edf2;
            --qr-muted:#6b7280;
            --qr-shadow:0 8px 24px rgba(0,0,0,.06);
            --qr-primary:#ff6a00; /* đổi theo brand */
            --qr-ring: rgba(255,106,0,.18);
        }
        .qrpay{background:#fff;border:1px solid var(--qr-border);border-radius:var(--qr-radius);box-shadow:var(--qr-shadow);padding:18px}
        .qrpay-grid{display:grid;grid-template-columns:1fr 1fr;gap:22px}
        .qrpay-col{min-width:0}

        .qrpay-qr{position:relative;border:1px solid var(--qr-border);border-radius:12px;overflow:hidden;cursor:zoom-in;background:#fafbfc}
        .qrpay-qr img{display:block;width:100%;max-width:360px;margin:auto;aspect-ratio:1/1;object-fit:contain}
        .qrpay-zoomhint{position:absolute;right:8px;bottom:8px;background:#fff;border:1px solid var(--qr-border);border-radius:999px;font-size:.85rem;padding:6px 10px;box-shadow:var(--qr-shadow)}

        .qrpay-bank{list-style:none;margin:14px 0 0;padding:0;border:1px dashed var(--qr-border);border-radius:12px}
        .qrpay-bank li{display:flex;align-items:center;gap:10px;padding:10px 12px}
        .qrpay-bank li+li{border-top:1px dashed var(--qr-border)}
        .qrpay-bank span{color:var(--qr-muted);width:110px;flex:0 0 110px}
        .qrpay-rowcopy strong{flex:1}

        .qrpay-label{display:block;margin:2px 0 8px;font-weight:600}
        .qrpay-inputcopy{display:flex;gap:10px;align-items:stretch}
        .qrpay-inputcopy input{flex:1;border:1px solid var(--qr-border);border-radius:12px;padding:12px}
        .qrpay-inputcopy input:focus{outline:none;border-color:var(--qr-primary);box-shadow:0 0 0 4px var(--qr-ring)}
        .qr-btn{border:1px solid transparent;border-radius:12px;padding:10px 14px;cursor:pointer;white-space:nowrap;transition:.18s}
        .qr-btn-primary{background:var(--qr-primary);color:#fff}
        .qr-btn-ghost{background:#fff;border-color:var(--qr-border);color:#111}
        .qr-btn:hover{filter:brightness(.97)}

        .qrpay-note{margin-top:16px;border:1px solid var(--qr-border);border-radius:12px;padding:12px 14px;background:#fafbfc}
        .qrpay-note-title{font-weight:700;margin-bottom:6px}
        .qrpay-note-list{padding-left:18px;margin:0;color:#111}
        .qrpay-note-list li{margin:6px 0}

        /* Modal */
        .qrpay-modal{position:fixed;inset:0;display:none}
        .qrpay-modal.is-open{display:block; z-index: 9999}
        .qrpay-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.56)}
        .qrpay-modal-body{position:absolute;inset:0;display:grid;place-items:center;padding:24px}
        .qrpay-modal-body img{max-width:min(92vw,640px);max-height:82vh;border-radius:12px;background:#fff}
        .qrpay-close{position:absolute;top:16px;right:16px;width:40px;height:40px;border-radius:999px;border:0;background:#fff;box-shadow:var(--qr-shadow);font-size:24px;line-height:1;cursor:pointer}

        /* Toast */
        .qrpay-toast{position:fixed;left:50%;bottom:24px;transform:translateX(-50%);background:#111;color:#fff;padding:10px 14px;border-radius:999px;box-shadow:var(--qr-shadow)}
        .qrpay-toast[hidden]{display:none}

        /* Responsive */
        @media (max-width: 900px){ .qrpay-grid{grid-template-columns:1fr} }
    </style>

    <style>
        /* ====== Dark palette (scoped trong QR block) ====== */
        .qrpay{
            /* tokens cho dark */
            --qr-radius:14px;
            --qr-border:#2a2f37;          /* viền tối */
            --qr-muted:#9aa4b2;           /* chữ phụ */
            --qr-text:#e5e7eb;            /* chữ chính */
            --qr-shadow:0 10px 30px rgba(0,0,0,.45);
            --qr-primary:#f59e0b;         /* brand primary (orange) */
            --qr-ring: rgba(245,158,11,.18);
            --qr-bg:#0f1115;              /* nền tổng thể */
            --qr-panel:#111318;           /* panel */
            --qr-panel-2:#0c0f14;         /* panel phụ/badge */
        }

        /* Panel ngoài */
        .qrpay{
            background:var(--qr-panel);
            border:1px solid var(--qr-border);
            border-radius:var(--qr-radius);
            box-shadow:var(--qr-shadow);
            padding:18px;
            color:var(--qr-text);
        }
        .qrpay-grid{display:grid;grid-template-columns:1fr 1fr;gap:22px}
        .qrpay-col{min-width:0}

        /* QR box */
        .qrpay-qr{
            position:relative;
            border:1px solid var(--qr-border);
            border-radius:12px;
            overflow:hidden;
            cursor:zoom-in;
            background:var(--qr-panel-2);
        }
        .qrpay-qr img{
            display:block;width:100%;max-width:360px;margin:auto;
            aspect-ratio:1/1;object-fit:contain
        }
        .qrpay-zoomhint{
            position:absolute;right:8px;bottom:8px;
            background:var(--qr-panel);
            color:var(--qr-muted);
            border:1px solid var(--qr-border);
            border-radius:999px;
            font-size:.85rem;padding:6px 10px;
            box-shadow:var(--qr-shadow)
        }

        /* Bank info */
        .qrpay-bank{
            list-style:none;margin:14px 0 0;padding:0;
            border:1px dashed var(--qr-border);
            border-radius:12px;
        }
        .qrpay-bank li{display:flex;align-items:center;gap:10px;padding:10px 12px}
        .qrpay-bank li+li{border-top:1px dashed var(--qr-border)}
        .qrpay-bank span{color:var(--qr-muted);width:110px;flex:0 0 110px}
        .qrpay-bank strong{color:var(--qr-text)}
        .qrpay-rowcopy strong{flex:1}

        /* Input copy */
        .qrpay-label{display:block;margin:2px 0 8px;font-weight:600;color:var(--qr-text)}
        .qrpay-inputcopy{display:flex;gap:10px;align-items:stretch}
        .qrpay-inputcopy input{
            flex:1;border:1px solid var(--qr-border);border-radius:12px;padding:12px;
            background:var(--qr-panel-2);color:var(--qr-text);
        }
        .qrpay-inputcopy input::placeholder{color:#7b8696}
        .qrpay-inputcopy input:focus{
            outline:none;border-color:var(--qr-primary);box-shadow:0 0 0 4px var(--qr-ring)
        }

        /* Buttons */
        .qr-btn{border:1px solid transparent;border-radius:12px;padding:10px 14px;cursor:pointer;white-space:nowrap;transition:.18s}
        .qr-btn-primary{background:var(--qr-primary);color:#0b0d10}
        .qr-btn-ghost{background:transparent;border-color:var(--qr-border);color:var(--qr-text)}
        .qr-btn:hover{filter:brightness(.98)}
        .qr-btn.is-copied{background:#16a34a;color:#0b0d10;border-color:transparent}

        /* Note */
        .qrpay-note{
            margin-top:16px;border:1px solid var(--qr-border);
            border-radius:12px;padding:12px 14px;background:var(--qr-panel-2)
        }
        .qrpay-note-title{font-weight:700;margin-bottom:6px;color:var(--qr-text)}
        .qrpay-note-list{padding-left:18px;margin:0;color:#cbd5e1}
        .qrpay-note-list li{margin:6px 0}

        /* Modal */
        .qrpay-modal{position:fixed;inset:0;display:none}
        .qrpay-modal.is-open{display:block}
        .qrpay-backdrop{position:absolute;inset:0;background:rgba(0,0,0,.65)}
        .qrpay-modal-body{position:absolute;inset:0;display:grid;place-items:center;padding:24px}
        .qrpay-modal-body img{
            max-width:min(92vw,640px);max-height:82vh;
            border-radius:12px;background:var(--qr-panel);border:1px solid var(--qr-border)
        }
        .qrpay-close{
            position:absolute;top:16px;right:16px;width:40px;height:40px;
            border-radius:999px;border:1px solid var(--qr-border);
            background:var(--qr-panel);color:var(--qr-text);
            box-shadow:var(--qr-shadow);font-size:22px;line-height:1;cursor:pointer
        }

        /* Toast */
        .qrpay-toast{
            position:fixed;left:50%;bottom:24px;transform:translateX(-50%);
            background:#0b0d10;color:#e5e7eb;
            padding:10px 14px;border-radius:999px;
            box-shadow:var(--qr-shadow);border:1px solid var(--qr-border)
        }
        .qrpay-toast[hidden]{display:none}

        /* Responsive */
        @media (max-width: 900px){
            .qrpay-grid{grid-template-columns:1fr}
        }

        /* Optional: hover viền nhẹ cho các block có border */
        .qrpay-qr:hover,
        .qrpay-note:hover,
        .qrpay-bank:hover{ border-color:#36404b }
    </style>

    <style>
        /* --- QR bank list fix --- */
        .qrpay-bank li{
            display:flex; align-items:center; gap:12px;
            padding:10px 12px;
            min-width:0;                 /* cho phép con co lại trong flex */
        }

        .qrpay-bank span{
            color:var(--qr-muted);
            flex:0 0 116px;              /* tăng bề rộng nhãn để không xuống dòng */
            white-space:nowrap;          /* cấm wrap: "Chủ tài khoản" giữ 1 dòng */
        }

        .qrpay-bank strong{
            color:var(--qr-text);
        }

        /* dòng có nút "Sao chép" */
        .qrpay-rowcopy strong{
            flex:1 1 auto;               /* phần số tài khoản chiếm phần còn lại */
            min-width:0;                 /* cho phép co */
            overflow:hidden;             /* tránh tràn */
            text-overflow:ellipsis;      /* … nếu quá dài */
            white-space:nowrap;
        }
        .qrpay-rowcopy .qr-btn{
            flex:0 0 auto;               /* không co/giãn gây tràn */
            margin-left:8px;
        }

        /* optional: đồng bộ chiều cao nút */
        .qrpay-bank .qr-btn{ height:36px; padding:0 12px; }

        /* responsive: thu hẹp nhãn trên màn bé để vẫn 1 dòng */
        @media (max-width: 480px){
            .qrpay-bank span{ flex-basis: 130px; }
        }
    </style>

    <style>
        /* Nhãn 1 dòng, rộng cố định */
        .qrpay-bank span{
            color:var(--qr-muted);
            flex:0 0 124px;
            white-space:nowrap;
        }

        /* Dòng số tài khoản: luôn 1 hàng, cho phép trượt ngang nếu quá chật */
        .qrpay-rowcopy{
            display:flex; align-items:center; gap:10px;
            flex-wrap:nowrap;               /* giữ cùng 1 hàng */
            overflow-x:auto;                /* màn siêu hẹp thì kéo ngang */
            padding:10px 12px;
            scrollbar-width:none;           /* ẩn thanh cuộn Firefox (tùy thích) */
        }
        .qrpay-rowcopy::-webkit-scrollbar{ display:none; } /* ẩn trên WebKit */

        /* Số tài khoản hiển thị trọn vẹn */
        .qrpay-rowcopy strong{
            flex:1 0 auto;                  /* chiếm tối đa không bị ép */
            white-space:nowrap;             /* không xuống dòng */
            min-width:max-content;          /* đủ rộng theo nội dung */
            color:var(--qr-text);
        }

        /* Nút icon copy gọn */
        .qr-icon-btn{
            flex:0 0 auto;
            width:34px; height:34px;
            border-radius:10px;
            border:1px solid var(--qr-border);
            background:var(--qr-panel-2);
            color:var(--qr-text);
            display:inline-grid; place-items:center;
            transition:border-color .15s, background .15s;
        }
        .qr-icon-btn:hover{ border-color:#36404b; }
        .qr-icon-btn.is-copied{
            border-color:#16a34a; background:#0f2a18; color:#16a34a;
        }
        .qr-icon-btn svg{ width:18px; height:18px; display:block; }

    </style>

    <style>
        /* Trạng thái bình thường của nút icon */
        .qr-icon-btn { color: var(--qr-text); border-color: var(--qr-border); }

        /* Khi đã copy: chỉ đổi màu (và viền nếu muốn) */
        .qr-icon-btn.is-copied {
            color: #16a34a;               /* xanh lá */
            border-color: #16a34a;        /* tùy chọn */
            background: rgba(22,163,74,.08); /* tùy chọn */
        }

        /* Đảm bảo SVG nhận màu từ currentColor */
        .qr-icon-btn svg { stroke: currentColor; fill: none; }
    </style>
@endsection

@section('content')
    <main ng-controller="CheckoutController">

        <!-- breadcrumb start -->
        <section class="pt-60p">
            <div class="section-pt">
                <div
                    class="relative bg-cover bg-no-repeat rounded-24 overflow-hidden" style="background-image: url({{ $banner->image->path ?? '' }})">
                    <div class="container">
                        <div class="grid grid-cols-12 gap-30p relative  py-20 z-[2]">
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
                    <div class="overlay-11"></div>
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
                                    <div class="qrpay">
                                        <div class="qrpay-grid">
                                            <!-- CỘT TRÁI: QR + THÔNG TIN NGÂN HÀNG -->
                                            <div class="qrpay-col">
                                                <div class="qrpay-qr" role="button" tabindex="0" aria-label="Phóng to mã QR">
                                                    <img src="{{ $config->qr->path ?? '' }}" alt="Mã QR thanh toán">
                                                    <div class="qrpay-zoomhint">Nhấn để phóng to</div>
                                                </div>

                                                <ul class="qrpay-bank">
                                                    <li><span>Ngân hàng:</span><strong>{{ $config->nganhang }}</strong></li>
                                                    <li><span>Chủ tài khoản:</span><strong>{{ $config->chutaikhoan }}</strong></li>
                                                    <li class="qrpay-rowcopy">
                                                        <span>Số tài khoản:</span>
                                                        <strong id="acc-number">{{ $config->sotaikhoan }}</strong>
                                                        <button class="qr-icon-btn qr-copy" data-source="#acc-number" aria-label="Sao chép" title="Sao chép">
                                                            <!-- icon copy -->
                                                            <svg viewBox="0 0 24 24" fill="none" width="18" height="18" aria-hidden="true">
                                                                <rect x="9" y="9" width="11" height="11" rx="2" stroke="currentColor" stroke-width="2"/>
                                                                <rect x="4" y="4" width="11" height="11" rx="2" stroke="currentColor" stroke-width="2"/>
                                                            </svg>
                                                        </button>
                                                    </li>
                                                    <li><span>Chi nhánh:</span><strong>{{ $config->chinhanh }}</strong></li>
                                                </ul>
                                            </div>

                                            <!-- CỘT PHẢI: NỘI DUNG CK + GHI CHÚ -->
                                            <div class="qrpay-col">
                                                <label for="qrpay-content" class="qrpay-label">Chuyển khoản tiền đặt cọc với nội dung</label>
                                                <div class="qrpay-inputcopy">
                                                    <input id="qrpay-content" type="text" readonly
                                                           value="{{ $order->code  }}">
                                                    <button class="qr-btn qr-btn-primary qr-copy" data-source="#qrpay-content">Sao chép</button>
                                                </div>

                                                <div class="qrpay-note">
                                                    <div class="qrpay-note-title">Ghi chú</div>
                                                    <ul class="qrpay-note-list">
                                                        <li>{{ $config->notedatcoc }}</li>
                                                        <li>Quét đúng mã QR; kiểm tra lại tên người nhận trước khi thanh toán.</li>
                                                        <li>Ghi <b>đúng nội dung</b> để hệ thống tự khớp đơn hàng.</li>
                                                    </ul>
                                                </div>

                                                <div class="qrpay-actions" style="margin-top: 10px">
                                                    <button ng-click="submitOrder()"
                                                            id="btn-confirm-pay"
                                                            class="qr-btn qr-btn-primary"
                                                    >
                                                        Xác nhận thanh toán
                                                    </button>
                                                </div>


                                            </div>
                                        </div>

                                        <!-- MODAL PHÓNG TO QR -->
                                        <div class="qrpay-modal" aria-hidden="true">
                                            <div class="qrpay-backdrop"></div>
                                            <div class="qrpay-modal-body">
                                                <img src="{{ $config->qr->path ?? '' }}" alt="QR phóng to">
                                                <button class="qrpay-close" aria-label="Đóng">×</button>
                                            </div>
                                        </div>

                                        <!-- TOAST COPY -->
                                        <div class="qrpay-toast" hidden>Đã sao chép</div>





                                    </div>



                                    <script>
                                        (function(){
                                            // Copy helper
                                            function copyFromSource(selector){
                                                const el = document.querySelector(selector);
                                                if(!el) return false;
                                                const text = (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') ? el.value : el.textContent.trim();
                                                if(navigator.clipboard && window.isSecureContext){
                                                    return navigator.clipboard.writeText(text);
                                                }else{
                                                    const ta = document.createElement('textarea');
                                                    ta.value = text; ta.style.position='fixed'; ta.style.opacity='0';
                                                    document.body.appendChild(ta); ta.select();
                                                    const ok = document.execCommand('copy'); document.body.removeChild(ta);
                                                    return ok ? Promise.resolve() : Promise.reject();
                                                }
                                            }
                                            function showToast(msg){
                                                const t = document.querySelector('.qrpay-toast');
                                                if(!t) return;
                                                t.textContent = msg || 'Đã sao chép';
                                                t.hidden = false;
                                                clearTimeout(showToast._t); showToast._t = setTimeout(()=> t.hidden = true, 1500);
                                            }

                                            // Event: copy buttons
                                            document.addEventListener('click', function (e) {
                                                const btn = e.target.closest('.qr-copy');
                                                if (!btn) return;

                                                e.preventDefault();
                                                const sel = btn.getAttribute('data-source');

                                                copyFromSource(sel).then(() => {
                                                    // chỉ đổi màu icon bằng class
                                                    btn.classList.add('is-copied');
                                                    setTimeout(() => btn.classList.remove('is-copied'), 1000);
                                                });
                                            });


                                            // Modal open/close
                                            const modal = document.querySelector('.qrpay-modal');
                                            const qrBox = document.querySelector('.qrpay-qr');
                                            const closeBtn = document.querySelector('.qrpay-close');
                                            if(qrBox && modal){
                                                const open = ()=> modal.classList.add('is-open');
                                                const close = ()=> modal.classList.remove('is-open');
                                                qrBox.addEventListener('click', open);
                                                qrBox.addEventListener('keydown', (e)=>{ if(e.key==='Enter' || e.key===' '){ e.preventDefault(); open(); }});
                                                modal.addEventListener('click', (e)=>{ if(e.target.classList.contains('qrpay-backdrop')) close(); });
                                                if(closeBtn) closeBtn.addEventListener('click', close);
                                                document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') modal.classList.remove('is-open'); });
                                            }
                                        })();
                                    </script>

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
                                                         alt="product" />
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
                {{ formatCurrency($order->total_after_discount) }}₫
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
    <script>
        app.controller('CheckoutController', function($scope, $http) {
            {{--$scope.cart = @json($cartCollection);--}}
                {{--console.log($scope.cart);--}}
                {{--$scope.total = @json($total);--}}
                $scope.loading = false;

            $scope.form = {
                order_code: "{{ $order->code }}",
                total: {{ $order->total_after_discount }},
            }

            $scope.submitOrder = function() {
                $scope.loading = true;
                let data = $scope.form;
                data.items = $scope.cart;

                $scope.errors = {};
                $.ajax({
                    url: '{{ route('cart.submitqr.order') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    data: JSON.stringify(data),
                    contentType: 'application/json',
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = '{{route('cart.checkout.success')}}?method=cod';
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
@endpush
