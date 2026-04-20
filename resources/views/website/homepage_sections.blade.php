{{--
    Homepage Sections Partial
    Included in any home view that receives $hpSections.
    Each section only renders if it has at least one active item.
--}}

@php
    use Carbon\Carbon;
    $hp = $hpSections ?? [];
@endphp

{{-- ================================================================
     TODAY'S DEAL
     ================================================================ --}}
@if(!empty($hp['today_deal']) && $hp['today_deal']->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Today's Deal</h4>
        </header>
        <div class="row g-2">
            @foreach($hp['today_deal'] as $deal)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card h-100 border-0 shadow-sm">
                    @if($deal->image)
                    <a href="{{ $deal->link ?: '#' }}">
                        <img src="{{ asset('product/thumbnail/'.$deal->image) }}"
                             class="card-img-top img-fluid"
                             style="object-fit:cover; height:160px;"
                             alt="{{ $deal->title }}">
                    </a>
                    @endif
                    <div class="card-body p-2 text-center">
                        @if($deal->title)
                            <p class="mb-1 fw-bold text-truncate">{{ $deal->title }}</p>
                        @endif
                        @if($deal->description)
                            <small class="text-muted">{{ Str::limit($deal->description, 60) }}</small>
                        @endif
                        @if($deal->link)
                            <a href="{{ $deal->link }}" class="btn btn-sm btn-warning mt-2 w-100">View Deal</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     BANNER LEVEL 1
     ================================================================ --}}
@if(!empty($hp['banner_1']) && $hp['banner_1']->count())
<section class="section-name py-2">
    <div class="container">
        <div class="row g-2">
            @foreach($hp['banner_1'] as $banner)
            <div class="{{ $hp['banner_1']->count() === 1 ? 'col-12' : 'col-md-6' }}">
                <a href="{{ $banner->link ?: '#' }}">
                    <img src="{{ asset('product/thumbnail/'.$banner->image) }}"
                         class="img-fluid w-100 rounded"
                         style="object-fit:cover; max-height:350px; object-position:center;"
                         alt="{{ $banner->title }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     FLASH DEALS
     ================================================================ --}}
@if(!empty($hp['flash_deal']) && $hp['flash_deal']->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title text-danger">⚡ Flash Deals</h4>
        </header>
        <div class="row g-2">
            @foreach($hp['flash_deal'] as $deal)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card h-100 border-danger border position-relative">
                    @if($deal->image)
                    <a href="{{ $deal->link ?: '#' }}">
                        <img src="{{ asset('product/thumbnail/'.$deal->image) }}"
                             class="card-img-top img-fluid"
                             style="object-fit:cover; height:160px;"
                             alt="{{ $deal->title }}">
                    </a>
                    @endif
                    <div class="card-body p-2 text-center">
                        @if($deal->title)
                            <p class="mb-1 fw-bold text-truncate">{{ $deal->title }}</p>
                        @endif
                        @if($deal->countdown_end && $deal->countdown_end->isFuture())
                            <div class="flash-countdown text-danger fw-bold small"
                                 data-ends="{{ $deal->countdown_end->toIso8601String() }}">
                                <span class="countdown-display">Loading…</span>
                            </div>
                        @endif
                        @if($deal->link)
                            <a href="{{ $deal->link }}" class="btn btn-sm btn-danger mt-2 w-100">Grab Now</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     FEATURED PRODUCTS
     ================================================================ --}}
@php
    $featuredProducts = collect();
    if(!empty($hp['featured_product'])){
        foreach($hp['featured_product'] as $hpItem){
            if($hpItem->product) $featuredProducts->push($hpItem->product);
        }
    }
@endphp
@if($featuredProducts->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Featured Products</h4>
        </header>
        <div class="row g-0">
            @foreach($featuredProducts as $product)
            <div class="col-md-2 col-4 mb-4">
                <div class="card card-product-grid product-box-2 h-100">
                    <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                        <img class="img-fit lazyload"
                             src="{{ asset('product/thumbnail/default.jpg') }}"
                             data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                             alt="{{ $product->productName }}">
                    </a>
                    <div class="card-body info-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">{{ $product->productName }}</a>
                        <div class="price mt-auto text-center">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-success btn-sm btn-block mt-3" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-2"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     BANNER LEVEL 2
     ================================================================ --}}
@if(!empty($hp['banner_2']) && $hp['banner_2']->count())
<section class="section-name py-2">
    <div class="container">
        <div class="row g-2">
            @foreach($hp['banner_2'] as $banner)
            <div class="{{ $hp['banner_2']->count() === 1 ? 'col-12' : 'col-md-6' }}">
                <a href="{{ $banner->link ?: '#' }}">
                    <img src="{{ asset('product/thumbnail/'.$banner->image) }}"
                         class="img-fluid w-100 rounded"
                         style="object-fit:cover; max-height:350px; object-position:center;"
                         alt="{{ $banner->title }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     BEST SELLING PRODUCTS
     ================================================================ --}}
