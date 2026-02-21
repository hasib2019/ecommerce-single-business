<footer class="market-footer">
    <div class="container">
        <div class="footer-top">
            <div class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0">
                    <a href="{{ url('/') }}" class="logo-footer d-inline-block">
                        <img src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}" width="153" height="44">
                    </a>
                </div>
                <div class="col-lg-4 widget-newsletter mb-4 mb-lg-0">
                    <h4 class="widget-title ls-normal">Subscribe to our Newsletter</h4>
                    <p>Get all the latest information on Events, Sales and Offers.</p>
                </div>
                <div class="col-lg-5 widget-newsletter">
                    <form action="#" class="input-wrapper-inline mx-auto mx-lg-0">
                        <input type="email" class="form-control" name="email" placeholder="Email address here..." required>
                        <button class="btn btn-primary btn-rounded btn-md ml-2" type="submit">
                            subscribe<i class="d-icon-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="footer-middle">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="widget widget-info">
                        <h4 class="widget-title">Contact Info</h4>
                        <ul class="widget-body">
                            <li>
                                <label>Phone: </label>
                                <a href="tel:{{ Settings::get('phone_number') }}">{{ Settings::get('phone_number') }}</a>
                            </li>
                            <li>
                                <label>Email: </label>
                                <a href="mailto:{{ Settings::get('default_email_address') }}">{{ Settings::get('default_email_address') }}</a>
                            </li>
                            <li>
                                <label>Address: </label>
                                <span>{{ Settings::get('address') }}</span>
                            </li>
                            <li>
                                <label>WORKING DAYS / HOURS: </label>
                            </li>
                            <li>
                                <span>Mon - Sun / 9:00 AM - 8:00 PM</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="widget">
                        <h4 class="widget-title">My Account</h4>
                        <ul class="widget-body">
                            <li><a href="{{ url('/order-tracking') }}">Track My Order</a></li>
                            <li><a href="{{ url('/cart') }}">View Cart</a></li>
                            <li><a href="{{ url('/login') }}">Sign in</a></li>
                            <li><a href="{{ url('/wishlist') }}">My Wishlist</a></li>
                            <li><a href="{{ url('/page/privacy-policy') }}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="widget">
                        <h4 class="widget-title">About Us</h4>
                        <ul class="widget-body">
                            <li><a href="{{ url('/page/about-us') }}">About Us</a></li>
                            <li><a href="{{ url('/orders') }}">Order History</a></li>
                            <li><a href="{{ url('/page/return-and-refund') }}">Returns</a></li>
                            <li><a href="{{ url('/contact-us') }}">Custom Service</a></li>
                            <li><a href="{{ url('/page/terms-conditions') }}">Terms &amp; Condition</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="widget">
                        <h4 class="widget-title">Customer Service</h4>
                        <ul class="widget-body">
                            <li><a href="{{ url('/page/payment-methods') }}">Payment Methods</a></li>
                            <li><a href="{{ url('/page/money-back-guarantee') }}">Money-back Guarantee</a></li>
                            <li><a href="{{ url('/page/return-and-refund') }}">Products Returns</a></li>
                            <li><a href="{{ url('/contact-us') }}">Support Center</a></li>
                            <li><a href="{{ url('/page/shipping') }}">Shipping</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="widget widget-instagram pl-lg-3 mb-0 mb-md-6">
                        <h4 class="widget-title">Instagram</h4>
                        <figure class="widget-body row">
                            @for($i = 1; $i <= 8; $i++)
                                <div class="col-3 mb-2">
                                    <img src="{{ asset('images/instagram/0'.$i.'.jpg') }}" alt="instagram {{ $i }}" width="64" height="64">
                                </div>
                            @endfor
                        </figure>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-main">
            <div class="widget widget-category">
                <div class="category-box">
                    <h6 class="category-name">Clothing &amp; Apparel:</h6>
                    <a href="#">Boots</a>
                    <a href="#">Dresses</a>
                    <a href="#">Jeans</a>
                    <a href="#">Leather Backpack</a>
                    <a href="#">Men's Sneaker</a>
                    <a href="#">Men's T-shirt</a>
                    <a href="#">Peter England Shirts</a>
                    <a href="#">Rayban</a>
                    <a href="#">Sunglasses</a>
                </div>

                <div class="category-box">
                    <h6 class="category-name">Computer &amp; Technologies:</h6>
                    <a href="#">Apple</a>
                    <a href="#">Drone</a>
                    <a href="#">Game Controller</a>
                    <a href="#">iMac</a>
                    <a href="#">Laptop</a>
                    <a href="#">Smartphone</a>
                    <a href="#">Tablet</a>
                    <a href="#">Wireless Speaker</a>
                </div>

                <div class="category-box">
                    <h6 class="category-name">Consumer Electric:</h6>
                    <a href="#">Air Condition</a>
                    <a href="#">Audio Speaker</a>
                    <a href="#">Refrigerator</a>
                    <a href="#">Security Camera</a>
                    <a href="#">TV Television</a>
                    <a href="#">Washing Machine</a>
                </div>

                <div class="category-box">
                    <h6 class="category-name">Jewellery &amp; Watches:</h6>
                    <a href="#">Ammolite</a>
                    <a href="#">Australian Opal</a>
                    <a href="#">Diamond Ring</a>
                    <a href="#">Faceted Carnelian</a>
                    <a href="#">Gucci</a>
                    <a href="#">Leather Watcher</a>
                    <a href="#">Necklace</a>
                    <a href="#">Pendant</a>
                    <a href="#">Rolex</a>
                    <a href="#">Silver Earing</a>
                    <a href="#">Sun Pyrite</a>
                    <a href="#">Watches</a>
                </div>

                <div class="category-box">
                    <h6 class="category-name">Healthy &amp; Beauty:</h6>
                    <a href="#">Body Shower</a>
                    <a href="#">Hair Care</a>
                    <a href="#">LipStick</a>
                    <a href="#">Makeup</a>
                    <a href="#">Perfume</a>
                    <a href="#">Skin Care</a>
                </div>

                <div class="category-box">
                    <h6 class="category-name">Home, Garden &amp; Kitchen:</h6>
                    <a href="#">Bed Room</a>
                    <a href="#">Blender</a>
                    <a href="#">Chair</a>
                    <a href="#">Cookware</a>
                    <a href="#">Decor</a>
                    <a href="#">Garden Equipments</a>
                    <a href="#">Library</a>
                    <a href="#">Living Room</a>
                    <a href="#">Sofa</a>
                    <a href="#">Utensil</a>
                    <a href="#">Wayfarer</a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-left">
                <figure class="payment mb-0">
                    <img src="{{ asset('images/payment.png') }}" alt="payment" width="159" height="29">
                </figure>
            </div>
            <div class="footer-center">
                <p class="copyright mb-0">
                    {{ Settings::get('site_name') }} &copy; {{ date('Y') }}. All Rights Reserved
                </p>
            </div>
            <div class="footer-right">
                <div class="social-links">
                    <a href="#" class="social-link social-facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link social-twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link social-linkedin"><i class="fab fa-linkedin-in"></i></a>
                </div>
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
                <a href="{{ route('shop') }}" class="footerBtn">
                    <i class="fa fa-th-large"></i>
                    <span>Shop</span>
                </a>
            </div>
            <div class="button-shop">
                <a href="{{ url('/cart') }}" class="footerBtn">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Cart</span>
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
    .market-footer {
        background: #111827;
        color: #e5e7eb;
        margin-top: 40px;
        font-size: 13px;
    }
    .market-footer a {
        color: #e5e7eb;
        text-decoration: none;
    }
    .market-footer a:hover {
        color: #bfdbfe;
    }
    .market-footer .footer-top {
        padding: 24px 0;
        border-bottom: 1px solid rgba(249,250,251,0.06);
    }
    .market-footer .logo-footer img {
        max-height: 44px;
        width: auto;
    }
    .market-footer .widget-newsletter .widget-title {
        font-size: 16px;
        margin-bottom: 6px;
        font-weight: 600;
    }
    .market-footer .widget-newsletter p {
        margin-bottom: 0;
        color: #9ca3af;
        font-size: 13px;
    }
    .market-footer .input-wrapper-inline {
        display: flex;
        align-items: center;
        max-width: 420px;
    }
    .market-footer .input-wrapper-inline .form-control {
        background: #020617;
        border: 1px solid #374151;
        color: #e5e7eb;
        font-size: 13px;
    }
    .market-footer .input-wrapper-inline .btn {
        white-space: nowrap;
    }

    .market-footer .footer-middle {
        padding: 30px 0;
        border-bottom: 1px solid rgba(249,250,251,0.06);
    }
    .market-footer .widget-title {
        font-size: 14px;
        margin-bottom: 10px;
        font-weight: 600;
        color: #f9fafb;
    }
    .market-footer .widget-body {
        list-style: none;
        padding: 0;
        margin: 0;
        color: #9ca3af;
    }
    .market-footer .widget-body li {
        margin-bottom: 6px;
    }
    .market-footer .widget-info label {
        display: inline-block;
        min-width: 70px;
        font-weight: 500;
        color: #e5e7eb;
    }

    .market-footer .widget-instagram img {
        border-radius: 4px;
        object-fit: cover;
    }

    .market-footer .footer-main {
        padding: 24px 0 20px;
        border-bottom: 1px solid rgba(249,250,251,0.06);
    }
    .market-footer .widget-category {
        display: grid;
        grid-template-columns: repeat(3, minmax(0,1fr));
        gap: 14px 24px;
    }
    @media (max-width: 991.98px) {
        .market-footer .widget-category {
            grid-template-columns: repeat(2, minmax(0,1fr));
        }
    }
    @media (max-width: 575.98px) {
        .market-footer .widget-category {
            grid-template-columns: repeat(1, minmax(0,1fr));
        }
    }
    .market-footer .category-box {
        font-size: 12px;
        color: #9ca3af;
    }
    .market-footer .category-name {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
        color: #e5e7eb;
    }
    .market-footer .category-box a {
        display: inline-block;
        margin-right: 8px;
        margin-bottom: 4px;
        font-size: 12px;
        color: #9ca3af;
    }

    .market-footer .footer-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0 16px;
        font-size: 12px;
    }
    .market-footer .payment img {
        max-height: 29px;
        width: auto;
    }
    .market-footer .social-links {
        display: flex;
        gap: 10px;
    }
    .market-footer .social-link {
        width: 32px;
        height: 32px;
        border-radius: 999px;
        border: 1px solid #374151;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #e5e7eb;
    }
    .market-footer .social-link:hover {
        border-color: #3b82f6;
        color: #bfdbfe;
    }

    .market-footer .footer-nav {
        border-top: 1px solid rgba(249,250,251,0.1);
        padding: 10px 0;
    }
</style>
@endpush
