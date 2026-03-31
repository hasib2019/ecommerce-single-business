@php
    $footerMenu = Menu::getByName('Footer Menu');
@endphp

<footer class="modern-footer">
    <div class="footer-cta">
        <div class="container">
            <div class="cta-card">
                <div class="row align-items-center gy-3">
                    <div class="col-lg-7">
                        <div class="cta-title">Get offers & updates</div>
                        <div class="cta-sub">Subscribe to receive deals, new arrivals, and restock alerts.</div>
                    </div>
                    <div class="col-lg-5">
                        <form class="cta-form" action="#" method="post">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email address">
                                <button class="btn" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer-main">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <a href="{{ url('/') }}" class="footer-brand">
                        <img src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}">
                    </a>
                    <div class="footer-desc">
                        {{ Settings::get('footer_description') ?? 'Shop with confidence. Fast delivery, secure payment, and quality products.' }}
                    </div>

                    <div class="footer-social">
                        @if(Settings::get('social_facebook'))
                            <a href="{{ Settings::get('social_facebook') }}" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(Settings::get('social_instagram'))
                            <a href="{{ Settings::get('social_instagram') }}" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(Settings::get('social_twitter'))
                            <a href="{{ Settings::get('social_twitter') }}" class="social-btn" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        @endif
                        @if(Settings::get('social_linkedin'))
                            <a href="{{ Settings::get('social_linkedin') }}" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <div class="footer-title">Quick Links</div>
                    <ul class="footer-links">
                        @if($footerMenu)
                            @foreach($footerMenu as $m)
                                <li><a href="{{ $m['link'] }}">{{ $m['label'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ url('/shop') }}">Shop</a></li>
                            <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                            <li><a href="{{ url('/order-tracking') }}">Tracking</a></li>
                        @endif
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <div class="footer-title">Customer Care</div>
                    <ul class="footer-links">
                        <li><a href="{{ url('/order-tracking') }}">Order Tracking</a></li>
                        <li><a href="{{ url('/page/return-and-refund') }}">Returns &amp; Refund</a></li>
                        <li><a href="{{ url('/page/shipping') }}">Shipping Info</a></li>
                        <li><a href="{{ url('/contact-us') }}">Help &amp; Support</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <div class="footer-title">Contact</div>
                    <div class="footer-contact">
                        @if(Settings::get('phone_number'))
                            <a href="tel:{{ Settings::get('phone_number') }}" class="contact-row">
                                <span class="contact-ico"><i class="fa fa-phone"></i></span>
                                <span>{{ Settings::get('phone_number') }}</span>
                            </a>
                        @endif
                        @if(Settings::get('phone_number2'))
                            <a href="tel:{{ Settings::get('phone_number2') }}" class="contact-row">
                                <span class="contact-ico"><i class="fa fa-phone"></i></span>
                                <span>{{ Settings::get('phone_number2') }}</span>
                            </a>
                        @endif
                        @if(Settings::get('phone_number3'))
                            <a href="tel:{{ Settings::get('phone_number3') }}" class="contact-row">
                                <span class="contact-ico"><i class="fa fa-phone"></i></span>
                                <span>{{ Settings::get('phone_number3') }}</span>
                            </a>
                        @endif
                        <a href="{{ url('/contact-us') }}" class="contact-row">
                            <span class="contact-ico"><i class="fa fa-envelope"></i></span>
                            <span>Contact form</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div class="small text-muted">
                    {{ date('Y') }} &copy; {{ Settings::get('site_name') }}
                </div>
                <div class="small text-muted text-center">
                    {!! Settings::get('footer_copyright_text') !!}
                </div>
                <div class="pay-badges">
                    <span class="badge-soft">Secure</span>
                    <span class="badge-soft">Fast Delivery</span>
                    <span class="badge-soft">Support</span>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .modern-footer {
        background: #0b1220;
        color: #e5e7eb;
        margin-top: 40px;
        font-size: 13px;
    }
    .modern-footer a {
        color: #e5e7eb;
        text-decoration: none;
    }
    .modern-footer a:hover {
        color: #ffffff;
    }
    .footer-cta {
        padding: 24px 0 0;
        background: radial-gradient(circle at top, rgba(59,130,246,0.25), rgba(11,18,32,0) 55%);
    }
    .cta-card {
        border-radius: 18px;
        padding: 18px 18px;
        background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.03));
        border: 1px solid rgba(255,255,255,0.10);
        box-shadow: 0 18px 40px rgba(0,0,0,0.18);
        backdrop-filter: blur(10px);
    }
    .cta-title {
        font-size: 18px;
        font-weight: 800;
        color: #ffffff;
        letter-spacing: .01em;
    }
    .cta-sub {
        margin-top: 4px;
        color: rgba(229,231,235,0.85);
        font-size: 13px;
    }
    .cta-form .form-control {
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.14);
        color: #ffffff;
        border-radius: 14px 0 0 14px;
        padding: 12px 12px;
    }
    .cta-form .form-control::placeholder {
        color: rgba(229,231,235,0.7);
    }
    .cta-form .btn {
        background: var(--btn-bg);
        color: #ffffff;
        border: 0;
        border-radius: 0 14px 14px 0;
        font-weight: 800;
        padding: 0 16px;
    }
    .cta-form .btn:hover {
        background: var(--btn-hover-bg);
        color: #ffffff;
    }
    .footer-main {
        padding: 26px 0 10px;
    }
    .footer-brand img {
        max-height: 44px;
        width: auto;
        object-fit: contain;
        display: block;
    }
    .footer-desc {
        margin-top: 10px;
        color: rgba(229,231,235,0.75);
        max-width: 360px;
        line-height: 1.6;
    }
    .footer-title {
        font-size: 14px;
        font-weight: 900;
        color: #ffffff;
        margin-bottom: 10px;
        letter-spacing: .02em;
        text-transform: uppercase;
    }
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .footer-links li {
        margin-bottom: 8px;
    }
    .footer-links a {
        color: rgba(229,231,235,0.78);
        font-weight: 600;
    }
    .footer-links a:hover {
        color: #ffffff;
    }
    .footer-social {
        display: flex;
        gap: 10px;
        margin-top: 14px;
    }
    .social-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        border: 1px solid rgba(255,255,255,0.14);
        background: rgba(255,255,255,0.06);
        transition: transform 0.15s ease, border-color 0.15s ease, background-color 0.15s ease;
    }
    .social-btn:hover {
        transform: translateY(-2px);
        border-color: rgba(255,255,255,0.22);
        background: rgba(255,255,255,0.10);
        color: #ffffff;
    }
    .footer-contact {
        display: grid;
        gap: 10px;
    }
    .contact-row {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 10px;
        border-radius: 14px;
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.10);
        color: rgba(229,231,235,0.85);
        font-weight: 700;
    }
    .contact-row:hover {
        background: rgba(255,255,255,0.08);
        color: #ffffff;
    }
    .contact-ico {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(59,130,246,0.16);
        color: #bfdbfe;
        flex: 0 0 auto;
    }
    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.10);
        padding: 14px 0 18px;
        margin-top: 14px;
    }
    .pay-badges {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .badge-soft {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        color: rgba(229,231,235,0.85);
        font-weight: 800;
        font-size: 12px;
    }
</style>
