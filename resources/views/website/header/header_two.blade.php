{{-- Optimized Header Design - Merged and Enhanced --}}
<header class="section-header">
    {{-- Top Navigation Bar --}}
    <nav class="navbar navbar-expand-lg top_nav navbar-light" style="background-color: #fafcff;color: gray">
        <div class="container-fluid align-items-center">
            {{-- Mobile Menu Toggle --}}
            <button class="navbar-toggler side_menu_toggler d-lg-none border-0 p-0" style="font-size: 26px; color: navy;" type="button">
                <i class="fa fa-bars"></i>
            </button>

            {{-- Brand Logo --}}
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset(Settings::get('site_logo')) }}" class="logo" alt="{{ Settings::get('site_name') }}">
            </a>

            {{-- Mobile Cart and Login --}}
            <div class="d-lg-none d-flex align-items-center gap-2">
                <div class="icon_cart semi btn p-0">
                    <div class="btn badge2 px-0" id="cart_items_mobile">
                        <img src="{{ asset('site/c1.png') }}" width="40" alt="" style="filter: invert(1);">
                        <span class="badge text-light" style="background-color: navy;">0</span>
                    </div>
                </div>
                <a href="{{ url('/login') }}" class="btn px-0" style="color: navy;">
                    <img src="{{ asset('site/login.png') }}" style="width: 30px; filter: invert(1);" alt="Login">
                </a>
            </div>

            {{-- Search Form --}}
            <form class="d-flex header_search col-lg-6 m-auto position-relative" action="{{ url('/shop') }}">
                <?php $categoriesMenu = Menu::getAllCategories(); ?>
                <select name="category" id="search_category" class="form-select d-lg-block d-none" style="width: 120px; font-size: 14px; border-radius: 5px 0 0 5px; font-weight: 600; background-color: #ede5e5;">
                    <option value="">All Categories</option>
                    @if ($categoriesMenu)
                        @foreach ($categoriesMenu as $cat)
                            <option value="{{ $cat['id'] }}" {{ request('category') == $cat['id'] ? 'selected' : '' }}>{{ $cat['label'] }}</option>
                        @endforeach
                    @endif
                </select>
                <input class="form-control" id="search_input" type="text" placeholder="Search for products, brands and more" name="q" value="{{ request('q') }}" autocomplete="off">
                <button class="btn orange-bg text-white" type="submit">
                    <i class="fa fa-search"></i>
                </button>
                <div id="search_results" class="position-absolute w-100 bg-white shadow rounded-bottom" style="top: 100%; left: 0; z-index: 9999; display: none; max-height: 400px; overflow-y: auto; border: 1px solid #eee;"></div>
            </form>

            {{-- Desktop Actions --}}
            <div class="d-none d-lg-flex align-items-center" style="gap: 10px;">
                <a href="tel:01834144430" class="btn btn-sm orange-bg text-white" style="font-size: 14px; border-radius: 5px;">
                    <i class="fa fa-phone me-1"></i>
                    01834144430
                </a>
                <a href="{{ url('/login') }}" class="btn btn-sm orange-bg" style="border-radius: 25px;">
                    <img src="{{ asset('site/login.png') }}" style="width: 25px; filter: invert(0);" alt="Login">
                </a>
                <div class="nav-cart-box dropdown" id="cart_items">
                    {{-- <a href="#" class="btn btn-sm position-relative" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset('site/c1.png') }}" width="25" alt="Cart" style="filter: invert(0);">
                        <span class="badge bg-dark text-light position-absolute top-0 start-100 translate-middle">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-0" style="min-width: 300px;">
                        <li>
                            <div class="dropdown-cart px-0">
                                <div class="dc-header">
                                    <h6 class="text-center py-3 mb-0">Your Cart is Empty</h6>
                                </div>
                            </div>
                        </li>
                    </ul> --}}
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Navigation Menu --}}
    <nav class="navbar navbar-expand-lg navbar-light orange-bg2 border-bottom d-none d-lg-flex ">
        <div class="container-fluid">
            <div class="d-lg-flex align-items-center w-100">
                <ul class="navbar-nav main_nav">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link text-dark font-14">
                            <i class="fas fa-home me-2"></i> Home
                        </a>
                    </li>
                    
                    {{-- Categories Dropdown --}}
                    <li class="nav-item dropdown category_dropdown_box">
                        <a href="#" class="nav-link text-dark font-14 category_dropdown d-flex align-items-center">
                            <i class="fas fa-list me-2"></i>
                            <span>All Categories</span>
                        </a>
                        <ul class="categories">
                            @php
                                $categoryMenu = Menu::getByName('Category Menu');
                            @endphp
                            @if($categoryMenu)
                                @foreach ($categoryMenu as $menu)
                                    <li class="nav-item">
                                        <a href="{{ $menu['link'] }}" class="nav-link-black py-2">
                                            <i class="fa fa-dot-circle-o me-2"></i> {{ $menu['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/shop') }}" class="nav-link text-dark font-14">
                            <i class="fas fa-tag me-2"></i> Top Selling
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/new-product') }}" class="nav-link text-dark font-14">
                            <i class="fas fa-shop me-2"></i> New Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ url('/flash-product') }}" class="nav-link text-dark font-14">
                            <i class="fas fa-bolt me-2"></i> Flash Sale
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    {{-- Mobile Side Menu --}}
    <div class="mobile-side-menu">
        <div class="side-menu-content">
            <div class="on-canvas-header-info d-flex justify-content-between align-items-center p-3 border-bottom">
                <div class="logo-wrapper">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}" style="height: 40px;">
                    </a>
                </div>
                <span class="side-menu-close btn p-0" style="font-size: 24px;"><i class="fa fa-times"></i></span>
            </div>
            <div class="mobile-menu-container p-3" style="overflow-y: auto; height: calc(100vh - 70px);">
                <ul class="navbar-nav m-auto">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link text-dark font-14 border-bottom py-2">
                            <i class="fas fa-home me-2"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/shop') }}" class="nav-link text-dark font-14 border-bottom py-2">
                            <i class="fas fa-tag me-2"></i> Top Selling
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/new-product') }}" class="nav-link text-dark font-14 border-bottom py-2">
                            <i class="fas fa-shop me-2"></i> New Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/flash-product') }}" class="nav-link text-dark font-14 border-bottom py-2">
                            <i class="fas fa-bolt me-2"></i> Flash Sale
                        </a>
                    </li>
                </ul>
                <div class="mt-3">
                    <h6 class="font-weight-bold mb-3">Categories</h6>
                    <ul class="navbar-nav m-auto">
                        @if($categoryMenu)
                            @foreach ($categoryMenu as $menu)
                                <li class="nav-item">
                                    <a href="{{ $menu['link'] }}" class="nav-link text-dark font-14 border-bottom py-2">
                                        <i class="fa fa-angle-right me-2"></i> {{ $menu['label'] }}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="side-menu-overlay"></div>
