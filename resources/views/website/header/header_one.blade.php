<header class="section-header header-one-sticky">
    <section class="header-main border-bottom py-3 bg-white">
        <div class="container">
            <div class="row align-items-center">
                <!-- Logo Section -->
                <div class="col-lg-2 col-6 d-flex align-items-center">
                    <button class="navbar-toggler menu-toggle d-lg-none d-block me-2 border-0" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="{{ url('/') }}" class="brand-wrap">
                        <img class="logo" src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}" style="max-height: 45px;">
                    </a>
                </div>

                <!-- Search Bar Section -->
                <div class="col-lg-5 col-12 search-box mt-3 mt-lg-0">
                    <form action="{{ url('/shop') }}" class="search position-relative">
                        <div class="input-group w-100 rounded-pill overflow-hidden bg-light border">
                            <div class="d-lg-none search-box-back">
                                <button class="btn btn-link text-dark" type="button"><i class="fa fa-arrow-left"></i></button>
                            </div>
                            <input type="text" name="q" id="header_search_input" class="form-control border-0 bg-transparent ps-4" placeholder="Search for products ..." style="box-shadow: none;" autocomplete="off">
                            <div class="input-group-append">
                                <button class="btn bg-transparent border-0 px-4" type="submit">
                                    <i class="fa fa-search text-muted"></i>
                                </button>
                            </div>
                        </div>
                        <div id="header_search_results" class="bg-white shadow rounded-bottom" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 9999; display: none; max-height: 400px; overflow-y: auto; border: 1px solid #eee;"></div>
                    </form>
                </div>

                <!-- Right Menu Section -->
                <div class="col-lg-5 col-6 d-none d-lg-block">
                    <div class="d-flex justify-content-end align-items-center gap-4">
                        <!-- Tracking -->
                        <a href="{{ url('/order-tracking') }}" class="menu-item text-dark text-decoration-none d-flex align-items-center fw-600">
                            <span class="icon-box me-2">
                                <i class="fa fa-map-marker-alt"></i>
                            </span>
                            <span class="menu-text">Tracking</span>
                        </a>

                        <!-- Home -->
                        <a href="{{ url('/') }}" class="menu-item text-dark text-decoration-none fw-600">
                            <span class="menu-text">Home</span>
                        </a>

                        <!-- Contact Us -->
                        <a href="{{ url('/contact-us') }}" class="menu-item text-dark text-decoration-none fw-600">
                            <span class="menu-text">Contact Us</span>
                        </a>

                        <!-- Login Button -->
                        @auth
                            <a href="{{ url('/admin/dashboard') }}" class="btn-creative rounded-pill px-4 fw-bold">
                                <span>Dashboard</span>
                            </a>
                        @else
                            <a href="{{ url('/login') }}" class="btn-creative rounded-pill px-4 fw-bold">
                                <span>Login</span>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Mobile Search Icon -->
                <div class="col-6 d-lg-none text-end">
                    <div class="widgets-wrap float-end">
                        <div class="widget-header nav-search-box">
                            <a href="#" class="icon icon-sm rounded-circle border-0 text-dark"><i class="fa fa-search fa-lg"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        /* General Header Styles */
        .header-main {
            box-shadow: 0 2px 15px rgba(0,0,0,0.03);
        }
        .header-one-sticky {
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        
        .fw-600 {
            font-weight: 600;
        }

        .gap-4 {
            gap: 2rem !important;
        }

        /* Creative Menu Item Styles */
        .menu-item {
            position: relative;
            padding: 5px 0;
            transition: all 0.3s ease;
        }

        .menu-item .menu-text {
            position: relative;
            z-index: 1;
        }

        .menu-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .menu-item:hover::after {
            width: 100%;
        }

        .menu-item:hover .menu-text {
            color: var(--primary-color);
        }

        .icon-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: #f8f9fa;
            border-radius: 50%;
            transition: all 0.3s ease;
            color: #6c757d;
        }

        .menu-item:hover .icon-box {
            background: #e7f1ff;
            color: var(--primary-color);
            transform: translateY(-2px);
        }

        /* Creative Button Styles */
        .btn-creative {
            position: relative;
            display: inline-block;
            color: #333;
            background: transparent;
            border: 2px solid var(--primary-color);
            overflow: hidden;
            transition: all 0.4s ease;
            z-index: 1;
            text-decoration: none;
            padding: 8px 25px;
        }

        .btn-creative::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0;
            height: 100%;
            background: var(--primary-color);
            transition: width 0.4s ease;
            z-index: -1;
        }

        .btn-creative:hover::before {
            width: 100%;
        }

        .btn-creative:hover {
            color: #fff !important;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</header>

@push('js')
<script>
    $(document).ready(function() {
        let headerSearchTimeout;
        const $input = $('#header_search_input');
        const $results = $('#header_search_results');

        $input.on('input', function() {
            clearTimeout(headerSearchTimeout);
            const query = $(this).val();

            if (query.length < 2) {
                $results.hide();
                return;
            }

            headerSearchTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('ajaxSearch') }}",
                    method: 'GET',
                    data: { q: query },
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
                            $results.html(html).show();
                        } else {
                            $results.html('<div class="p-3 text-center text-muted">No products found</div>').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Header search error:', error);
                    }
                });
            }, 300);
        });

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-box').length) {
                $results.hide();
            }
        });
    });
</script>
@endpush