@php
    $bestSellingProducts = collect();
    if(!empty($hp['best_selling'])){
        foreach($hp['best_selling'] as $hpItem){
            if($hpItem->product) $bestSellingProducts->push($hpItem->product);
        }
    }
@endphp
@if($bestSellingProducts->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Best Selling Products</h4>
        </header>
        <div class="row g-0">
            @foreach($bestSellingProducts as $product)
            <div class="col-md-2 col-4 mb-4">
                <div class="card card-product-grid product-box-2 h-100">
                    <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                        <img class="img-fit lazyload"
                             src="{{ asset('product/thumbnail/default.jpg') }}"
                             data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                             alt="{{ $product->productName }}">
                    </a>
                    <div class="card-body info-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">{{ $product->productName }}</a>
                        <div class="price mt-auto text-center">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-success btn-sm btn-block mt-3" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-2"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     NEW PRODUCTS
     ================================================================ --}}
@php
    $newProducts = collect();
    if(!empty($hp['new_product'])){
        foreach($hp['new_product'] as $hpItem){
            if($hpItem->product) $newProducts->push($hpItem->product);
        }
    }
@endphp
@if($newProducts->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">New Arrivals</h4>
        </header>
        <div class="row g-0">
            @foreach($newProducts as $product)
            <div class="col-md-2 col-4 mb-4">
                <div class="card card-product-grid product-box-2 h-100 position-relative">
                    <span class="badge bg-success position-absolute" style="top:8px;left:8px;z-index:1;">New</span>
                    <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                        <img class="img-fit lazyload"
                             src="{{ asset('product/thumbnail/default.jpg') }}"
                             data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                             alt="{{ $product->productName }}">
                    </a>
                    <div class="card-body info-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">{{ $product->productName }}</a>
                        <div class="price mt-auto text-center">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-success btn-sm btn-block mt-3" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-2"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     BANNER LEVEL 3
     ================================================================ --}}
@if(!empty($hp['banner_3']) && $hp['banner_3']->count())
<section class="section-name py-2">
    <div class="container">
        <div class="row g-2">
            @foreach($hp['banner_3'] as $banner)
            <div class="{{ $hp['banner_3']->count() === 1 ? 'col-12' : 'col-md-6' }}">
                <a href="{{ $banner->link ?: '#' }}">
                    <img src="{{ asset('product/thumbnail/'.$banner->image) }}"
                         class="img-fluid w-100 rounded"
                         style="object-fit:cover; max-height:350px; object-position:center;"
                         alt="{{ $banner->title }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     COUPON SECTION
     ================================================================ --}}
@if(!empty($hp['coupon']) && $hp['coupon']->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Special Coupons</h4>
        </header>
        <div class="row g-3">
            @foreach($hp['coupon'] as $coupon)
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    @if($coupon->image)
                    <a href="{{ $coupon->link ?: '#' }}">
                        <img src="{{ asset('product/thumbnail/'.$coupon->image) }}"
                             class="card-img-top img-fluid"
                             style="object-fit:cover; height:140px;"
                             alt="{{ $coupon->title }}">
                    </a>
                    @endif
                    <div class="card-body text-center py-2">
                        @if($coupon->title)
                            <h6 class="mb-1">{{ $coupon->title }}</h6>
                        @endif
                        @if($coupon->coupon_code)
                            <div class="border border-dashed rounded p-2 my-2 fw-bold text-primary" style="letter-spacing:2px; border-style:dashed !important;">
                                {{ $coupon->coupon_code }}
                            </div>
                        @endif
                        @if($coupon->description)
                            <small class="text-muted">{{ $coupon->description }}</small>
                        @endif
                        @if($coupon->countdown_end && $coupon->countdown_end->isFuture())
                            <div class="flash-countdown text-danger small mt-1 fw-bold"
                                 data-ends="{{ $coupon->countdown_end->toIso8601String() }}">
                                <span class="countdown-display">Expires soon</span>
                            </div>
                        @endif
                        @if($coupon->link)
                            <a href="{{ $coupon->link }}" class="btn btn-sm btn-outline-primary mt-2 w-100">Use Coupon</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     CATEGORY WISE PRODUCTS
     ================================================================ --}}
@if(!empty($hp['category_wise']) && $hp['category_wise']->count())
@foreach($hp['category_wise'] as $catItem)
@php
    $cwCategory = $catItem->category ?? null;
    if(!$cwCategory) continue;
    $cwProducts = \App\Product::with('media','categories')
        ->whereHas('categories', function($q) use ($cwCategory){
            $q->where('categories.id', $cwCategory->id);
        })
        ->where('status','Active')
        ->orderBy('created_at','DESC')
        ->limit(12)
        ->get();