</header>

@push('css')
<style>
    .brand-topbar { background: #00276C; color: #ffffff; font-size: 13px; }
    .brand-topbar .topbar-item { color: #e9ecef; }
    .brand-topbar .topbar-link { color: #ffffff; text-decoration: none; }
    .brand-topbar .topbar-link:hover { text-decoration: underline; }

    .section-header.sticky-top { position: sticky; top: 0; z-index: 1020; }
    .navbar.top_nav .logo { height: 48px; object-fit: contain; }

    .category_dropdown_box .categories { max-height: 60vh; overflow-y: auto; }
    .main_nav .nav-link { font-weight: 600; }

    /* Mobile Side Menu Styles */
    .mobile-side-menu {
        position: fixed;
        top: 0;
        left: -300px;
        width: 300px;
        height: 100vh;
        background: #fff;
        z-index: 9999;
        transition: left 0.3s ease;
        box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    }
    .mobile-side-menu.show {
        left: 0;
    }
    .side-menu-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0,0,0,0.5);
        z-index: 9998;
        display: none;
    }
    .side-menu-overlay.show {
        display: block;
    }
</style>
@endpush

@push('js')
<script>
    $(document).ready(function() {
        // Mobile Side Menu Toggle
        $('.side_menu_toggler').on('click', function(e) {
            e.preventDefault();
            $('.mobile-side-menu').addClass('show');
            $('.side-menu-overlay').addClass('show');
            $('body').css('overflow', 'hidden');
        });

        $('.side-menu-close, .side-menu-overlay').on('click', function() {
            $('.mobile-side-menu').removeClass('show');
            $('.side-menu-overlay').removeClass('show');
            $('body').css('overflow', '');
        });

        let searchTimeout;
        const $searchInput = $('#search_input');
        const $searchResults = $('#search_results');
        const $searchCategory = $('#search_category');

        $searchInput.on('input', function() {
            clearTimeout(searchTimeout);
            const query = $(this).val();
            const category = $searchCategory.val();

            if (query.length < 2) {
                $searchResults.hide();
                return;
            }

            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearch') }}",
                    method: 'GET',
                    data: {
                        q: query,
                        category: category
                    },
                    success: function(response) {
                        if (response.length > 0) {
                            let html = '<ul class="list-group list-group-flush">';
                            response.forEach(function(product) {
                                html += `
                                    <li class="list-group-item">
                                        <a href="${product.url}" class="d-flex align-items-center text-decoration-none text-dark">
                                            <img src="${product.image}" alt="${product.name}" style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                            <div>
                                                <div class="fw-bold" style="font-size: 14px;">${product.name}</div>
                                                <div class="text-muted small">৳ ${product.price}</div>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });
                            html += '</ul>';
                            $searchResults.html(html).show();
                        } else {
                            $searchResults.html('<div class="p-3 text-center text-muted">No products found</div>').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Search error:", error);
                        // Optional: show error in dropdown
                        // $searchResults.html('<div class="p-3 text-center text-danger">Error loading results</div>').show();
                    }
                });
            }, 300);
        });

        // Hide results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.header_search').length) {
                $searchResults.hide();
            }
        });
    });
</script>
@endpush
