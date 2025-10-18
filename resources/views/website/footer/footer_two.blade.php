<style>
    .button-shop a {
        text-align: center;
    }

    .button-shop a.footerBtn i {
        font-size: 25px;
        display: grid;
        text-align: center;
        color: #dc5504;
    }

    .multi-action {
        position: fixed;
        bottom: 8rem;
        right: 90px;
        cursor: pointer;
        box-shadow: 2px 2px 8px gray;
        text-align: center;
        align-items: center;
        justify-content: center;
        transition: 0.5s;
        z-index: 9999;
    }

    .action-button {
        position: absolute;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 0;
        outline: 0;
        font-size: 24px;
        color: white;
        z-index: 2;
        box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.26);
        transition: all .3s;
    }

    .actions {
        position: absolute;
        list-style: none inside none;
        margin: 0 0 0 0;
        padding: 0;
        width: auto;
        float: left;
        background-color: transparent;
        top: 8px;
        left: 8px;
        z-index: 1;
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .actions li {
        position: absolute;
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.16), 0 2px 5px 0 rgba(0, 0, 0, 0.26);
        margin: 0;
        background: #212121;
        color: #ffffff;
        transition: all .3s;
        transform: scale(.3);
    }

    .actions li:nth-child(1) {
        background: #ff9800;
    }

    .actions li:nth-child(2) {
        background: #2196F3;
    }

    .actions li:nth-child(3) {
        background: #00cc06;
    }

    .actions li:nth-child(4) {
        background: #E91E63;
    }

    .actions li:nth-child(5) {
        background: #4CAF50;
    }

    .actions li a {
        background: inherit;
        color: inherit;
        display: block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        line-height: 40px;
        text-align: center;
    }

    .actions li:active {
        box-shadow: 0 6px 20px 0 rgba(0, 0, 0, 0.19), 0 8px 17px 0 rgba(0, 0, 0, 0.2);
    }

    .action-button.active {
        box-shadow: 0 17px 50px 0 rgba(0, 0, 0, 0.19), 0 12px 15px 0 rgba(0, 0, 0, 0.24);
    }

    .action-button.active~.actions li {
        transition: all .3s;
        transform: scale(1);
    }

    .action-button.active~.actions li:nth-child(1) {
        margin-top: -56px;
    }

    .action-button.active~.actions li:nth-child(2) {
        margin-top: -104px;
    }

    .action-button.active~.actions li:nth-child(3) {
        margin-top: -152px;
    }

    .action-button.active~.actions li:nth-child(4) {
        margin-top: -200px;
    }

    .action-button.active~.actions li:nth-child(5) {
        margin-top: -248px;
    }

    .action-button span {
        transition: all .3s;
    }

    .action-button.active:not(.no-rotate) span {
        transform: scale(1.2) rotate(-180deg);
    }

    @media (min-width: 1600px) {
        .multi-action {
            right: 13% !important;
        }
    }

    .footer-nav {
        background: #f8f9fa;
        padding: 15px 0;
        border-top: 1px solid #dee2e6;
        display: none;
        /* Hidden by default */
    }

    /* Mobile Footer Navigation - Fixed at bottom */
    @media (max-width: 768px) {
        .footer-nav {
            display: block;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            background: #ffffff;
            border-top: 2px solid #dc5504;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 10px 0;
        }

        .m-nav-main {
            display: flex;
            justify-content: space-around;
            align-items: center;
            max-width: 100%;
            margin: 0 auto;
        }

        .button-shop {
            text-align: center;
            flex: 1;
            padding: 5px;
        }

        .button-shop a.footerBtn {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            padding: 8px 4px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .button-shop a.footerBtn:hover {
            background-color: #f8f9fa;
            transform: translateY(-2px);
        }

        .button-shop a.footerBtn i {
            font-size: 20px;
            margin-bottom: 4px;
            color: #dc5504;
        }

        .button-shop a.footerBtn span {
            font-size: 11px;
            font-weight: 500;
            color: #00276C !important;
            line-height: 1.2;
        }

        /* Add bottom padding to body to prevent content overlap */
        body {
            padding-bottom: 80px;
        }
    }

    /* Desktop - hide mobile navigation */
    @media (min-width: 769px) {
        .footer-nav {
            display: none;
        }
    }

    .footerWidget {
        background: #343a40;
        color: white;
        padding: 40px 0;
    }

    .footerWidget .widget h5 {
        color: #dc5504;
        margin-bottom: 20px;
        font-weight: bold;
    }

    .footerWidget .contact li,
    .footerWidget .quickLink li {
        margin-bottom: 10px;
        list-style: none;
    }

    .footerWidget .contact li span {
        font-weight: bold;
        color: #dc5504;
    }

    .footerWidget .quickLink li a {
        color: #adb5bd;
        text-decoration: none;
        transition: color 0.3s;
    }

    .footerWidget .quickLink li a:hover {
        color: #dc5504;
    }

    .socials a {
        margin-right: 10px;
        transition: transform 0.3s;
    }

    .socials a:hover {
        transform: scale(1.1);
    }

    .marginRight {
        margin-right: 15px;
    }
</style>

<footer class="section-footer">
    <!-- Service Highlights -->
    <section class="service-highlights py-3">
        <div class="container-fluid">
            <div class="row text-center g-3">
                <div class="col-6 col-md-3">
                    <div class="service-item">
                        <i class="fa fa-truck"></i>
                        <span>Fast Delivery</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="service-item">
                        <i class="fa fa-shield-alt"></i>
                        <span>Secure Payment</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="service-item">
                        <i class="fa fa-headset"></i>
                        <span>24/7 Support</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="service-item">
                        <i class="fa fa-sync"></i>
                        <span>Easy Returns</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer Navigation -->
    <div class="footer-nav">
        <div class="m-nav-main">
            <div class="button-shop">
                <a href="{{ route('home') }}" class="footerBtn">
                    <i class="fa fa-home"></i>
                    <span style="color: #00276C;">Home</span>
                </a>
            </div>

            <div class="button-shop">
                <a href="#" class="footerBtn side_menu_toggler">
                    <i class="fa-solid fa-bars"></i>
                    <span style="color: #00276C;">Categories</span>
                </a>
            </div>

            <div class="button-shop">
                <a href="{{ route('shop') }}" class="footerBtn">
                    <i class="fa fa-store"></i>
                    <span style="color: #00276C;">All Product</span>
                </a>
            </div>

            <div class="button-shop">
                <a href="tel:01834144430" class="footerBtn">
                    <i class="fa-solid fa-phone-volume"></i>
                    <span style="color: #00276C;">Call</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Widget Section -->
    <div class="footerWidget">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="widget">
                        <h5>
                            <i class="fa fa-home"></i> {{ Settings::get('site_name') }}
                        </h5>
                        <ul class="contact ps-lg-4 ps-3">
                            <li><span><i class="fa fa-map-marker"></i> Address:</span> 67-69 Darussalam Floor 8. Lift 7-
                                B2 - Maisa Tower-Mazar Road -Mirpur Dhaka 1216.</li>
                            <li><span><i class="fa fa-phone"></i> Hotline:</span> 01834144430</li>
                            <li><span><i class="fa fa-envelope"></i> E-mail:</span> outfitcarebd@gmail.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="widget">
                        <h5>
                            <i class="fa fa-book"></i> PAGE
                        </h5>
                        <ul class="quickLink ps-lg-4 ps-3">
                            <li><a href="https://outfitcarebd.com/about-site">About Us</a></li>
                            <li><a href="https://outfitcarebd.com/delivery-policy">Delivery Policy</a></li>
                            <li><a href="https://outfitcarebd.com/terms-condition">Terms &amp; Condition</a></li>
                            <li><a href="https://outfitcarebd.com/return-policy">Return Policy</a></li>
                        </ul>
                        <h5>
                            <i class="fa-solid fa-star"></i> FOLLOW US
                        </h5>
                        <div class="socials" style="margin: 0;">
                            <a href="https://www.facebook.com/profile.php?id=61580321238010"
                                class="btn btn-sm btn-primary me-2" aria-label="Visit our Facebook page">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-danger me-2" aria-label="Visit our youtube page">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="https://www.instagram.com/care_outfit/" class="btn btn-sm insta me-2" aria-label="Visit our instagram page">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="" class="btn btn-sm tiktok me-2" aria-label="Visit our Tiktok page">
                                <i class="fab fa-tiktok"></i>
                            </a>
                            <a href="" class="btn btn-sm twitter me-2" aria-label="Visit our twitter page">
                                <span style="font-family: sans-serif;">𝕏</span>
                            </a>
                        </div>
                        <style>
                            .insta {
                                background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
                                color: white;
                                border: none;
                            }
                            .tiktok {
                                background: #000000;
                                color: white;
                                border: none;
                            }
                            .twitter {
                                background: #000000;
                                color: white;
                                border: none;
                            }
                            .insta:hover, .tiktok:hover, .twitter:hover {
                                opacity: 0.8;
                                color: white;
                            }
                        </style>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="widget">
                        <img src="{{asset(Settings::get('site_logo'))}}" style="max-width:100%;margin-bottom:20px;" alt="{{ Settings::get('site_name') }}">
                        <div>
                            <a href="{{url('/order-tracking')}}" class="btn btn-success">
                                <i class="fa-solid fa-search"></i> Track Order
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-12">
                    <section class="footer-bottom border-top row">
                        <div class="col-md-6">
                            <p class="text-muted"> <?php echo date('Y'); ?> &copy {{ Settings::get('site_name') }}. {!! Settings::get('footer_copyright_text') !!} </p>
                        </div>
                       
                        <div class="col-md-6 text-md-right text-muted">
                            <img src="{{asset('/ssl.png')}}" width="512px" height="25px" align="right">
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .service-highlights { background: #ffffff; border-top: 1px solid #e9ecef; border-bottom: 1px solid #e9ecef; }
    .service-item { display: inline-flex; align-items: center; gap: 10px; font-weight: 600; color: #00276C; }
    .service-item i { color: #dc5504; font-size: 20px; }
</style>
