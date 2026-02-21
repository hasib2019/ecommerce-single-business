<header class="section-header market-header">
    <section class="header-main border-bottom py-2 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-6 d-flex align-items-center">
                    <button class="navbar-toggler menu-toggle d-lg-none d-block me-2 border-0" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="{{ url('/') }}" class="brand-wrap">
                        <img class="logo" src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}" style="max-height: 40px;">
                    </a>
                </div>

                <div class="col-lg-5 col-12 mt-3 mt-lg-0">
                    <form action="{{ url('/shop') }}" class="search">
                        <div class="input-group w-100 rounded-pill overflow-hidden bg-light border">
                            <input type="text" name="q" class="form-control border-0 bg-transparent ps-3" placeholder="Search in market..." style="box-shadow: none;">
                            <button class="btn bg-transparent border-0 px-3" type="submit">
                                <i class="fa fa-search text-muted"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 col-6">
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <a href="{{ route('shop') }}" class="market-header-link d-none d-md-inline-flex">
                            <i class="fa fa-store me-1"></i>
                            <span>Shop</span>
                        </a>
                        <a href="{{ url('/cart') }}" class="market-header-link">
                            <i class="fa fa-shopping-cart me-1"></i>
                            <span>Cart</span>
                        </a>
                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="market-header-btn">
                                <span>Dashboard</span>
                            </a>
                        @else
                            <a href="{{ url('/login') }}" class="market-header-btn">
                                <span>Login</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .market-header .header-main {
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
        }
        .market-header-link {
            display: inline-flex;
            align-items: center;
            font-size: 13px;
            color: #333;
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 999px;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .market-header-link i {
            font-size: 14px;
        }
        .market-header-link:hover {
            background-color: #f1f1f1;
            color: #111;
        }
        .market-header-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 18px;
            border-radius: 999px;
            border: 1px solid #111827;
            font-size: 13px;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
            overflow: hidden;
        }
        .market-header-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,#111827,#4b5563);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: -1;
        }
        .market-header-btn:hover::before {
            transform: translateX(0);
        }
        .market-header-btn:hover {
            color: #fff !important;
            border-color: #111827;
        }
    </style>
</header>

