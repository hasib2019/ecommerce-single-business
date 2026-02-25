<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="max-age=604800" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <title>{{ Settings::get('site_name') }}</title>

    <script src="{{ asset('assets/js/jquery-2.0.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/fonts/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/ui.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css"
        media="only screen and (max-width: 1200px)" />
    <link type="text/css" href="{{ asset('assets/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/media.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css">

    @stack('css')
    {!! Settings::get('facebook_pixels') !!}

    <style>
        :root {
            --primary-color: {{ Settings::get('primary_color') ?? '#0d6efd' }};
            --text-color: {{ Settings::get('text_color') ?? '#212529' }};
            --btn-bg: {{ Settings::get('button_bg_color') ?? '#0d6efd' }};
            --btn-hover-bg: {{ Settings::get('button_hover_bg_color') ?? '#0b5ed7' }};
        }
        
        body {
            color: var(--text-color) !important;
        }

        /* Apply dynamic primary color */
        .text-primary, .menu-item:hover .menu-text, .icon-box i {
            color: var(--primary-color) !important;
        }
        
        /* Button Styles */
        .btn-primary, .btn-info, .orange-bg, .btn-creative::before {
            background-color: var(--btn-bg) !important;
            border-color: var(--btn-bg) !important;
            color: #fff !important;
        }
        
        .btn-primary:hover, .btn-info:hover, .orange-bg:hover, .btn-creative:hover::before {
            background-color: var(--btn-hover-bg) !important;
            border-color: var(--btn-hover-bg) !important;
        }

        .btn-creative {
            border-color: var(--btn-bg) !important;
            color: var(--text-color) !important;
        }
        
        .btn-creative:hover {
            border-color: var(--btn-hover-bg) !important;
        }

        .main {
            display: flex;
        }

        .left-menu {
            width: 20%;
            position: fixed;
            z-index: 200;
            height: 82vh;
            top: 21%;
            overflow: scroll;
        }

        .right-content {
            width: 80%;
            margin-left: 20%;
            margin-top: 9%;

        }
        
        /* Floating Cart Styles */
        .floating-cart-btn {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 9999;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 80px;
            border: 1px solid #eee;
        }
        .floating-cart-btn i {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
        }
        .floating-cart-btn .cart-count {
            background: #000;
            color: #fff;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .floating-cart-btn .cart-total {
            font-size: 12px;
            font-weight: 600;
            color: #333;
        }

        /* Drawer Styles */
        .cart-drawer {
            position: fixed;
            top: 0;
            right: -400px;
            width: 350px;
            height: 100vh;
            background: #fff;
            z-index: 10000;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            transition: right 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .cart-drawer.open {
            right: 0;
        }
        .drawer-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8f9fa;
        }
        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 15px;
        }
        .drawer-footer {
            padding: 15px;
            border-top: 1px solid #eee;
            background: #fff;
        }
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 9998;
            display: none;
        }
        .cart-overlay.open {
            display: block;
        }
        
        .dc-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        .dc-image img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 10px;
        }
        .dc-content {
            flex: 1;
        }
        .dc-actions button {
            background: none;
            border: none;
            color: #ff0000;
            cursor: pointer;
        }
    </style>

</head>

