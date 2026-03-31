@extends('website.layout')

@push('css')
    <style>
        .market-page-content {
            background-color: #f5f5f5;
        }
        .market-grey-section {
            background-color: #f5f5f5;
        }
        .market-intro-row {
            row-gap: 1rem;
        }
        .market-category-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 8px 24px rgba(0,0,0,0.04);
            max-height: 420px;
            overflow-y: auto;
        }
        .market-category-header {
            padding: 14px 18px;
            border-bottom: 1px solid #e5e5e5;
            font-weight: 700;
            font-size: 15px;
        }
        .market-category-item {
            padding: 10px 18px;
            border-top: 1px solid #f1f1f1;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .market-category-item:hover {
            background-color: #f1f1f1;
        }
        .market-service-box {
            padding: 14px 18px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            display: flex;
            align-items: center;
            gap: 10px;
            height: 100%;
        }
        .market-service-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .market-service-title {
            margin: 0;
            font-weight: 600;
            font-size: 14px;
        }
        .market-service-sub {
            margin: 0;
            font-size: 12px;
            color: #777;
        }
        .market-category-grid-card {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e5e5e5;
            text-align: center;
            padding: 14px 10px;
            height: 100%;
        }
        .market-category-grid-card img {
            max-width: 72px;
            max-height: 72px;
            object-fit: contain;
            margin-bottom: 8px;
        }
        .market-category-grid-card span {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #333;
        }
        .market-deal-section .section-heading .section-title {
            font-size: 18px;
            font-weight: 700;
        }
    </style>
@endpush

