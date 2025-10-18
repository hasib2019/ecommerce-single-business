{{-- Optimized Header Design - Merged and Enhanced --}}
<header class="section-header sticky-top">
    {{-- <h1>work header</h1> --}}
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
            <form class="d-flex header_search col-lg-6 m-auto" action="{{ url('/shop') }}">
                <?php $categoriesMenu = Menu::getByName('Category Menu'); ?>
                <select name="category" class="form-select d-lg-block d-none" style="width: 120px; font-size: 14px; border-radius: 5px 0 0 5px; font-weight: 600; background-color: #ede5e5;">
                    <option value="">All Categories</option>
                    @if ($categoriesMenu)
                        @foreach ($categoriesMenu as $cat)
                            <option value="{{ $cat['link'] }}">{{ $cat['label'] }}</option>
                        @endforeach
                    @endif
                </select>
                <input class="form-control" type="text" placeholder="Search for products, brands and more" name="q" value="{{ request('q') }}">
                <button class="btn orange-bg text-white" type="submit">
                    <i class="fa fa-search"></i>
                </button>
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
    <nav class="navbar navbar-expand-lg navbar-light orange-bg2 border-bottom">
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
                                $categoryMenu = Menu::getAllCategories();
                               
                            @endphp
                            @if($categoryMenu)
                                @foreach ($categoryMenu as $menu)
                                    <li class="nav-item">
                                        <a href="{{ $menu['link'] }}" class="nav-link py-2">
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
</header>

@push('css')
<style>
    .brand-topbar { background: #00276C; color: #ffffff; font-size: 13px; }
    .brand-topbar .topbar-item { color: #e9ecef; }
    .brand-topbar .topbar-link { color: #ffffff; text-decoration: none; }
    .brand-topbar .topbar-link:hover { text-decoration: underline; }

    .section-header.sticky-top { position: sticky; position: -webkit-sticky; top: 0; z-index: 1020; }
    .navbar.top_nav .logo { height: 48px; object-fit: contain; }

    .category_dropdown_box .categories { max-height: 60vh; overflow-y: auto; }
    .main_nav .nav-link { font-weight: 600; }
</style>
@endpush
