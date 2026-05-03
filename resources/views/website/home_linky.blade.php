@extends('website.layout')

@push('css')
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
<style>
/* -----------------------------------------------------------------------
   Linky-style Homepage – core styles
----------------------------------------------------------------------- */
.lk-section { padding: 28px 0 20px; }
.lk-section-title {
    font-size: 1.15rem; font-weight: 700; color: #222;
    margin-bottom: 16px; padding-left: 10px;
    border-left: 4px solid #f05; display: flex; align-items: center; gap: 8px;
}
.lk-section-title .view-all {
    font-size: .78rem; font-weight: 500; color: #f05; margin-left: auto;
    text-decoration: none; white-space: nowrap;
}
.lk-section-title .view-all:hover { text-decoration: underline; }

/* Hero Slider */
.lk-hero .carousel-item { height: 420px; }
.lk-hero .carousel-item img { height: 100%; width: 100%; object-fit: cover; }
@media(max-width:767px){ .lk-hero .carousel-item { height: 200px; } }

/* Category bar */
.lk-cat-bar { background: #fff; border-bottom: 1px solid #f0f0f0; padding: 14px 0; }
.lk-cat-scroll { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px; }
.lk-cat-scroll::-webkit-scrollbar { height: 4px; }
.lk-cat-scroll::-webkit-scrollbar-thumb { background: #ddd; border-radius: 2px; }
.lk-cat-item { display: flex; flex-direction: column; align-items: center; flex: 0 0 auto;
               text-decoration: none; color: #333; width: 80px; }
.lk-cat-item:hover .lk-cat-thumb { border-color: #f05; }
.lk-cat-item:hover span { color: #f05; }
.lk-cat-thumb { width: 60px; height: 60px; border-radius: 50%; overflow: hidden;
                border: 2px solid transparent; transition: border-color .2s; background: #f7f7f7; }
.lk-cat-thumb img { width: 100%; height: 100%; object-fit: cover; }
.lk-cat-item span { font-size: .7rem; text-align: center; margin-top: 4px;
                    line-height: 1.2; word-break: break-word; }

/* Product card */
.lk-prod-card { background: #fff; border: 1px solid #eee; border-radius: 8px;
                overflow: hidden; transition: box-shadow .2s, transform .2s;
                display: flex; flex-direction: column; height: 100%; }
.lk-prod-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,.10); transform: translateY(-3px); }
.lk-prod-card .lk-img-wrap { position: relative; overflow: hidden; background: #f9f9f9; }
.lk-prod-card .lk-img-wrap img { width: 100%; height: 180px; object-fit: cover;
                                  transition: transform .3s; display: block; }
.lk-prod-card:hover .lk-img-wrap img { transform: scale(1.05); }
.lk-prod-card .lk-card-body { padding: 10px; flex: 1; display: flex; flex-direction: column; }
.lk-prod-card .lk-prod-name { font-size: .82rem; font-weight: 600; color: #222;
                               display: -webkit-box; -webkit-line-clamp: 2;
                               -webkit-box-orient: vertical; overflow: hidden;
                               text-decoration: none; min-height: 36px; }
.lk-prod-card .lk-prod-name:hover { color: #f05; }
.lk-prod-card .lk-price { font-size: .95rem; font-weight: 700; color: #f05; margin: 6px 0; }
.lk-prod-card .lk-btn { margin-top: auto; width: 100%; font-size: .78rem;
                         padding: 6px 0; border-radius: 4px; }

/* Slick arrow overrides */
.lk-slider .slick-prev, .lk-slider .slick-next {
    width: 34px; height: 34px; background: #fff; border: 1px solid #ddd;
    border-radius: 50%; z-index: 2; box-shadow: 0 2px 8px rgba(0,0,0,.1);
    display: flex !important; align-items: center; justify-content: center;
}
.lk-slider .slick-prev { left: -14px; }
.lk-slider .slick-next { right: -14px; }
.lk-slider .slick-prev:before, .lk-slider .slick-next:before {
    color: #555; font-size: 16px;
}
.lk-slider .slick-track { display: flex; gap: 12px; }
.lk-slider .slick-slide { margin: 0 6px; height: auto; }
.lk-slider .slick-slide > div { height: 100%; }

/* Today's Deal badge */
.lk-hot-badge { background: #f05; color: #fff; font-size: .68rem;
                padding: 2px 7px; border-radius: 3px; }
.lk-deal-timer { font-size: .7rem; color: #f05; font-weight: 600; }

/* Category-wise tabs */
.lk-catwise { background: #f7f8fa; }
.lk-catwise-tabs { display: flex; gap: 8px; overflow-x: auto; padding-bottom: 4px;
                   margin-bottom: 20px; }
.lk-catwise-tabs::-webkit-scrollbar { height: 4px; }
.lk-catwise-tab { flex: 0 0 auto; display: flex; flex-direction: column; align-items: center;
                  gap: 4px; padding: 8px 16px; border: 2px solid transparent;
                  border-radius: 8px; cursor: pointer; background: #fff;
                  font-size: .8rem; font-weight: 600; color: #555; transition: all .2s; }
.lk-catwise-tab img { width: 44px; height: 44px; border-radius: 50%; object-fit: cover; }
.lk-catwise-tab.active, .lk-catwise-tab:hover { border-color: #f05; color: #f05; }
.lk-catwise-pane { display: none; }
.lk-catwise-pane.active { display: block; }

/* Coupon banner */
.lk-coupon-wrap { border-radius: 10px; overflow: hidden;
                  background: linear-gradient(135deg, #222 0%, #444 100%);
                  padding: 28px 32px; color: #fff; display: flex;
                  align-items: center; justify-content: space-between; gap: 20px; }
.lk-coupon-wrap h4 { font-size: 1.4rem; font-weight: 700; margin: 0 0 4px; }
.lk-coupon-wrap p  { font-size: .9rem; opacity: .85; margin: 0; }
.lk-coupon-wrap .coupon-code { font-size: 1.1rem; font-weight: 700;
                                border: 2px dashed rgba(255,255,255,.6);
                                padding: 6px 18px; border-radius: 6px;
                                letter-spacing: 2px; background: rgba(255,255,255,.1); }
</style>
@endpush

@section('content')
@php
    use App\Category;
    use App\Setting;
    $hp = $hpSections ?? [];
    $lang = app()->getLocale() === 'bn' ? 'bn' : 'en';
@endphp

{{-- ================================================================
     HERO SLIDER
================================================================ --}}
@if($slides->count())
<div class="lk-hero">
    <div id="lk-hero-carousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($slides as $k => $s)
            <li data-target="#lk-hero-carousel" data-slide-to="{{ $k }}" class="{{ $k==0?'active':'' }}"></li>
            @endforeach
        </ol>
        <div class="carousel-inner">
            @foreach($slides as $k => $s)
            <div class="carousel-item {{ $k==0?'active':'' }}">
                <a href="{{ $s->link ?: '#' }}">
                    <img src="{{ asset($s->image) }}" class="d-block w-100" alt="{{ $s->name }}">
                </a>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#lk-hero-carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#lk-hero-carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>
</div>
@endif

{{-- ================================================================
     CATEGORY ICON BAR
================================================================ --}}
@php $catBar = Category::where('status','Active')->orderBy('categoryName')->limit(16)->get(); @endphp
@if($catBar->count())
<div class="lk-cat-bar">
    <div class="container">
        <div class="lk-cat-scroll">
            @foreach($catBar as $cat)
            <a href="{{ url('shop?cat_id='.$cat->id) }}" class="lk-cat-item">
                <div class="lk-cat-thumb">
                    @if($cat->categoryImage)
                    <img src="{{ asset('product/thumbnail/'.$cat->categoryImage) }}" alt="{{ $cat->categoryName }}" loading="lazy">
                    @else
                    <img src="{{ asset('product/thumbnail/default.jpg') }}" alt="{{ $cat->categoryName }}">
                    @endif
                </div>
                <span>{{ Str::limit($cat->categoryName, 10) }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     TODAY'S DEAL  (horizontal ticker / scroll)
================================================================ --}}
@php
    $todayItems = collect();
    if(!empty($hp['today_deal'])) {
        foreach($hp['today_deal'] as $item) {
            if($item->product) $todayItems->push($item->product);
        }
    }
    // Fallback: load recent deals directly if none configured
    if($todayItems->isEmpty()) {
        $todayItems = \App\Product::with('media','categories')->inRandomOrder()->limit(10)->get();
    }
@endphp
@if($todayItems->count())
<div class="lk-section" style="background:#fff9f9;">
    <div class="container">
        <div class="lk-section-title">
            <span class="lk-hot-badge">HOT</span> Today's Deal
            <a href="{{ url('search?sort_by=newest') }}" class="view-all">View All »</a>
        </div>
        <div class="lk-slider" id="lk-deal-slider">
            @foreach($todayItems as $product)
            <div>
                <div class="lk-prod-card">
                    <div class="lk-img-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}">
                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                 class="lazyload" alt="{{ $product->productName }}">
                        </a>
                    </div>
                    <div class="lk-card-body">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                        <div class="lk-price">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-outline-danger lk-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-1"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     BANNER LEVEL 1
================================================================ --}}
@if(!empty($hp['banner_1']) && $hp['banner_1']->count())
<div class="container py-3">
    <div class="row g-2">
        @foreach($hp['banner_1'] as $banner)
        <div class="{{ $hp['banner_1']->count()===1 ? 'col-12' : 'col-md-6' }}">
            <a href="{{ $banner->link ?: '#' }}">
                <img src="{{ asset('product/thumbnail/'.$banner->image) }}"
                     class="img-fluid w-100 rounded" style="max-height:300px;object-fit:cover;"
                     alt="{{ $banner->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ================================================================
     FLASH DEALS
================================================================ --}}
@php
    $flashItems = collect();
    if(!empty($hp['flash_deal'])) {
        foreach($hp['flash_deal'] as $item) {
            if($item->product) $flashItems->push(['product'=>$item->product,'end'=>$item->countdown_end]);
        }
    }
@endphp
@if($flashItems->count())
<div class="lk-section">
    <div class="container">
        <div class="lk-section-title" style="border-color:#ff4500;">
            ⚡ Flash Deals
            <a href="{{ url('flash-deals') }}" class="view-all" style="color:#ff4500;">View All »</a>
        </div>
        <div class="lk-slider" id="lk-flash-slider">
            @foreach($flashItems as $fi)
            @php $product = $fi['product']; @endphp
            <div>
                <div class="lk-prod-card" style="border-color:#ffe0d0;">
                    <div class="lk-img-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}">
                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                 class="lazyload" alt="{{ $product->productName }}">
                        </a>
                        <span style="position:absolute;top:6px;left:6px;background:#ff4500;color:#fff;font-size:.65rem;padding:2px 6px;border-radius:3px;">FLASH</span>
                    </div>
                    <div class="lk-card-body">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                        <div class="lk-price" style="color:#ff4500;">{!! $product->htmlPrice() !!}</div>
                        @if(!empty($fi['end']) && $fi['end']->isFuture())
                        <div class="lk-deal-timer flash-countdown" data-ends="{{ $fi['end']->toIso8601String() }}">
                            <span class="countdown-display"></span>
                        </div>
                        @endif
                        <button class="btn btn-danger lk-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-bolt me-1"></i> Grab Now
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     FEATURED PRODUCTS
================================================================ --}}
@php
    $featuredItems = collect();
    if(!empty($hp['featured_product'])) {
        foreach($hp['featured_product'] as $item) {
            if($item->product) $featuredItems->push($item->product);
        }
    }
@endphp
@if($featuredItems->count())
<div class="lk-section" style="background:#f8f9fb;">
    <div class="container">
        <div class="lk-section-title" style="border-color:#0077cc;">
            Featured Products
            <a href="{{ url('shop') }}" class="view-all" style="color:#0077cc;">View All »</a>
        </div>
        <div class="lk-slider" id="lk-featured-slider">
            @foreach($featuredItems as $product)
            <div>
                <div class="lk-prod-card">
                    <div class="lk-img-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}">
                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                 class="lazyload" alt="{{ $product->productName }}">
                        </a>
                    </div>
                    <div class="lk-card-body">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                        <div class="lk-price">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-primary lk-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-1"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     BANNER LEVEL 2
================================================================ --}}
@if(!empty($hp['banner_2']) && $hp['banner_2']->count())
<div class="container py-3">
    <div class="row g-2">
        @foreach($hp['banner_2'] as $banner)
        <div class="{{ $hp['banner_2']->count()===1 ? 'col-12' : ($hp['banner_2']->count()===2 ? 'col-md-6' : 'col-md-4') }}">
            <a href="{{ $banner->link ?: '#' }}">
                <img src="{{ asset('product/thumbnail/'.$banner->image) }}"
                     class="img-fluid w-100 rounded" style="max-height:260px;object-fit:cover;"
                     alt="{{ $banner->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ================================================================
     BEST SELLING
================================================================ --}}
@php
    $bestItems = collect();
    if(!empty($hp['best_selling'])) {
        foreach($hp['best_selling'] as $item) {
            if($item->product) $bestItems->push($item->product);
        }
    }
@endphp
@if($bestItems->count())
<div class="lk-section">
    <div class="container">
        <div class="lk-section-title" style="border-color:#e67e22;">
            🔥 Best Selling
            <a href="{{ url('shop?sort=best_selling') }}" class="view-all" style="color:#e67e22;">View All »</a>
        </div>
        <div class="lk-slider" id="lk-best-slider">
            @foreach($bestItems as $product)
            <div>
                <div class="lk-prod-card">
                    <div class="lk-img-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}">
                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                 class="lazyload" alt="{{ $product->productName }}">
                        </a>
                    </div>
                    <div class="lk-card-body">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                        <div class="lk-price">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-warning lk-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-1"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     NEW PRODUCTS
================================================================ --}}
@php
    $newItems = collect();
    if(!empty($hp['new_product'])) {
        foreach($hp['new_product'] as $item) {
            if($item->product) $newItems->push($item->product);
        }
    }
