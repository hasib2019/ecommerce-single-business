<footer class="watch-footer">
    <div class="watch-footer-main">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h5 class="watch-footer-title">{{ Settings::get('site_name') }}</h5>
                    <p class="watch-footer-text">
                        Curated collection of premium watches inspired by leading online boutiques.
                    </p>
                    <ul class="watch-footer-contact">
                        <li>
                            <i class="fa fa-map-marker-alt"></i>
                            <span>{{ Settings::get('address') }}</span>
                        </li>
                        <li>
                            <i class="fa fa-phone"></i>
                            <a href="tel:{{ Settings::get('phone_number') }}">{{ Settings::get('phone_number') }}</a>
                        </li>
                        <li>
                            <i class="fa fa-envelope"></i>
                            <a href="mailto:{{ Settings::get('default_email_address') }}">{{ Settings::get('default_email_address') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="watch-footer-title">Quick Links</h5>
                    <ul class="watch-footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('shop') }}">All Watches</a></li>
                        <li><a href="{{ url('/shop') }}?q=new">New Arrivals</a></li>
                        <li><a href="{{ url('/shop') }}?q=featured">Featured</a></li>
                        <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="watch-footer-title">Stay Updated</h5>
                    <p class="watch-footer-text">Get updates on new arrivals and special offers.</p>
                    <form class="watch-footer-newsletter">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Enter your email">
                            <button class="btn" type="button">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="watch-footer-bottom">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <span class="watch-footer-copy">
                © {{ date('Y') }} {{ Settings::get('site_name') }}. All rights reserved.
            </span>
            <div class="watch-footer-bottom-links d-none d-md-flex">
                <a href="{{ url('/page/privacy-policy') }}">Privacy Policy</a>
                <a href="{{ url('/page/terms-conditions') }}">Terms & Conditions</a>
            </div>
        </div>
    </div>

    <div class="footer-nav">
        <div class="m-nav-main">
            <div class="button-shop">
                <a href="{{ route('home') }}" class="footerBtn">
                    <i class="fa fa-home"></i>
                    <span>Home</span>
                </a>
            </div>
            <div class="button-shop">
                <a href="#" class="footerBtn side_menu_toggler">
                    <i class="fa fa-list"></i>
                    <span>Categories</span>
                </a>
            </div>
            <div class="button-shop">
                <a href="{{ route('shop') }}" class="footerBtn">
                    <i class="fa fa-store"></i>
                    <span>All Watches</span>
                </a>
            </div>
            <div class="button-shop">
                <a href="tel:{{ Settings::get('phone_number') }}" class="footerBtn">
                    <i class="fa fa-phone"></i>
                    <span>Call</span>
                </a>
            </div>
        </div>
    </div>
</footer>

@push('css')
<style>
    .watch-footer {
        background: #050816;
        color: #d3d7e6;
        margin-top: 40px;
    }
    .watch-footer-main {
        padding: 40px 15px 25px;
    }
    .watch-footer-title {
        color: var(--primary-color);
        font-size: 16px;
        margin-bottom: 14px;
        font-weight: 600;
    }
    .watch-footer-text {
        font-size: 13px;
        color: #b5bdd4;
        margin-bottom: 10px;
    }
    .watch-footer-contact {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 13px;
    }
    .watch-footer-contact li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        margin-bottom: 8px;
    }
    .watch-footer-contact i {
        margin-top: 3px;
        color: var(--primary-color);
    }
    .watch-footer-contact a {
        color: #d3d7e6;
        text-decoration: none;
    }
    .watch-footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
        font-size: 13px;
    }
    .watch-footer-links li {
        margin-bottom: 6px;
    }
    .watch-footer-links a {
        color: #d3d7e6;
        text-decoration: none;
    }
    .watch-footer-links a:hover {
        color: var(--primary-color);
    }
    .watch-footer-newsletter .input-group input {
        font-size: 13px;
        border-radius: 30px 0 0 30px;
        border: none;
        background: #101522;
        color: #f8f9fa;
    }
    .watch-footer-newsletter .input-group button {
        border-radius: 0 30px 30px 0;
        border: none;
        background: var(--primary-color);
        color: #050816;
    }
    .watch-footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.08);
        padding: 10px 15px;
        font-size: 12px;
        background: #050816;
    }
    .watch-footer-bottom-links a {
        color: #9aa1ba;
        margin-left: 12px;
        text-decoration: none;
    }
    .watch-footer-bottom-links a:hover {
        color: var(--primary-color);
    }
    .footer-nav {
        background: #101522;
        border-top: 1px solid rgba(255,255,255,0.12);
        padding: 10px 0;
    }
    .footer-nav .footerBtn {
        color: #d3d7e6;
    }
    .footer-nav .footerBtn i {
        color: var(--primary-color);
    }
</style>
@endpush
