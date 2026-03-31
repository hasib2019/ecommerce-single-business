<header class="modern-header">
    @php
        $categoriesMenu = Menu::getAllCategories();
    @endphp

    <div class="wz-header-top bg-white">
        <div class="container">
            <div class="row align-items-center py-2 gy-2">
                <div class="col-lg-2 col-7 d-flex align-items-center">
                    <button class="navbar-toggler menu-toggle d-lg-none d-block me-2 border-0 p-0" type="button" aria-label="Menu">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="{{ url('/') }}" class="brand-wrap d-inline-flex align-items-center">
                        <img class="wz-logo" src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}">
                    </a>
                </div>

                <div class="col-lg-6 col-12">
                    <form action="{{ url('/shop') }}" class="wz-search position-relative">
                        <div class="input-group wz-search-group">
                            <select name="category" id="modern_search_category" class="form-select wz-search-select d-none d-lg-block">
                                <option value="">All Categories</option>
                                @foreach($categoriesMenu as $cat)
                                    <option value="{{ $cat['id'] }}" {{ request('category') == $cat['id'] ? 'selected' : '' }}>{{ $cat['label'] }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="q" id="modern_search_input" class="form-control wz-search-input" placeholder="Search..." autocomplete="off" value="{{ request('q') }}">
                            <button class="btn wz-search-btn" type="submit" aria-label="Search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div id="modern_search_results" class="modern-search-results"></div>
                    </form>
                </div>

                <div class="col-lg-4 col-5">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <div class="d-none d-lg-flex align-items-center gap-2 wz-phone">
                            <div class="wz-icon-round">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="wz-phone-text">
                                <div class="wz-phone-title">Hotline</div>
                                <a class="wz-phone-number" href="tel:{{ Settings::get('phone_number') }}">{{ Settings::get('phone_number') }}</a>
                            </div>
                        </div>

                        <span class="wz-sep d-none d-lg-block"></span>

                        <a href="{{ url('/page/wishlist') }}" class="wz-icon-btn d-none d-lg-inline-flex" aria-label="Wishlist">
                            <i class="far fa-heart"></i>
                        </a>

                        <span class="wz-sep d-none d-lg-block"></span>

                        <button type="button" class="wz-cart" onclick="toggleCartDrawer()" aria-label="Cart">
                            <div class="wz-icon-round">
                                <i class="fa fa-shopping-cart"></i>
                                <span class="wz-cart-badge" id="wzCartCount">0</span>
                            </div>
                            <div class="wz-cart-text d-none d-lg-block">
                                <div class="wz-cart-total"><span id="wzCartTotal">0.00</span>৳</div>
                            </div>
                        </button>

                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="wz-icon-btn" aria-label="Account">
                                <i class="far fa-user"></i>
                            </a>
                        @else
                            <a href="{{ url('/login') }}" class="wz-icon-btn" aria-label="Account">
                                <i class="far fa-user"></i>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wz-header-nav d-none d-lg-block">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ url('/') }}" class="wz-home-btn" aria-label="Home">
                        <i class="fa fa-home"></i>
                    </a>

                    <div class="wz-categories">
                        <button type="button" class="wz-categories-btn" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bars me-2"></i>
                            <span>CATEGORIES</span>
                        </button>
                        <div class="wz-categories-menu">
                            @foreach($categoriesMenu as $cat)
                                <a href="{{ $cat['link'] }}" class="wz-categories-item">{{ $cat['label'] }}</a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ url('/shop') }}" class="wz-nav-link">
                        <i class="fa fa-shopping-bag me-2"></i>
                        <span>Shop</span>
                    </a>
                    <a href="{{ url('/page/brands') }}" class="wz-nav-link">
                        <i class="fa fa-tags me-2"></i>
                        <span>Brand's</span>
                    </a>
                    <a href="{{ url('/page/blog') }}" class="wz-nav-link">
                        <i class="fa fa-blog me-2"></i>
                        <span>Blog</span>
                    </a>
                    <a href="{{ url('/page/about-us') }}" class="wz-nav-link">
                        <i class="fa fa-info-circle me-2"></i>
                        <span>About Us</span>
                    </a>
                    <a href="{{ url('/page/coupons') }}" class="wz-nav-link">
                        <i class="fa fa-ticket-alt me-2"></i>
                        <span>Coupons</span>
                    </a>
                </div>

                <div class="wz-user-mini">
                    @auth
                        <a href="{{ url('/admin/dashboard') }}" class="wz-user-mini-btn" aria-label="Dashboard">
                            <i class="far fa-user"></i>
                        </a>
                    @else
                        <a href="{{ url('/login') }}" class="wz-user-mini-btn" aria-label="Login">
                            <i class="far fa-user"></i>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>