@endphp
@if($newItems->count())
<div class="lk-section" style="background:#f8f9fb;">
    <div class="container">
        <div class="lk-section-title" style="border-color:#27ae60;">
            🆕 New Arrivals
            <a href="{{ url('search?sort_by=newest') }}" class="view-all" style="color:#27ae60;">View All »</a>
        </div>
        <div class="lk-slider" id="lk-new-slider">
            @foreach($newItems as $product)
            <div>
                <div class="lk-prod-card">
                    <div class="lk-img-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}">
                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                 class="lazyload" alt="{{ $product->productName }}">
                        </a>
                        <span style="position:absolute;top:6px;left:6px;background:#27ae60;color:#fff;font-size:.65rem;padding:2px 6px;border-radius:3px;">NEW</span>
                    </div>
                    <div class="lk-card-body">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                        <div class="lk-price">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-success lk-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-1"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     COUPON SECTION
================================================================ --}}
@php
    $couponBgImg = \App\Setting::get("coupon_bg_image_{$lang}") ?? '';
    $couponBgCol = \App\Setting::get("coupon_bg_color_{$lang}") ?? '#1a1a2e';
    $couponTitle = \App\Setting::get("coupon_title_{$lang}") ?? 'Special Offer';
    $couponSub   = \App\Setting::get("coupon_subtitle_{$lang}") ?? 'Get amazing discounts on all products';
    $couponTMode = \App\Setting::get("coupon_text_mode_{$lang}") ?? 'light';