@endphp
@if($cwProducts->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <a href="{{ url('category/'.$cwCategory->categorySlug) }}" class="btn btn-info btn-sm float-end rounded">View More</a>
            <h4 class="section-title">{{ $cwCategory->categoryName }}</h4>
        </header>
        <div class="row g-0">
            @foreach($cwProducts as $product)
            <div class="col-md-2 col-4 mb-4">
                <div class="card card-product-grid product-box-2 h-100">
                    <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                        <img class="img-fit lazyload"
                             src="{{ asset('product/thumbnail/default.jpg') }}"
                             data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                             alt="{{ $product->productName }}">
                    </a>
                    <div class="card-body info-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">{{ $product->productName }}</a>
                        <div class="price mt-auto text-center">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-success btn-sm btn-block mt-3" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-2"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endforeach
@endif

{{-- ================================================================
     CLASSIFIEDS
     ================================================================ --}}
@if(!empty($hp['classified']) && $hp['classified']->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Classifieds</h4>
        </header>
        <div class="row g-3">
            @foreach($hp['classified'] as $item)
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm h-100">
                    @if($item->image)
                    <a href="{{ $item->link ?: '#' }}">
                        <img src="{{ asset('product/thumbnail/'.$item->image) }}"
                             class="card-img-top img-fluid"
                             style="object-fit:cover; height:160px;"
                             alt="{{ $item->title }}">
                    </a>
                    @endif
                    <div class="card-body">
                        @if($item->title)
                            <h6 class="fw-bold">{{ $item->title }}</h6>
                        @endif
                        @if($item->description)
                            <p class="text-muted small mb-2">{{ Str::limit($item->description, 100) }}</p>
                        @endif
                        @if($item->link)
                            <a href="{{ $item->link }}" class="btn btn-sm btn-outline-secondary w-100">View Listing</a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     TOP SELLERS
     ================================================================ --}}
@php
    $topSellerProducts = collect();
    if(!empty($hp['top_seller'])){
        foreach($hp['top_seller'] as $hpItem){
            if($hpItem->product) $topSellerProducts->push($hpItem->product);
        }
    }
@endphp
@if($topSellerProducts->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Top Sellers</h4>
        </header>
        <div class="row g-0">
            @foreach($topSellerProducts as $product)
            <div class="col-md-2 col-4 mb-4">
                <div class="card card-product-grid product-box-2 h-100 position-relative">
                    <span class="badge bg-danger position-absolute" style="top:8px;left:8px;z-index:1;">🔥 Top</span>
                    <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                        <img class="img-fit lazyload"
                             src="{{ asset('product/thumbnail/default.jpg') }}"
                             data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                             alt="{{ $product->productName }}">
                    </a>
                    <div class="card-body info-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">{{ $product->productName }}</a>
                        <div class="price mt-auto text-center">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-success btn-sm btn-block mt-3" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-2"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     TOP BRANDS
     ================================================================ --}}
@if(!empty($hp['top_brand']) && $hp['top_brand']->count())
<section class="section-name bg padding-y-sm pt-0">
    <div class="container">
        <header class="section-heading mt-0">
            <h4 class="section-title">Top Brands</h4>
        </header>
        <div class="row justify-content-center align-items-center g-3">
            @foreach($hp['top_brand'] as $brand)
            <div class="col-6 col-md-2 text-center">
                @if($brand->link)
                <a href="{{ $brand->link }}">
                @endif
                    @if($brand->image)
                        <img src="{{ asset('product/thumbnail/'.$brand->image) }}"
                             class="img-fluid"
                             style="max-height:80px; object-fit:contain;"
                             alt="{{ $brand->title }}">
                    @else
                        <span class="fw-bold">{{ $brand->title }}</span>
                    @endif
                @if($brand->link)
                </a>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     Countdown timer script (shared for flash_deal & coupon)
     ================================================================ --}}
@push('js')
<script>
(function () {
    function pad(n) { return n < 10 ? '0' + n : n; }

    function tick() {
        document.querySelectorAll('.flash-countdown').forEach(function (el) {
            var ends = new Date(el.getAttribute('data-ends'));
            var now  = new Date();
            var diff = ends - now;
            var display = el.querySelector('.countdown-display');
            if (!display) return;

            if (diff <= 0) {
                display.textContent = 'Expired';
                return;
            }
            var h = Math.floor(diff / 3600000);
            var m = Math.floor((diff % 3600000) / 60000);
            var s = Math.floor((diff % 60000) / 1000);
            display.textContent = pad(h) + ':' + pad(m) + ':' + pad(s);
        });
    }

    tick();
    setInterval(tick, 1000);
}());
</script>
@endpush
