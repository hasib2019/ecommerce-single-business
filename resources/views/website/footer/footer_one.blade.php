<footer class="ecom-footer">
    <div class="container">
        <?php $footer = Menu::getByName('Footer Menu') ?>

        <div class="footer-main py-5">
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="footer-brand">
                        <a href="{{ url('/') }}" class="footer-logo d-inline-flex align-items-center mb-3">
                            <img src="{{ asset(Settings::get('site_logo')) }}" alt="{{ Settings::get('site_name') }}" height="36">
                        </a>
                        <p class="footer-text">
                            Modern ecommerce experience with fast delivery, secure payment and quality products.
                        </p>
                    </div>
                </div>

                <div class="col-md-3">
                    @if($footer)
                        <h6 class="footer-title">Useful Links</h6>
                        <ul class="footer-links list-unstyled">
                            @foreach($footer as $menu)
                                <li>
                                    <a href="{{ $menu['link'] }}">{{ $menu['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="col-md-3">
                    <h6 class="footer-title">Customer Care</h6>
                    <ul class="footer-links list-unstyled">
                        <li><a href="{{ url('/order-tracking') }}">Order Tracking</a></li>
                        <li><a href="{{ url('/page/return-and-refund') }}">Returns &amp; Refund</a></li>
                        <li><a href="{{ url('/page/shipping') }}">Shipping Info</a></li>
                        <li><a href="{{ url('/contact-us') }}">Help &amp; Support</a></li>
                    </ul>
                </div>

                <div class="col-md-2">
                    <h6 class="footer-title">Stay Connected</h6>
                    <form action="#" class="footer-newsletter mb-3">
                        <div class="input-group input-group-sm">
                            <input type="email" class="form-control" placeholder="Email address">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <div class="footer-social d-flex gap-2">
                        <a href="#" class="social-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-circle"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-circle"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-center pt-3 mt-3">
            <div class="mb-2 mb-md-0 small text-muted">
                {{ date('Y') }} &copy; {{ Settings::get('site_name') }}
            </div>
            <div class="text-center small footer-copy">
                {!! Settings::get('footer_copyright_text') !!}
            </div>
            <div class="mt-2 mt-md-0">
                {{-- Optional payment icons or trust badges can go here --}}
            </div>
        </div>
    </div>
</footer>

@push('css')
<style>
    .ecom-footer {
        background: radial-gradient(circle at top, #111827 0, #020617 55%, #000 100%);
        color: #e5e7eb;
        padding-top: 32px;
        margin-top: 40px;
        font-size: 13px;
    }
    .ecom-footer a {
        color: #e5e7eb;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .ecom-footer a:hover {
        color: #38bdf8;
    }
    .ecom-footer .footer-logo img {
        display: block;
    }
    .ecom-footer .footer-text {
        color: #9ca3af;
        font-size: 13px;
        max-width: 260px;
    }
    .ecom-footer .footer-title {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #f9fafb;
        letter-spacing: .03em;
        text-transform: uppercase;
    }
    .ecom-footer .footer-links li {
        margin-bottom: 6px;
    }
    .ecom-footer .footer-links a {
        font-size: 13px;
        color: #9ca3af;
    }
    .ecom-footer .footer-links a:hover {
        color: #f9fafb;
    }
    .ecom-footer .footer-newsletter .form-control {
        background: #020617;
        border: 1px solid #374151;
        color: #e5e7eb;
    }
    .ecom-footer .footer-newsletter .form-control::placeholder {
        color: #6b7280;
    }
    .ecom-footer .footer-newsletter .btn {
        border-radius: 0 .25rem .25rem 0;
    }
    .ecom-footer .social-circle {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        border: 1px solid #374151;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        color: #e5e7eb;
    }
    .ecom-footer .social-circle:hover {
        border-color: #38bdf8;
        color: #38bdf8;
    }
    .ecom-footer .footer-bottom {
        border-top: 1px solid rgba(55,65,81,0.8);
        color: #9ca3af;
    }
    .ecom-footer .footer-copy {
        color: #9ca3af;
    }
</style>
@endpush