@endphp
@if($couponTitle || $couponBgImg)
<div class="lk-section">
    <div class="container">
        <div class="lk-coupon-wrap"
             style="background: {{ $couponBgImg ? 'url('.asset('product/thumbnail/'.$couponBgImg).') center/cover no-repeat' : $couponBgCol }};
                    color: {{ $couponTMode==='light' ? '#fff' : '#222' }};">
            <div>
                @if($couponTitle)<h4>{{ $couponTitle }}</h4>@endif
                @if($couponSub)<p>{{ $couponSub }}</p>@endif
                <a href="{{ url('coupons') }}" class="btn btn-light mt-3 btn-sm px-4">View All Coupons</a>
            </div>
            @if($couponBgImg)
            <img src="{{ asset('product/thumbnail/'.$couponBgImg) }}" alt="" style="max-height:120px;border-radius:8px;object-fit:cover;">
            @endif
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     CATEGORY-WISE PRODUCTS  (tabbed, like linky.com.bd)
================================================================ --}}
@php
    $cwSaved = array_values(array_filter(array_map('intval', explode(',', \App\Setting::get("category_wise_cats_{$lang}") ?? ''))));
    $cwCats  = $cwSaved ? Category::whereIn('id', $cwSaved)->get()->keyBy('id') : collect();
    // If none configured, load the first few active categories
    if($cwCats->isEmpty()) {
        $cwCats = Category::where('status','Active')->orderBy('categoryName')->limit(8)->get()->keyBy('id');
        $cwSaved = $cwCats->keys()->toArray();
    }
