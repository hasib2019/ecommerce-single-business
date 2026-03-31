@extends('website.layout')

@push('css')
<style>
    :root {
        --hm-hero-height-desktop: {{ (int) (Settings::get('home_modern_hero_height_desktop') ?? 360) }}px;
        --hm-hero-height-mobile: {{ (int) (Settings::get('home_modern_hero_height_mobile') ?? 240) }}px;
        --hm-product-height-desktop: {{ (int) (Settings::get('home_modern_product_image_height_desktop') ?? 190) }}px;
        --hm-product-height-mobile: {{ (int) (Settings::get('home_modern_product_image_height_mobile') ?? 170) }}px;
        --hm-product-fit: {{ in_array(Settings::get('home_modern_product_image_fit'), ['cover', 'contain']) ? Settings::get('home_modern_product_image_fit') : 'cover' }};
    }
    .hm-wrap {
        background: #f8fafc;
    }
    .hm-hero {
        padding: 18px 0 10px;
    }
    .hm-hero-card {
        background: #ffffff;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 18px 40px rgba(2,6,23,0.06);
    }
    .hm-hero-slider .carousel-item {
        height: var(--hm-hero-height-desktop);
    }
    .hm-hero-slider .carousel-item img {
        height: var(--hm-hero-height-desktop);
        object-fit: cover;
        width: 100%;
    }
    @media (max-width: 991.98px) {
        .hm-hero-slider .carousel-item,
        .hm-hero-slider .carousel-item img {
            height: var(--hm-hero-height-mobile);
        }
    }
    .hm-hero-badges {
        display: grid;
        gap: 12px;
    }
    .hm-badge {
        background: linear-gradient(135deg, rgba(255,255,255,0.95), rgba(255,255,255,0.85));
        border: 1px solid #eef2f7;
        border-radius: 16px;
        padding: 14px;
        box-shadow: 0 14px 30px rgba(2,6,23,0.06);
        display: flex;
        align-items: center;
        gap: 12px;
        min-height: 82px;
    }
    .hm-badge-ico {
        width: 44px;
        height: 44px;
        border-radius: 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(59,130,246,0.14);
        color: var(--primary-color);
        flex: 0 0 auto;
        font-size: 18px;
    }
    .hm-badge-title {
        font-weight: 900;
        font-size: 14px;
        color: #0f172a;
        line-height: 1.2;
    }
    .hm-badge-sub {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }
    .hm-section {
        padding: 12px 0;
    }
    .hm-section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }
    .hm-title {
        font-weight: 900;
        font-size: 18px;
        margin: 0;
        color: #0f172a;
    }
    .hm-sub {
        margin: 0;
        font-size: 13px;
        color: #64748b;
    }
    .hm-link {
        text-decoration: none;
        font-weight: 800;
        font-size: 13px;
        color: var(--primary-color);
        background: rgba(13,110,253,0.10);
        border: 1px solid rgba(13,110,253,0.18);
        padding: 8px 12px;
        border-radius: 999px;
        white-space: nowrap;
    }
    .hm-link:hover {
        background: rgba(13,110,253,0.14);
        color: var(--primary-color);
    }
    .hm-cat-row {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 8px;
    }
    .hm-cat-row::-webkit-scrollbar {
        height: 6px;
    }
    .hm-cat-row::-webkit-scrollbar-thumb {
        background: rgba(100,116,139,0.25);
        border-radius: 999px;
    }
    .hm-cat-pill {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 999px;
        background: #ffffff;
        border: 1px solid #eef2f7;
        color: #0f172a;
        text-decoration: none;
        font-weight: 800;
        font-size: 13px;
        box-shadow: 0 10px 20px rgba(2,6,23,0.04);
        flex: 0 0 auto;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .hm-cat-pill:hover {
        transform: translateY(-1px);
        box-shadow: 0 16px 30px rgba(2,6,23,0.06);
        color: #0f172a;
    }
    .hm-cat-thumb {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        object-fit: cover;
        background: #f1f5f9;
        border: 1px solid #eef2f7;
    }
    .hm-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 12px;
    }
    @media (max-width: 1199.98px) {
        .hm-grid { grid-template-columns: repeat(4, 1fr); }
    }
    @media (max-width: 767.98px) {
        .hm-grid { grid-template-columns: repeat(2, 1fr); }
    }
    .hm-card {
        background: #ffffff;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 14px 30px rgba(2,6,23,0.05);
        transition: transform 0.18s ease, box-shadow 0.18s ease;
        height: 100%;
    }
    .hm-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 44px rgba(2,6,23,0.08);
    }
    .hm-card-img {
        width: 100%;
        height: var(--hm-product-height-desktop);
        object-fit: var(--hm-product-fit);
        background: #f1f5f9;
        transition: transform 0.4s ease, filter 0.4s ease;
        filter: saturate(1.05);
    }
    .hm-card:hover .hm-card-img {
        transform: scale(1.04);
        filter: saturate(1.15);
    }
    .hm-card-body {
        padding: 12px 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        text-align: center;
    }
    .hm-card-title {
        font-weight: 900;
        font-size: 13px;
        color: #0f172a;
        text-decoration: none;
        line-height: 1.25;
        min-height: 34px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .hm-price {
        font-weight: 900;
        color: var(--primary-color);
    }
    .hm-btn {
        border-radius: 999px;
        font-weight: 900;
        padding: 9px 12px;
        border: 1px solid rgba(2,6,23,0.12);
        background: #ffffff;
        color: #0f172a;
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    .hm-btn:hover {
        background: #0f172a;
        color: #ffffff;
    }
    .hm-banner {
        background: linear-gradient(135deg, rgba(13,110,253,0.14), rgba(34,197,94,0.10));
        border: 1px solid rgba(13,110,253,0.16);
        border-radius: 18px;
        padding: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 12px;
    }
    .hm-banner-title {
        margin: 0;
        font-size: 16px;
        font-weight: 900;
        color: #0f172a;
    }
    .hm-banner-sub {
        margin: 2px 0 0;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
    }
    .hm-banner-link {
        text-decoration: none;
        color: #ffffff;
        background: var(--btn-bg);
        border-radius: 999px;
        padding: 8px 12px;
        font-weight: 900;
        border: 0;
        white-space: nowrap;
    }
    .hm-banner-link:hover {
        background: var(--btn-hover-bg);
        color: #ffffff;
    }
    .hm-dyn-banner-card {
        border-radius: 18px;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid rgba(2,6,23,0.08);
        box-shadow: 0 14px 30px rgba(2,6,23,0.08);
        margin-bottom: 14px;
    }
    .hm-dyn-banner-img {
        width: 100%;
        object-fit: cover;
        display: block;
    }
    @media (max-width: 767.98px) {
        .hm-card-img {
            height: var(--hm-product-height-mobile);
        }
    }
</style>
@endpush

@section('content')
    @php
        $cats = \DB::table('categories')
            ->select('id', 'categoryName', 'categorySlug', 'categoryImage')
            ->where('status', 'Active')
            ->orderBy('categoryName', 'ASC')
            ->limit(18)
            ->get();

        $bannerImagesRaw = (string) (Settings::get('home_modern_banner_images') ?? '');
        $bannerLinksRaw = (string) (Settings::get('home_modern_banner_links') ?? '');
        $bannerHeightsRaw = (string) (Settings::get('home_modern_banner_heights') ?? '');

        $bannerImages = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $bannerImagesRaw))));
        $bannerLinks = array_values(array_map('trim', preg_split('/\r\n|\r|\n/', $bannerLinksRaw)));
        $bannerHeights = array_values(array_map('trim', preg_split('/\r\n|\r|\n/', $bannerHeightsRaw)));

        $homeModernBanners = [];
        foreach ($bannerImages as $idx => $img) {
            if ($img === '') {
                continue;
            }
            $link = $bannerLinks[$idx] ?? '';
            $height = (int) ($bannerHeights[$idx] ?? 220);
            if ($height < 80) {
                $height = 220;
            }
            if (preg_match('/^https?:\/\//i', $img)) {
                $imageUrl = $img;
            } else {
                $imageUrl = asset(ltrim($img, '/'));
            }
            if ($link !== '' && !preg_match('/^https?:\/\//i', $link)) {
                $link = url($link);
            }
            $homeModernBanners[] = [
                'image' => $imageUrl,
                'link' => $link,
                'height' => $height,
            ];
        }
        $bannerCursor = 0;
    @endphp

    <div class="hm-wrap">
        <section class="hm-hero">
            <div class="container">
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="hm-hero-card hm-hero-slider">
                            <div id="hmCarousel" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    @foreach($slides as $key => $slide)
                                        <li data-bs-target="#hmCarousel" data-slide-to="{{ $key }}" class="@if($key === 0) active @endif"></li>
                                    @endforeach
                                </ol>
                                <div class="carousel-inner">
                                    @foreach($slides as $key => $slide)
                                        <div class="carousel-item @if($key === 0) active @endif">
                                            <a href="{{ $slide->link }}">
                                                <img src="{{ asset($slide->image) }}" alt="{{ $slide->name }}">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#hmCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#hmCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="hm-hero-badges">
                            <div class="hm-badge">
                                <div class="hm-badge-ico"><i class="fa fa-shipping-fast"></i></div>
                                <div>
                                    <div class="hm-badge-title">Fast Delivery</div>
                                    <div class="hm-badge-sub">Nationwide coverage</div>
                                </div>
                            </div>
                            <div class="hm-badge">
                                <div class="hm-badge-ico"><i class="fa fa-shield-alt"></i></div>
                                <div>
                                    <div class="hm-badge-title">Secure Checkout</div>
                                    <div class="hm-badge-sub">Safe & trusted</div>
                                </div>
                            </div>
                            <div class="hm-badge">
                                <div class="hm-badge-ico"><i class="fa fa-headset"></i></div>
                                <div>
                                    <div class="hm-badge-title">Support</div>
                                    <div class="hm-badge-sub">We are here to help</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="hm-section">
            <div class="container">
                <div class="hm-section-head">
                    <div>
                        <h3 class="hm-title">Popular Categories</h3>
                        <p class="hm-sub">Browse by category</p>
                    </div>
                    <a class="hm-link" href="{{ url('/shop') }}">View all</a>
                </div>
                <div class="hm-cat-row">
                    @foreach($cats as $cat)
                        <a class="hm-cat-pill" href="{{ url('shop?cat_id='.$cat->id) }}">
                            @if(!empty($cat->categoryImage))
                                <img class="hm-cat-thumb" src="{{ asset('product/thumbnail/'.$cat->categoryImage) }}" alt="{{ $cat->categoryName }}">
                            @else
                                <img class="hm-cat-thumb" src="{{ asset('product/thumbnail/default.jpg') }}" alt="{{ $cat->categoryName }}">
                            @endif
                            <span>{{ $cat->categoryName }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        @if(isset($topProducts) && count($topProducts) > 0)
            <section class="hm-section">
                <div class="container">
                    <div class="hm-section-head">
                        <div>
                            <h3 class="hm-title">Hot Deals</h3>
                            <p class="hm-sub">Trending offers today</p>
                        </div>
                        <a class="hm-link" href="{{ url('category/'.$slug) }}">More deals</a>
                    </div>
                    <div class="hm-grid">
                        @foreach($topProducts->take(12) as $product)
                            <div class="hm-card">
                                <a href="{{ url('/product/'.$product->productSlug) }}">
                                    <img class="hm-card-img lazyload" src="{{ asset('product/thumbnail/default.jpg') }}" data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}" alt="{{ $product->productName }}">
                                </a>
                                <div class="hm-card-body">
                                    <a class="hm-card-title" href="{{ url('/product/'.$product->productSlug) }}">{{ $product->productName }}</a>
                                    <div class="hm-price">{!! $product->htmlPrice() !!}</div>
                                    <button class="hm-btn" onclick="addToCart({{ $product->id }})">
                                        <i class="fa fa-shopping-bag me-1"></i> অর্ডার করুন
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @if(count($homeModernBanners) > 0)
                @php $b = $homeModernBanners[$bannerCursor % count($homeModernBanners)]; $bannerCursor++; @endphp
                <section class="hm-section pt-0">
                    <div class="container">
                        <div class="hm-dyn-banner-card">
                            @if(!empty($b['link']))
                                <a href="{{ $b['link'] }}">
                                    <img class="hm-dyn-banner-img" src="{{ $b['image'] }}" style="height: {{ $b['height'] }}px;" alt="Banner">
                                </a>
                            @else
                                <img class="hm-dyn-banner-img" src="{{ $b['image'] }}" style="height: {{ $b['height'] }}px;" alt="Banner">
                            @endif
                        </div>
                    </div>
                </section>
            @endif
        @endif

        @if(isset($featuredCats) && count($featuredCats) > 0)
            <section class="hm-section">
                <div class="container">
                    @foreach($featuredCats as $fc)
                        @php
                            $products = $initialProducts[$fc->id] ?? collect();
                        @endphp
                        <div class="hm-banner">
                            <div>
                                <h4 class="hm-banner-title">{{ $fc->categoryName ?? '' }}</h4>
                                <p class="hm-banner-sub">Fresh picks from this category</p>
                            </div>
                            <a class="hm-banner-link" href="{{ url('shop?cat_id='.$fc->id) }}">View more</a>
                        </div>

                        <div class="hm-grid mb-4">
                            @foreach($products as $product)
                                <div class="hm-card">
                                    <a href="{{ url('/product/'.$product->productSlug) }}">
                                        <img class="hm-card-img lazyload" src="{{ asset('product/thumbnail/default.jpg') }}" data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}" alt="{{ $product->productName }}">
                                    </a>
                                    <div class="hm-card-body">
                                        <a class="hm-card-title" href="{{ url('/product/'.$product->productSlug) }}">{{ $product->productName }}</a>
                                        <div class="hm-price">{!! $product->htmlPrice() !!}</div>
                                        <button class="hm-btn" onclick="addToCart({{ $product->id }})">
                                            <i class="fa fa-shopping-bag me-1"></i> অর্ডার করুন
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(count($homeModernBanners) > 0)
                            @php $b = $homeModernBanners[$bannerCursor % count($homeModernBanners)]; $bannerCursor++; @endphp
                            <div class="hm-dyn-banner-card">
                                @if(!empty($b['link']))
                                    <a href="{{ $b['link'] }}">
                                        <img class="hm-dyn-banner-img" src="{{ $b['image'] }}" style="height: {{ $b['height'] }}px;" alt="Banner">
                                    </a>
                                @else
                                    <img class="hm-dyn-banner-img" src="{{ $b['image'] }}" style="height: {{ $b['height'] }}px;" alt="Banner">
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
