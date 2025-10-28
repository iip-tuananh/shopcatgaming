@php
    // Lấy danh sách type (nếu không có thì mảng rỗng)
    $types = collect(isset($product->types) ? $product->types : []);

    // Map về cặp giá hợp lệ rồi filter bỏ các type không có price
    $rows = $types->map(function ($t) {
        $p = (int) (isset($t->price) ? $t->price : 0);
        $b = (int) (isset($t->base_price) ? $t->base_price : 0);

        return [
            'p' => ($p > 0) ? $p : null,
            'b' => ($b > 0 && $b > $p) ? $b : null, // chỉ giữ base_price khi > price
        ];
    })->filter(function ($r) {
        return !is_null($r['p']);
    })->values();

    if ($rows->count() > 0) {
        $minPrice = $rows->pluck('p')->min();
        $maxPrice = $rows->pluck('p')->max();

        // base_price min–max (nếu có)
        $baseList = $rows->pluck('b')->filter(function ($v) {
            return !is_null($v);
        });
        $minBase  = $baseList->count() ? $baseList->min() : null;
        $maxBase  = $baseList->count() ? $baseList->max() : null;
    } else {
        // Không có phân loại hợp lệ → dùng giá sản phẩm
        $minPrice = (int) (isset($product->price) ? $product->price : 0);
        $maxPrice = $minPrice;

        $baseProd = (int) (isset($product->base_price) ? $product->base_price : 0);
        $minBase  = ($baseProd > $minPrice) ? $baseProd : null;
        $maxBase  = $minBase;
    }
@endphp



<article class="product-card">
    <a href="{{ route('front.getProductDetail', $product->slug) }}" class="pc-thumb">
        <img src="{{ $product->image->path ?? '' }}" alt="{{ $product->name }}">
    </a>
    <div class="pc-body">
        <h3 class="pc-name"><a href="{{ route('front.getProductDetail', $product->slug) }}">{{ $product->name }}</a></h3>

        <div class="pc-deal-row">
            @if($minPrice > 0)
                <div class="pc-price-pill">
      <span class="now">
        @if($minPrice !== $maxPrice)
              {{ formatCurrency($minPrice) }} - {{ formatCurrency($maxPrice) }}
          @else
              {{ formatCurrency($minPrice) }}
          @endif
        <span class="pc-currency">VND</span>
      </span>
                </div>
            @else
                <div class="pc-price-pill is-contact">
                    <span class="now">Liên hệ</span>
                </div>
            @endif
        </div>


    </div>
</article>