<style>
    .modern-header,
    .modern-header * {
        box-sizing: border-box;
    }
    .modern-header {
        position: sticky;
        top: 0;
        z-index: 1020;
        background: #fff;
    }
    .modern-header .wz-header-top {
        border-bottom: 1px solid #e5e7eb !important;
        background: #ffffff !important;
    }
    .modern-header .wz-logo {
        max-height: 52px !important;
        width: auto !important;
        object-fit: contain !important;
    }
    .modern-header .wz-search-group {
        background: #ffffff !important;
        border: 1px solid #d7dce4 !important;
        border-radius: 2px !important;
        overflow: hidden !important;
        box-shadow: none !important;
        height: 42px !important;
    }
    .modern-header .wz-search-select {
        width: 132px !important;
        border: 0 !important;
        border-right: 1px solid #d7dce4 !important;
        background: #ffffff !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        color: #111827 !important;
        padding: 0 10px !important;
    }
    .modern-header .wz-search-input {
        border: 0 !important;
        padding: 9px 12px !important;
        box-shadow: none !important;
        font-weight: 600 !important;
        font-size: 15px !important;
    }
    .modern-header .wz-search-input::placeholder {
        color: #b6bfcb !important;
    }
    .modern-header .wz-search-btn {
        border: 0 !important;
        border-left: 1px solid #d7dce4 !important;
        background: #ffffff !important;
        color: #0f172a !important;
        width: 46px !important;
        min-width: 46px !important;
        padding: 0 !important;
    }
    .modern-header .wz-search-btn:hover {
        background: #f8fafc !important;
        color: #0f172a !important;
    }
    .modern-header .modern-search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 9999;
        display: none;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-top: 0;
        border-radius: 0 0 10px 10px;
        overflow: hidden;
        box-shadow: 0 16px 34px rgba(2,6,23,0.12);
        max-height: 420px;
        overflow-y: auto;
    }
    .modern-header .modern-search-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        text-decoration: none;
        color: #111827;
        border-top: 1px solid #f1f5f9;
    }
    .modern-header .modern-search-item:hover {
        background: #f8fafc;
    }
    .modern-header .modern-search-thumb {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        background: #f1f5f9;
        flex: 0 0 auto;
    }
    .modern-header .modern-search-name {
        font-weight: 700;
        font-size: 13px;
        line-height: 1.2;
    }
    .modern-header .modern-search-price {
        font-size: 12px;
        color: #64748b;
        margin-top: 2px;
    }
    .modern-header .modern-search-empty {
        padding: 14px;
        text-align: center;
        color: #64748b;
        font-size: 13px;
    }

    .modern-header .wz-icon-round {
        width: 34px;
        height: 34px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        border: 1px solid #d7dce4;
        color: #111827;
        position: relative;
    }
    .modern-header .wz-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        color: #111827 !important;
        width: 34px;
        height: 34px;
        border: 1px solid #d7dce4;
        background: #ffffff;
        text-decoration: none !important;
        transition: background-color 0.15s ease, transform 0.15s ease;
    }
    .modern-header .wz-icon-btn:hover {
        background: #f8fafc;
        transform: translateY(-1px);
    }
    .modern-header .wz-sep {
        width: 1px;
        height: 22px;
        background: #d7dce4;
    }
    .modern-header .wz-phone .wz-phone-title {
        font-size: 11px;
        line-height: 1;
        color: var(--primary-color);
        font-weight: 800;
    }
    .modern-header .wz-phone .wz-phone-number {
        font-weight: 900;
        font-size: 13px;
        color: #0f172a !important;
        text-decoration: none !important;
        line-height: 1;
    }
    .modern-header .wz-phone .wz-phone-number:hover {
        text-decoration: underline !important;
    }

    .modern-header .wz-cart {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: 0;
        background: transparent;
        padding: 0;
        color: #111827;
    }
    .modern-header .wz-cart-badge {
        position: absolute;
        top: -7px;
        right: -7px;
        background: var(--primary-color);
        color: #ffffff;
        font-weight: 900;
        font-size: 11px;
        border-radius: 999px;
        padding: 2px 6px;
        border: 2px solid #ffffff;
    }
    .modern-header .wz-cart-total {
        font-weight: 800;
        font-size: 13px;
        color: #0f172a;
        line-height: 1;
    }

    .modern-header .wz-header-nav {
        background: #080f23 !important;
        border-bottom: 0 !important;
    }
    .modern-header .wz-header-nav .container {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
    .modern-header .wz-header-nav .d-flex {
        min-height: 52px;
    }
    .modern-header .wz-home-btn {
        width: 44px;
        height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 0;
        background: #080f23;
        color: #8dd63d !important;
        text-decoration: none !important;
        font-size: 19px;
    }

    .modern-header .wz-categories {
        position: relative;
    }
    .modern-header .wz-categories-btn {
        height: 40px;
        border: 0;
        border-radius: 0;
        background: #8dd63d;
        color: #ffffff;
        font-weight: 900;
        letter-spacing: .02em;
        font-size: 14px;
        padding: 0 16px;
        display: inline-flex;
        align-items: center;
        text-transform: uppercase;
    }
    .modern-header .wz-categories-menu {
        position: absolute;
        top: 100%;
        left: 0;
        width: 300px;
        background: #ffffff;
        border: 1px solid rgba(2,6,23,0.12);
        box-shadow: 0 20px 44px rgba(2,6,23,0.16);
        max-height: 68vh;
        overflow-y: auto;
        display: none;
        z-index: 1050;
        padding: 8px;
    }
    .modern-header .wz-categories:hover .wz-categories-menu {
        display: block;
    }
    .modern-header .wz-categories-item {
        display: block;
        padding: 9px 10px;
        border-radius: 4px;
        text-decoration: none !important;
        color: #111827 !important;
        font-weight: 700;
        font-size: 13px;
    }
    .modern-header .wz-categories-item:hover {
        background: #f3f4f6;
    }

    .modern-header .wz-nav-link {
        color: #ffffff !important;
        text-decoration: none !important;
        font-weight: 800;
        font-size: 14px;
        padding: 8px 10px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        transition: background-color 0.15s ease;
        white-space: nowrap;
    }
    .modern-header .wz-nav-link i {
        color: #ffffff !important;
    }
    .modern-header .wz-nav-link:hover {
        background: rgba(255,255,255,0.08);
        color: #ffffff !important;
    }
    .modern-header .wz-user-mini-btn {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        background: rgba(255,255,255,0.10);
        color: #ffffff !important;
        text-decoration: none !important;
        border: 1px solid rgba(255,255,255,0.14);
    }
    .modern-header .wz-user-mini-btn:hover {
        background: rgba(255,255,255,0.16);
        color: #ffffff !important;
    }

    @media (max-width: 991.98px) {
        .modern-header .wz-logo {
            max-height: 42px !important;
        }
        .modern-header .wz-search-group {
            height: 40px !important;
        }
        .modern-header .wz-search-btn {
            width: 42px !important;
            min-width: 42px !important;
        }
    }
</style>

<script>
    $(document).ready(function() {
        let t;
        const $input = $('#modern_search_input');
        const $results = $('#modern_search_results');
        const $cat = $('#modern_search_category');

        function renderResults(items) {
            if (!items || items.length === 0) {
                $results.html('<div class="modern-search-empty">No products found</div>').show();
                return;
            }
            let html = '';
            items.forEach(function(p) {
                html += `
                    <a class="modern-search-item" href="${p.url}">
                        <img class="modern-search-thumb" src="${p.image}" alt="${p.name}">
                        <div class="flex-grow-1">
                            <div class="modern-search-name">${p.name}</div>
                            <div class="modern-search-price">৳ ${p.price}</div>
                        </div>
                        <i class="fa fa-arrow-right text-muted"></i>
                    </a>
                `;
            });
            $results.html(html).show();
        }

        $input.on('input', function() {
            clearTimeout(t);
            const q = String($input.val() || '').trim();
            if (q.length < 2) {
                $results.hide();
                return;
            }
            t = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearch') }}",
                    method: 'GET',
                    data: { q: q, category: $cat.val() || '' },
                    success: function(res) {
                        renderResults(res);
                    },
                    error: function() {
                        $results.hide();
                    }
                });
            }, 250);
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.wz-search').length) {
                $results.hide();
            }
        });

        function updateHeaderCartSummary() {
            $.ajax({
                url: "{{ url('/mini_cart') }}",
                method: 'GET',
                success: function(resp) {
                    const count = Number(resp && resp.count ? resp.count : 0);
                    const subtotal = resp && resp.subtotal ? String(resp.subtotal) : '0.00';
                    $('#wzCartCount').text(count);
                    $('#wzCartTotal').text(subtotal);
                }
            });
        }

        updateHeaderCartSummary();

        $(document).ajaxComplete(function() {
            updateHeaderCartSummary();
        });
    });
</script>
