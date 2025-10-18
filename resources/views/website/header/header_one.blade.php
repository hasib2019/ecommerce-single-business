<header class="section-header">
    <section class="header-main border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-2 col-6 d-flex align-items-center">
                    <button class="navbar-toggler menu-toggle d-lg-none d-block me-2" type="button">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a href="{{ url('/') }}" class="brand-wrap">
                        <img class="logo" src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}">
                    </a> <!-- brand-wrap.// -->
                </div>
                <div class="col-lg-9 col-sm-12 search-box">
                    <form action="{{ url('/shop') }}" class="search">
                        <div class="input-group w-100">
                            <div class="d-lg-none search-box-back">
                                <button class="" type="button"><i class="fa fa-arrow-left"></i></button>
                            </div>
                            <input type="text" name="q" class="form-control" placeholder="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form> <!-- search-wrap .end// -->
                </div> <!-- col.// -->
                <div class="col-lg-1 col-sm-6 col-6">
                    <div class="widgets-wrap float-end">
                        <div class="widget-header me-4 nav-search-box d-lg-none">
                            <a href="#" class="icon icon-xs rounded-circle border"><i class="fa fa-search"
                                                                                      aria-hidden="true"></i></a>
                        </div>
                        <div class="widget-header">

                            <div class="nav-cart-box dropdown" id="cart_items">
                                <span class="badge badge-pill badge-danger notify">0</span>
                                <a href="" class="icon icon-xs rounded-circle border" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-shopping-cart d-inline-block nav-box-icon"></i>
                                    <span class="badge badge-pill badge-danger notify">0</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right px-0" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-328px, 32px, 0px);">

                                    <li>
                                        <div class="dropdown-cart px-0">
                                            <div class="dc-header">
                                                <h4 class="text-center py-2">Empty Cart</h4>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</header>