@endphp
@if($cwCats->count())
<div class="lk-section lk-catwise">
    <div class="container">
        <div class="lk-section-title" style="border-color:#8e44ad;">
            Shop by Category
        </div>

        {{-- Tab headers --}}
        <div class="lk-catwise-tabs" id="lk-catwise-tabs">
            @foreach($cwSaved as $idx => $cid)
            @php $cwCat = $cwCats[$cid] ?? null; if(!$cwCat) continue; @endphp
            <div class="lk-catwise-tab {{ $idx===0?'active':'' }}" data-cat="{{ $cid }}">
                @if($cwCat->categoryImage)
                <img src="{{ asset('product/thumbnail/'.$cwCat->categoryImage) }}" alt="{{ $cwCat->categoryName }}">
                @endif
                <span>{{ $cwCat->categoryName }}</span>
            </div>
            @endforeach
        </div>

        {{-- Tab panels --}}
        @foreach($cwSaved as $idx => $cid)
        @php
            $cwCat = $cwCats[$cid] ?? null;
            if(!$cwCat) continue;
            $cwProds = \App\Product::with('media','categories')
                ->whereHas('categories', fn($q) => $q->where('categories.id', $cid))
                ->orderBy('created_at','desc')
                ->limit(8)
                ->get();
        @endphp
        <div class="lk-catwise-pane {{ $idx===0?'active':'' }}" data-cat="{{ $cid }}">
            <div class="row g-2">
                @foreach($cwProds as $product)
                <div class="col-6 col-md-3 col-lg-2">
                    <div class="lk-prod-card">
                        <div class="lk-img-wrap">
                            <a href="{{ url('/product/'.$product->productSlug) }}">
                                <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                     data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                     class="lazyload" alt="{{ $product->productName }}">
                            </a>
                        </div>
                        <div class="lk-card-body">
                            <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                            <div class="lk-price">{!! $product->htmlPrice() !!}</div>
                            <button class="btn btn-outline-primary lk-btn" onclick="addToCart({{ $product->id }})">Order</button>
                        </div>
                    </div>
                </div>
                @endforeach
                @if($cwProds->isEmpty())
                <div class="col-12 text-center text-muted py-5">No products in this category yet.</div>
                @endif
            </div>
            <div class="text-center mt-3">
                <a href="{{ url('shop?cat_id='.$cid) }}" class="btn btn-outline-secondary btn-sm px-5">
                    View All {{ $cwCat->categoryName }} Products
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ================================================================
     BANNER LEVEL 3
