{{-- resources/views/emails/orders/confirmed.blade.php --}}
@php
    // Hàm định dạng tiền (tránh phụ thuộc helper ngoài)
    $fmt = function($n){ return number_format((float)$n, 0, ',', '.') . '₫'; };
@endphp
    <!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>{{$config->web_title}} - Đặt hàng thành công #{{ $data->code }}</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        /* Một chút CSS cơ bản, phần lớn style đã inline để tương thích email client */
        @media only screen and (max-width: 620px){
            .container{width:100% !important}
            .px{padding-left:16px !important;padding-right:16px !important}
            .full{display:block !important;width:100% !important}
            .text-right{ text-align:left !important }
        }
        a{ color:#111111; }
    </style>

    <style type="text/css">
        @media only screen and (max-width: 600px) {
            /* mỗi khối chiếm 100% chiều ngang, xếp dọc */
            td.full {
                display: block !important;
                width: 100% !important;
            }

            /* Khối customer */
            td.full:first-child {
                padding: 0 0 12px 0 !important; /* dưới cách 12px */
            }

            /* Khối payment (cái thứ 2) */
            td.full + td.full {
                padding: 12px 0 0 0 !important; /* trên cách 12px, bỏ padding-left */
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;background:#fff7e0;">
<table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background:#fff7e0;">
    <tr>
        <td align="center" style="padding:24px 8px;">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="container" style="width:600px;max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #f1e3bd;">
                <!-- Header -->
                <tr>
                    <td class="px" style="padding:18px 20px;background:#feae34;">
                        <table role="presentation" width="100%">
                            <tr>
                                <td align="left" style="font:700 18px/1.2 Arial,Helvetica,sans-serif;color:#111111;">
                                    Xác nhận đơn hàng
                                </td>
                                <td align="right" style="font:600 14px Arial,Helvetica,sans-serif;color:#111111;">
                                    Mã đơn: #{{ $data->code }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Intro -->
                <tr>
                    <td class="px" style="padding:18px 20px;">
                        <p style="margin:0 0 8px;font:700 20px Arial,Helvetica,sans-serif;color:#111111;">Đặt hàng thành công</p>
                        <p style="margin:0;font:400 14px Arial,Helvetica,sans-serif;color:#374151;">
                            Cảm ơn <strong>{{ $data->customer_name }}</strong> đã mua hàng.
                            Email xác nhận được gửi tới <strong>{{ $data->customer_email }}</strong>.
                        </p>
                    </td>
                </tr>

                <!-- Customer + Payment -->
                <tr>
                    <td class="px" style="padding:0 20px 6px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0 12px;">
                            <tr>
                                <!-- Customer -->
                                <td class="full" valign="top" style="width:50%;padding:0;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee7cc;border-radius:10px;">
                                        <tr>
                                            <td style="padding:12px 14px;background:#fffdf4;border-bottom:1px solid #eee7cc;font:700 14px Arial;color:#111111;border-radius:10px 10px 0 0;">
                                                Thông tin khách hàng
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:12px 14px;font:400 14px Arial,Helvetica,sans-serif;color:#111111;">
                                                <div style="margin-bottom:6px;">
                                                    <span style="color:#6b7280;">Họ và tên:</span>
                                                    <strong>{{ $data->customer_name }}</strong>
                                                </div>
                                                <div style="margin-bottom:6px;">
                                                    <span style="color:#6b7280;">Email:</span>
                                                    {{ $data->customer_email }}
                                                </div>
                                                <div>
                                                    <span style="color:#6b7280;">Địa chỉ:</span>
                                                    {{ $data->customer_address }}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>

                                <!-- Payment -->
                                <td class="full" valign="top" style="width:50%;padding:0 0 0 12px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee7cc;border-radius:10px;">
                                        <tr>
                                            <td style="padding:12px 14px;background:#fffdf4;border-bottom:1px solid #eee7cc;font:700 14px Arial;color:#111111;border-radius:10px 10px 0 0;">
                                                Thanh toán & tổng tiền
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:12px 14px;font:400 14px Arial,Helvetica,sans-serif;color:#111111;">
                                                <div style="margin-bottom:6px;">
                                                    <span style="color:#6b7280;">Phương thức:</span>
                                                    <strong>   {{ $data->payment_method == 1 ? 'Thanh toán khi nhận hàng - COD' : 'Chuyển khoản ngân hàng'}}</strong>
                                                </div>
                                                <div style="margin-bottom:6px;">
                                                    <span style="color:#6b7280;">Tạm tính:</span>
                                                    {{ $fmt($data->total_before_discount) }}
                                                </div>

                                                <div style="margin-bottom:6px;">
                                                    <span style="color:#6b7280;">Phí ship:</span>
                                                    {{ $fmt($data->ship_cost) }}
                                                </div>

                                                <div>
                                                    <span style="color:#6b7280;">Tổng thanh toán:</span>
                                                    <strong>{{ $fmt($data->total_after_discount) }}</strong>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Items table -->
                <tr>
                    <td class="px" style="padding:6px 20px 16px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #eee7cc;border-radius:10px;">
                            <tr>
                                <td style="padding:12px 14px;background:#fffdf4;border-bottom:1px solid #eee7cc;font:700 14px Arial;color:#111111;border-radius:10px 10px 0 0;">
                                    Chi tiết đơn hàng
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:0 14px 14px;">
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:separate;border-spacing:0 8px;">
                                        <thead>
                                        <tr>
                                            <th align="left" style="padding:10px 8px;background:#feae34;color:#111111;font:700 12px Arial,Helvetica,sans-serif;text-transform:uppercase;border-radius:6px 0 0 6px;">Sản phẩm</th>
                                            <th align="center" style="padding:10px 8px;background:#feae34;color:#111111;font:700 12px Arial;text-transform:uppercase;">SL</th>
                                            <th align="right" class="text-right" style="padding:10px 8px;background:#feae34;color:#111111;font:700 12px Arial;text-transform:uppercase;border-radius:0 6px 6px 0;">Thành tiền</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $items = $data->details;
                                        ?>
                                        @foreach($items as $item)
                                            <tr>
                                                <td style="background:#ffffff;border:1px solid #f0ead7;border-right:0;border-radius:8px 0 0 8px;padding:10px 8px;">
                                                    <table role="presentation" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            @php

                                                                $imgPath = $item->product && $item->product->image ? $item->product->image->path : null;

                                                                $imgUrl = $imgPath
                                                                    ? (Str::startsWith($imgPath, ['http://','https://']) ? $imgPath : url(ltrim($imgPath, '/')))
                                                                    : asset('site/image/no-image.png');
                                                            @endphp

                                                            <td valign="top" style="padding-right:10px;">
                                                                <img src="{{ $imgUrl }}"
                                                                     alt="{{ $item->product->name }}"
                                                                     width="56" height="56"
                                                                     style="display:block;width:56px;height:56px;border-radius:6px;border:1px solid #eee7cc;object-fit:cover;">
                                                            </td>
                                                            <td valign="top" style="font:600 14px Arial,Helvetica,sans-serif;color:#111111;">
                                                                {{ $item->product->name }}      <br>
                                                                <span style="font-size:14px;color:#999">
                                                                        {{ $item->type }}
                                                                    </span>
                                                                <br>
                                                                <span style="font-size:14px;color:#999">
                                                                        {{ $item->attributes }}
                                                                    </span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td align="center" style="background:#ffffff;border-top:1px solid #f0ead7;border-bottom:1px solid #f0ead7;padding:10px 8px;font:600 14px Arial,Helvetica,sans-serif;color:#111111;">
                                                    {{$item->qty}}
                                                </td>
                                                <td align="right" style="background:#ffffff;border:1px solid #f0ead7;border-left:0;border-radius:0 8px 8px 0;padding:10px 8px;font:700 14px Arial,Helvetica,sans-serif;color:#111111;">
                                                    {{number_format($item->price * $item->qty)}} đ
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <!-- Grand total (nhắc lại) -->
                                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:8px;">
                                        <tr>
                                            <td align="right" style="font:700 16px Arial,Helvetica,sans-serif;color:#111111;">
                                                Tổng cộng: {{ $fmt($data->total_after_discount) }}
                                            </td>
                                        </tr>
                                    </table>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- CTA -->


                <!-- Footer -->
                <tr>
                    <td style="padding:14px 20px;background:#fffdf4;border-top:1px solid #f1e3bd;font:12px Arial,Helvetica,sans-serif;color:#6b7280;border-radius:0 0 12px 12px;">
                        Email được gửi từ hệ thống đặt hàng. Vui lòng không trả lời email này.
                        @if(!empty($config->email))
                            Hỗ trợ: <a href="mailto:{{ $config->email }}" style="color:#6b7280">{{ $config->email }}</a>
                        @endif
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
