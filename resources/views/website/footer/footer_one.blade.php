<footer class="section-footer border-top">
    <div class="container">
        <?php $footer = Menu::getByName('Footer Menu') ?>
        @if($footer)
        <section class="footer-top  padding-top-sm padding-bottom-sm">
            <div class="row">
                <div class="col-12">
                    <p class="mb-0 text-center">
                        @foreach($footer as $menu)
                            <a href="{{ $menu['link'] }}">{{ $menu['label'] }}</a>
                        @endforeach
                    </p>
                </div>
            </div>
        </section>
            @endif
        <section class="footer-bottom border-top row">
            <div class="col-md-2">
                <p class="text-muted"> <?php echo date("Y"); ?> &copy  {{ Settings::get('site_name') }} </p>
            </div>
            <div class="col-md-8 text-md-center">
                {!! Settings::get('footer_copyright_text') !!}
            </div>
            <div class="col-md-2 text-md-right text-muted">
                {{-- <img src="http://localhost/assets/images/ssl.png" width="512px" height="25px" align="right"> --}}
            </div>
        </section>
    </div>
</footer>