================================================================ --}}
@if(!empty($hp['banner_3']) && $hp['banner_3']->count())
<div class="container py-3">
    <div class="row g-2">
        @foreach($hp['banner_3'] as $banner)
        <div class="{{ $hp['banner_3']->count()===1 ? 'col-12' : ($hp['banner_3']->count()===2 ? 'col-md-6' : 'col-md-4') }}">
            <a href="{{ $banner->link ?: '#' }}">
                <img src="{{ asset('product/thumbnail/'.$banner->image) }}"
                     class="img-fluid w-100 rounded" style="max-height:220px;object-fit:cover;"
                     alt="{{ $banner->title }}">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ================================================================
     TOP SELLERS
================================================================ --}}
@php
    $topSellerItems = collect();
    if(!empty($hp['top_seller'])) {
        foreach($hp['top_seller'] as $item) {
            if($item->product) $topSellerItems->push($item->product);
        }
    }
@endphp
@if($topSellerItems->count())
<div class="lk-section">
    <div class="container">
        <div class="lk-section-title" style="border-color:#c0392b;">
            🏆 Top Sellers
        </div>
        <div class="lk-slider" id="lk-topseller-slider">
            @foreach($topSellerItems as $product)
            <div>
                <div class="lk-prod-card">
                    <div class="lk-img-wrap">
                        <a href="{{ url('/product/'.$product->productSlug) }}">
                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                 class="lazyload" alt="{{ $product->productName }}">
                        </a>
                    </div>
                    <div class="lk-card-body">
                        <a href="{{ url('/product/'.$product->productSlug) }}" class="lk-prod-name">{{ $product->productName }}</a>
                        <div class="lk-price">{!! $product->htmlPrice() !!}</div>
                        <button class="btn btn-danger lk-btn" onclick="addToCart({{ $product->id }})">
                            <i class="fa fa-shopping-cart me-1"></i> Order
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ================================================================
     TOP BRANDS  (category icons grid)