<body>
    <?php
    $headerControl = \App\Setting::get('HEADER_CONTROLL') ?? env('HEADER_CONTROLL', 'header_one');
    $homeControl = \App\Setting::get('HOME_CONTROLL') ?? env('HOME_CONTROLL', 'home_three');
    $footerControl = \App\Setting::get('FOOTER_CONTROLL') ?? env('FOOTER_CONTROLL', 'footer_one');
    ?>
    @if ($homeControl === 'home_three')
        @includeFirst(['website.header.' . $headerControl, 'website.header.header_one'])

        <main class="main" style="">
            <div class="left-menu">
                @include('website.sidebar.sidebar')
            </div>
            <div class="right-content">
                @yield('content')
                @includeFirst(['website.footer.' . $footerControl, 'website.footer.footer_one'])
            </div>
        </main>
    @else
        <main class="main-content">
            @includeFirst(['website.header.' . $headerControl, 'website.header.header_one'])
            @yield('content')
        </main>
        @includeFirst(['website.footer.' . $footerControl, 'website.footer.footer_one'])
    @endif
    
    <!-- Cart Drawer Container -->
    <div id="cart_items"></div>
    <div class="cart-overlay" onclick="toggleCartDrawer()"></div>

    <script src="{{ asset('assets/js/lazyload.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('libs/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        function toggleCartDrawer() {
            $('#cartDrawer').toggleClass('open');
            $('.cart-overlay').toggleClass('open');
        }

        $(document).ready(function() {
            updateNavCart();
        });

        function showFrontendAlert(type, message) {
            if (type === 'danger') {
                type = 'error';
            }
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "3000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr[type](message);
        }

        function updateNavCart() {
            $.ajax({
                type: "get",
                url: "{{ url('/miniCart') }}",
                contentType: "application/json",
                success: function(response) {
                    $('#cart_items').empty().prepend(response);
                }
            });
        }

        function removeFromCart(key) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                type: "DELETE",
                url: "{{ url('/checkout') }}/" + key,
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                contentType: "application/json",
                success: function(response) {

                    showFrontendAlert('success', 'Successfully Product Removed from Cart');
                    updateNavCart();
                    updateQuantity(key, 0);
                    if (response['reload'] === 'true') {
                        location.reload();
                    }

                }
            });
        }

        function updateQuantity(key, element) {
            $.get("{{ url('/updateQuantity') }}", {
                _token: '30aK3OPPMnzZeq8BKYZGsidbBTm5VsnwPGhJdtPl',
                key: key,
                quantity: element.value
            }, function(data) {
                updateNavCart();
                $('.orderDetails').html(data);
            });
        }

        function addToCart(id) {
            $.post("{{ url('/checkout') }}", {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                showFrontendAlert('success', 'Successfully Product add to cart');
                updateNavCart();
                window.location.href = '{{ url('/shop') }}';
            });
        }

        function buyNow(id) {
            $.post("{{ url('/checkout') }}", {
                _token: '{{ csrf_token() }}',
                id: id
            }, function(data) {
                showFrontendAlert('success', 'Successfully Product add to cart');
                updateNavCart();
                window.location.href = '{{ url('/checkout') }}';
            });
        }


        function cartQuantityInitialize() {
            $('.btn-number').click(function(e) {
                e.preventDefault();

                fieldName = $(this).attr('data-field');
                type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());

                if (!isNaN(currentVal)) {
                    if (type == 'minus') {

                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }

                    } else if (type == 'plus') {

                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }

                    }
                } else {
                    input.val(0);
                }
            });

            $('.input-number').focusin(function() {
                $(this).data('oldValue', $(this).val());
            });

            $('.input-number').change(function() {

                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                }


            });
            $(".input-number").keydown(function(e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }
    </script>
    @stack('js')
    @push('css')
        <style>
            @media (min-width: 992px) {

                /* Existing grid-based layout */
                .home-three-columns {
                    height: calc(100vh - 120px);
                    overflow: hidden;
                }

                .content-scroll {
                    height: calc(100vh - 120px);
                    overflow-y: auto;
                    overscroll-behavior: contain;
                }

                .rest-content {
                    height: calc(100vh - 120px);
                    overflow-y: auto;
                    overscroll-behavior: contain;
                }

                /* Your custom flex-based layout */
                .display-flex {
                    display: flex !important;
                    flex-direction: row !important;
                    align-items: stretch;
                    height: calc(100vh - 120px);
                    overflow: hidden;
                }

                /* .left-menu { box-sizing: border-box; flex: 0 0 20%; max-width: 20%; height: calc(100vh - 120px); overflow-y: auto; } */
                /* .right-content { box-sizing: border-box; flex: 1 1 80%; max-width: 80%; vh - 1:2c0-c(100v} - 120px)} */
            </st-yylauto @endpush </body></html>