@section('content')
    <div class="page-content market-page-content">
        <section class="grey-section market-grey-section pt-4 pb-10">
            <div class="container">
                <div class="row market-intro-row">
                    <div class="col-lg-9 mb-3 mb-lg-0">
                        <div id="carousel1_indicator" class="slider-home-banner carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($slides as $key => $slide)
                                    <li data-bs-target="#carousel1_indicator"
                                        data-slide-to="{{ $key }}"
                                        class="@if($key === 0) active @endif"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner rounded">
                                @foreach($slides as $key => $slide)
                                    <div class="carousel-item @if($key === 0) active @endif">
                                        <a href="{{ $slide->link }}">
                                            <img class="d-block w-100 h-100"
                                                 src="{{ asset($slide->image) }}"
                                                 alt="{{ $slide->name }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carousel1_indicator" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel1_indicator" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block">
                        @php
                            $menuCategories = \Menu::getByName('Category Menu');
                        @endphp
                        @if($menuCategories)
                            <div class="market-category-card">
                                <div class="market-category-header">
                                    Category List
                                </div>
                                <div>
                                    <a href="{{ route('shop') }}" class="market-category-item">
                                        <p class="mb-0">All products</p>
                                    </a>
                                    <a href="{{ route('shop') }}" class="market-category-item">
                                        <p class="mb-0">All category</p>
                                    </a>
                                    @foreach($menuCategories as $menu)
                                        <a href="{{ $menu['link'] }}" class="market-category-item">
                                            <p class="mb-0">{{ $menu['label'] }}</p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-3 mb-3">
                        <div class="market-service-box">
                            <div class="market-service-icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <div>
                                <p class="market-service-title">Fast Delivery</p>
                                <p class="market-service-sub">All over Bangladesh</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="market-service-box">
                            <div class="market-service-icon">
                                <i class="fa fa-shield-alt"></i>
                            </div>
                            <div>
                                <p class="market-service-title">Secure Payment</p>
                                <p class="market-service-sub">Trusted gateways</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="market-service-box">
                            <div class="market-service-icon">
                                <i class="fa fa-sync"></i>
                            </div>
                            <div>
                                <p class="market-service-title">Easy Returns</p>
                                <p class="market-service-sub">Hassle free</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="market-service-box">
                            <div class="market-service-icon">
                                <i class="fa fa-headset"></i>
                            </div>
                            <div>
                                <p class="market-service-title">24/7 Support</p>
                                <p class="market-service-sub">We are here</p>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $marketCats = \DB::table('categories')
                        ->select('id', 'categoryName', 'categorySlug', 'categoryImage')
                        ->where('status', 'Active')
                        ->orderBy('categoryName', 'ASC')
                        ->limit(12)
                        ->get();
                @endphp
                @if($marketCats->count())
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0">Popular Categories</h4>
                            <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm">
                                View all
                            </a>
                        </div>
                        <div class="row g-2">
                            @foreach($marketCats as $cat)
                                <div class="col-4 col-md-2">
                                    <a href="{{ url('shop?cat_id='.$cat->id) }}">
                                        <div class="market-category-grid-card">
                                            @if(!empty($cat->categoryImage))
                                                <img src="{{ asset('product/thumbnail/'.$cat->categoryImage) }}" alt="{{ $cat->categoryName }}">
                                            @else
                                                <img src="{{ asset('product/thumbnail/default.jpg') }}" alt="{{ $cat->categoryName }}">
                                            @endif
                                            <span>{{ $cat->categoryName }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>

        @if(isset($topProducts) && count($topProducts) > 0)
            <section class="section-name bg padding-y-sm pt-0 market-deal-section">
                <div class="container">
                    <header class="section-heading mt-0 d-flex justify-content-between align-items-center">
                        <h4 class="section-title mb-0">Best Deals</h4>
                        <a href="{{ url('category/'.$slug) }}" class="btn btn-outline-info btn-sm rounded">
                            View more
                        </a>
                    </header>
                    <div class="row g-2">
                        @foreach($topProducts as $product)
                            <div class="col-6 col-md-3 col-lg-2">
                                <div class="card card-product-grid h-100">
                                    <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                                        <img class="img-fit lazyload"
                                             src="{{ asset('product/thumbnail/default.jpg') }}"
                                             data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                             alt="{{ $product->productName }}">
                                    </a>
                                    <div class="card-body text-center">
                                        <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">
                                            {{ $product->productName }}
                                        </a>
                                        <div class="price mt-1">
                                            {!! $product->htmlPrice() !!}
                                        </div>
                                        <button class="btn btn-success btn-sm btn-block mt-2"
                                                onclick="addToCart({{ $product->id }})">
                                            <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i> অর্ডার করুন
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        @if(isset($featuredCats) && count($featuredCats) > 0)
            <section class="grey-section pt-10 pb-10">
                <div class="container mt-6">
                    @foreach($featuredCats as $fc)
                        <header class="section-heading mt-0 d-flex justify-content-between align-items-center">
                            <h4 class="section-title mb-0">
                                {{ $fc->categoryName ?? '' }}
                            </h4>
                            <a href="{{ url('shop?cat_id='.$fc->id) }}" class="btn btn-outline-info btn-sm rounded">
                                View more
                            </a>
                        </header>
                        <div class="row g-2 mb-3">
                            @php
                                $products = $initialProducts[$fc->id] ?? collect();
                            @endphp
                            @foreach($products as $product)
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="card card-product-grid h-100">
                                        <a href="{{ url('/product/'.$product->productSlug) }}" class="img-wrap">
                                            <img class="img-fit lazyload"
                                                 src="{{ asset('product/thumbnail/default.jpg') }}"
                                                 data-src="{{ asset('/product/thumbnail/'.$product->productImage) }}"
                                                 alt="{{ $product->productName }}">
                                        </a>
                                        <div class="card-body text-center">
                                            <a href="{{ url('/product/'.$product->productSlug) }}" class="title text-truncate">
                                                {{ $product->productName }}
                                            </a>
                                            <div class="price mt-1">
                                                {!! $product->htmlPrice() !!}
                                            </div>
                                            <button class="btn btn-success btn-sm btn-block mt-2"
                                                    onclick="addToCart({{ $product->id }})">
                                                <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i> অর্ডার করুন
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
