@extends('website.layout')

@section('content')
    <section class="section-main">
        <style>
            .slider-home-banner .carousel-item { height: 500px; }
            .slider-home-banner .carousel-item img { height: 500px; object-fit: cover; }
        </style>
        <div style="width: 100%; margin: 0 auto;">
            {{-- <div class="row">
                <?php
                $category = DB::table('categories')->select('id', 'categoryName', 'categorySlug', 'categoryImage')->where('status', 'Active')->orderBy('categoryName', 'ASC')->get()->toArray();
                dd($category); ?>
                <div class="{{ $category ? 'col-lg-9' : 'col-lg-12' }} order-lg-2">
                    <div id="carousel1_indicator" class="slider-home-banner carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            @foreach ($slides as $key => $slide)
                                <li data-bs-target="#carousel1_indicator" data-slide-to="{{ $key }}" class="@if ($key == 0) active @endif"></li>
                            @endforeach
                        </ol>
                        <div class="carousel-inner rounded">
                            @foreach ($slides as $key => $slide)
                                <div class="carousel-item @if ($key == 0) active @endif">
                                    <a href="{{ $slide->link }}">
                                        <img class="d-block w-100 h-100"  src="{{ asset($slide->image) }}" alt="{{ $slide->name }}">
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
                 <!-- col.// -->
                  @if ($category)
                <div class="col-md-3 order-lg-1">
                    <div class="all-category">
                        <span>Categories</span>
                    </div>
                    <nav class="card">
                        <ul class="menu-category">
                           
                            @foreach ($category as $menu)
                                <li>
                                    <a href="{{ $menu['link'] }}">
                                       
                                        <span class="cat-name">{{ $menu['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div> 
                @endif

            </div>  --}}
            <div id="carousel1_indicator" class="slider-home-banner carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    @foreach ($slides as $key => $slide)
                        <li data-bs-target="#carousel1_indicator" data-slide-to="{{ $key }}"
                            class="@if ($key == 0) active @endif"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner rounded">
                    @foreach ($slides as $key => $slide)
                        <div class="carousel-item @if ($key == 0) active @endif">
                            <a href="{{ $slide->link }}">
                                <img class="d-block w-100 h-100" src="{{ asset($slide->image) }}" alt="{{ $slide->name }}">
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

            <!-- row.// -->
        </div> <!-- container //  -->
    </section>
    {{-- catagory section  --}}
    <section class="categories-section" style="padding-top: 15px;">
        <div class="container-fluid text-center p-0">
            <div class="text-center py-0">
                <div class="popular_product" bis_skin_checked="1">
                    <b></b>
                    <span>Popular Categories</span>
                    <b></b>
                </div>
            </div>
            <?php
            $categories = DB::table('categories')->select('id', 'categoryName', 'categorySlug', 'categoryImage')->where('status', 'Active')->orderBy('categoryName', 'ASC')->limit(14)->get()->toArray();
            ?>

            <div class="popular-categories-block text-center">
                <!-- Desktop: show grid of 8 categories -->
                <div class="d-none d-md-block">
                    <div class="category-grid">
                        @foreach ($categories as $cat)
                            <a href="{{ url('shop?cat_id=' . $cat->id) }}" class="category-card">
                                <div class="category-thumb">
                                    @if (!empty($cat->categoryImage))
                                        <img src="{{ asset('product/thumbnail/' . $cat->categoryImage) }}"
                                            alt="{{ $cat->categoryName }}">
                                    @else
                                        <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                            alt="{{ $cat->categoryName }}">
                                    @endif
                                </div>
                                <div class="category-name">{{ $cat->categoryName }}</div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Mobile: slick slider for categories -->
                <div class="category-mobile-slider d-block d-md-none">
                    <div class="category-slider-items">
                        @foreach ($categories as $cat)
                            <div class="category-card">
                                <a href="{{ url('shop?cat_id=' . $cat->id) }}">
                                    <div class="category-thumb">
                                        @if (!empty($cat->categoryImage))
                                            <img src="{{ asset('product/thumbnail/' . $cat->categoryImage) }}"
                                                alt="{{ $cat->categoryName }}">
                                        @else
                                            <img src="{{ asset('product/thumbnail/default.jpg') }}"
                                                alt="{{ $cat->categoryName }}">
                                        @endif
                                    </div>
                                    <div class="category-name">{{ $cat->categoryName }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <script>
                $(function() {
                    function initMobileCatSlider() {
                        var $el = $('.category-slider-items');
                        if (window.innerWidth < 768) {
                            if (!$el.hasClass('slick-initialized')) {
                                $el.slick({
                                    slidesToShow: 3,
                                    slidesToScroll: 1,
                                    arrows: false,
                                    dots: false,
                                    autoplay: false,
                                    infinite: false
                                });
                            }
                        } else {
                            if ($el.hasClass('slick-initialized')) {
                                $el.slick('unslick');
                            }
                        }
                    }
                    initMobileCatSlider();
                    $(window).on('resize', initMobileCatSlider);
                });
            </script>

        </div>
    </section>
    {{-- catagory section end  --}}
    {{-- Two Category Product Sections --}}
    <?php
    if (!isset($limit)) {
        $limit = (int) (Settings::get('home_two_featured_limit') ?? 5);
    }
    if (!isset($featuredCats)) {
        $catsCsv = (string) (Settings::get('home_two_featured_cats') ?? '');
        $catIds = array_values(array_filter(array_map('intval', explode(',', $catsCsv))));
        // Deduplicate IDs while preserving original order
        $seen = [];
        $orderedIds = [];
        foreach ($catIds as $cid) {
            if (!$cid) {
                continue;
            }
            if (!isset($seen[$cid])) {
                $seen[$cid] = true;
                $orderedIds[] = $cid;
            }
        }
    
        if (count($orderedIds) === 0) {
            $featuredCats = DB::table('categories')->select('id', 'categoryName', 'categorySlug')->where('status', 'Active')->orderBy('categoryName', 'ASC')->limit(2)->get();
        } else {
            // Fetch and then reorder according to $orderedIds
            $cats = DB::table('categories')->select('id', 'categoryName', 'categorySlug')->whereIn('id', $orderedIds)->get();
            $byId = [];
            foreach ($cats as $c) {
                $byId[$c->id] = $c;
            }
            $ordered = [];
            foreach ($orderedIds as $id) {
                if (isset($byId[$id])) {
                    $ordered[] = $byId[$id];
                }
            }
            $featuredCats = collect($ordered);
        }
    }
    
    if (!isset($initialProducts)) {
        $initialProducts = [];
        foreach ($featuredCats as $fc) {
            $initialProducts[$fc->id] = \App\Product::with('media', 'categories')
                ->whereHas('categories', function ($query) use ($fc) {
                    $query->where('categories.id', $fc->id);
                })
                ->orderBy('products.created_at', 'DESC')
                ->limit($limit)
                ->get();
        }
    }
    ?>

    @foreach ($featuredCats as $fc)
        <section class="section-name padding-y-sm pt-6">
            <div class="container-fluid">
                <div class="category_products" data-category-id="{{ $fc->id }}">
                    <div class="banner rounded-2">
                        <div class="text-center w-100">
                            <div class="title">{{ $fc->categoryName }}</div>
                            <img src="{{ asset('site/pt.svg') }}" style="width: 200px;" alt="">
                            <div class="small"></div>
                        </div>
                    </div>
                    <div class="products mt-1 pt-1" id="cat-{{ $fc->id }}-list" data-cat-id="{{ $fc->id }}" data-offset="{{ $limit }}" data-limit="{{ $limit }}">
                        @foreach ($initialProducts[$fc->id] as $product)
                            <div class="product">
                                <div class="image">
                                    <a href="{{ url('/product/' . $product->id) }}" id="product_show" data-productid="{{ $product->id }}" data-categoryid="{{ $fc->categoryName }}" data-productname="{{ $product->productName }}">
                                        <img class="img-fit lazyload first" src="{{ asset('product/thumbnail/default.jpg') }}" data-src="{{ asset('/product/thumbnail/' . $product->productImage) }}" alt="{{ $product->productName }}">
                                        <img class="img-fit lazyload second" src="{{ asset('product/thumbnail/default.jpg') }}" data-src="{{ asset('/product/thumbnail/' . $product->productImage) }}" alt="{{ $product->productName }}">
                                    </a>
                                </div>
                                <div class="labels"></div>
                                <div class="content px-2 text-center pb-2">
                                    <a href="{{ url('/product/' . $product->id) }}" id="product_show" data-productid="{{ $product->id }}" data-categoryid="{{ $fc->categoryName }}" data-productname="{{ $product->productName }}">
                                        <div class="title">{{ $product->productName }}</div>
                                    </a>
                                    <div class="stars d-flex justify-content-center py-2">
                                        <div class="d-flex align-items-center text-warning">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="price">{!! $product->htmlPrice() !!}</div>
                                    <button class="submit_button btn btnLight d-block w-100 border cart_btn ord_bt" style="border-radius: 5px;" onclick="addToCart({{ $product->id }})">
                                        <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i><span class="bold"> অর্ডার করুন</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btnLight load-more-products load-more-cat" style="border-radius: 5px;"  data-target="#cat-{{ $fc->id }}-list">Load More</button>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    <script>
        $(function() {
            $('.load-more-cat').on('click', function() {
                var $btn = $(this);
                var targetSel = $btn.data('target');
                var $list = $(targetSel);
                var catId = $list.data('cat-id');
                var offset = parseInt($list.data('offset')) || 0;
                var limit = parseInt($list.data('limit')) || 10;

                $btn.prop('disabled', true).text('Loading...');

                $.get("{{ url('/getCategoryProducts') }}", {
                        cat_id: catId,
                        offset: offset,
                        limit: limit
                    })
                    .done(function(html) {
                        html = html || '';
                        if ($.trim(html).length === 0) {
                            $btn.hide();
                            return;
                        }
                        var $frag = $('<div/>').html(html);
                        var count = $frag.find('.product').length;
                        $list.append($frag.children());
                        $list.data('offset', offset + (count || limit));
                        if (count < limit) {
                            $btn.hide();
                        }
                    })
                    .fail(function() {
                        alert('Failed to load more products.');
                    })
                    .always(function() {
                        $btn.prop('disabled', false).text('More Products');
                    });
            });
        });
    </script>
    <section class="section-name pt-0">
        <div class="container-fluid">
            <div class="category_products" data-category-id="dhamaka-offer">
                <div class="banner rounded-2">
                    <div class="text-center w-100">
                        <div class="title">Dhamaka Offer</div>
                        <img src="{{ asset('site/pt.svg') }}" style="width: 200px;" alt="">
                        <div class="small"></div>
                    </div>
                </div>
                <div class="products mt-1 pt-1">
                    @foreach ($topProducts->take(5) as $product)
                        <div class="product">
                            <div class="image">
                                <a href="{{ url('/product/' . $product->id) }}" id="product_show" data-productid="{{ $product->id }}" data-categoryid="Dhamaka Offer" data-productname="{{ $product->productName }}">
                                    <img class="img-fit lazyload first" src="{{ asset('product/thumbnail/default.jpg') }}" data-src="{{ asset('/product/thumbnail/' . $product->productImage) }}" alt="{{ $product->productName }}">
                                    <img class="img-fit lazyload second" src="{{ asset('product/thumbnail/default.jpg') }}" data-src="{{ asset('/product/thumbnail/' . $product->productImage) }}" alt="{{ $product->productName }}">
                                </a>
                            </div>
                            <div class="labels"></div>
                            <div class="content px-2 text-center pb-2">
                                <a href="{{ url('/product/' . $product->id) }}" id="product_show" data-productid="{{ $product->id }}" data-categoryid="Dhamaka Offer" data-productname="{{ $product->productName }}">
                                    <div class="title">{{ $product->productName }}</div>
                                </a>
                                <div class="stars d-flex justify-content-center py-2">
                                    <div class="d-flex align-items-center text-warning">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <div class="price">{!! $product->htmlPrice() !!}</div>
                                <button class="submit_button btn btnLight d-block w-100 border cart_btn ord_bt" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i><span class="bold"> অর্ডার করুন</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script>
        var page = 1;
        load_more(page);
        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                page++;
                load_more(page);
            }
        });

        function load_more(page) {

            $.ajax({
                type: "get",
                datatype: "html",
                url: '<?php echo url('/getProducts'); ?>?page=' + page,
                success: function(data) {
                    $("#loadProducts").append(data); //append data into #results element
                    lazyload();
                }
            });
        }

        $(document).ready(function() {
            // Initialize mobile category slider
            $('.mobile-slider').slick({
                slidesToShow: 8,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 3000,
                arrows: true,
                dots: false,
                infinite: true,
                prevArrow: '<button class="slide-arrow prev-arrow"><i class="fa fa-chevron-left"></i></button>',
                nextArrow: '<button class="slide-arrow next-arrow"><i class="fa fa-chevron-right"></i></button>',
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            // Initialize popular product slider
            $('.popular-product-slider').slick({
                slidesToShow: 5,
                rows: 2,
                prevArrow: '<button class="slide-arrow prev-arrow"><i class="fa fa-arrow-left"></i></button>',
                nextArrow: '<button class="slide-arrow next-arrow"><i class="fa fa-arrow-right"></i></button>',
                responsive: [{
                    breakpoint: 480,
                    settings: {
                        rows: 2,
                        slidesToShow: 2
                    }
                }]
            });
        });
    </script>
@endpush