================================================================ --}}
@php
    $tbSelCats = array_values(array_filter(array_map('intval', explode(',', \App\Setting::get('top_brand_selected_cats') ?? ''))));
    $topBrandCats = $tbSelCats ? Category::whereIn('id', $tbSelCats)->get() : collect();
@endphp
@if($topBrandCats->count())
<div class="lk-section" style="background:#f0f2f5;">
    <div class="container">
        <div class="lk-section-title" style="border-color:#2980b9;">
            Top Brands
        </div>
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            @foreach($topBrandCats as $brand)
            <a href="{{ url('shop?cat_id='.$brand->id) }}"
               class="d-flex flex-column align-items-center gap-1 text-decoration-none p-3 bg-white rounded shadow-sm"
               style="min-width:90px;text-align:center;border:1px solid #e0e0e0;transition:box-shadow .2s;"
               onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,.12)'"
               onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,.06)'">
                @if($brand->categoryImage)
                <img src="{{ asset('product/thumbnail/'.$brand->categoryImage) }}" alt="{{ $brand->categoryName }}"
                     style="width:54px;height:54px;border-radius:50%;object-fit:cover;">
                @else
                <div style="width:54px;height:54px;border-radius:50%;background:#eee;display:flex;align-items:center;justify-content:center;color:#999;">
                    <i class="fas fa-tag"></i>
                </div>
                @endif
                <span style="font-size:.75rem;color:#333;font-weight:600;">{{ Str::limit($brand->categoryName,12) }}</span>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@endsection

@push('js')
<script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script>
(function($){
    // ── Slick slider defaults
    var slickDefaults = {
        slidesToShow: 5, slidesToScroll: 2,
        arrows: true, dots: false, infinite: false,
        responsive: [
            { breakpoint: 1200, settings: { slidesToShow: 4 } },
            { breakpoint: 992,  settings: { slidesToShow: 3 } },
            { breakpoint: 768,  settings: { slidesToShow: 2, slidesToScroll: 1 } },
            { breakpoint: 480,  settings: { slidesToShow: 2, slidesToScroll: 1 } }
        ]
    };

    $('#lk-deal-slider').slick($.extend({}, slickDefaults));
    $('#lk-flash-slider').slick($.extend({}, slickDefaults));
    $('#lk-featured-slider').slick($.extend({}, slickDefaults));
    $('#lk-best-slider').slick($.extend({}, slickDefaults));
    $('#lk-new-slider').slick($.extend({}, slickDefaults));
    $('#lk-topseller-slider').slick($.extend({}, slickDefaults));

    // ── Category-wise tabs
    $(document).on('click', '.lk-catwise-tab', function(){
        var cat = $(this).data('cat');
        $('.lk-catwise-tab').removeClass('active');
        $(this).addClass('active');
        $('.lk-catwise-pane').removeClass('active');
        $('.lk-catwise-pane[data-cat="' + cat + '"]').addClass('active');
        // Lazy-load images in the newly visible pane if not already loaded
        $('.lk-catwise-pane.active img.lazyload').each(function(){
            if($(this).attr('data-src') && !$(this).attr('src-loaded')){
                $(this).attr('src', $(this).attr('data-src'));
                $(this).attr('src-loaded', '1');
            }
        });
    });

    // ── Flash countdown
    function updateCountdowns(){
        $('.flash-countdown').each(function(){
            var ends = new Date($(this).data('ends'));
            var now  = new Date();
            var diff = ends - now;
            if(diff <= 0){ $(this).closest('.lk-prod-card').find('.lk-deal-timer').text('Ended'); return; }
            var h = Math.floor(diff/3600000);
            var m = Math.floor((diff%3600000)/60000);
            var s = Math.floor((diff%60000)/1000);
            $(this).find('.countdown-display').text(
                (h?h+'h ':'')+('0'+m).slice(-2)+'m '+('0'+s).slice(-2)+'s left'
            );
        });
    }
    updateCountdowns();
    setInterval(updateCountdowns, 1000);

}(jQuery));
</script>
@endpush
