<div class="tile">
    <form action="{{ url('/admin/setting/') }}" method="POST" role="form">
        @csrf
        @php
            $categories = \App\Category::where('status','Active')->orderBy('categoryName')->get();
            $homeControll = Settings::get('HOME_CONTROLL') ?? env('HOME_CONTROLL', 'home_one');
            $headerControll = Settings::get('HEADER_CONTROLL') ?? env('HEADER_CONTROLL', 'header_one');
            $footerControll = Settings::get('FOOTER_CONTROLL') ?? env('FOOTER_CONTROLL', 'footer_one');
            $limit = (int) (Settings::get('home_two_featured_limit') ?? 10);
            $savedCatsStr = (string) (Settings::get('home_two_featured_cats') ?? '');
            $savedCats = array_values(array_filter(array_map('intval', explode(',', $savedCatsStr))));
        @endphp
        <h3 class="tile-title">Homepage Settings</h3>
        <hr>
        <div class="tile-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="HOME_CONTROLL">Home Variant</label>
                        <select class="form-control" id="HOME_CONTROLL" name="HOME_CONTROLL">
                            <option value="home_one" {{ $homeControll === 'home_one' ? 'selected' : '' }}>Home One</option>
                            <option value="home_two" {{ $homeControll === 'home_two' ? 'selected' : '' }}>Home Two</option>
                            <option value="home_three" {{ $homeControll === 'home_three' ? 'selected' : '' }}>Home Three</option>
                            <option value="home_watch" {{ $homeControll === 'home_watch' ? 'selected' : '' }}>Home Watch</option>
                            <option value="home_market" {{ $homeControll === 'home_market' ? 'selected' : '' }}>Home Market</option>
                            <option value="home_modern" {{ $homeControll === 'home_modern' ? 'selected' : '' }}>Home Modern</option>
                        </select>
                        <small class="text-muted">Controls which home view is rendered.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="HEADER_CONTROLL">Header Variant</label>
                        <select class="form-control" id="HEADER_CONTROLL" name="HEADER_CONTROLL">
                            <option value="header_one" {{ $headerControll === 'header_one' ? 'selected' : '' }}>Header One</option>
                            <option value="header_two" {{ $headerControll === 'header_two' ? 'selected' : '' }}>Header Two</option>
                            <option value="header_three" {{ $headerControll === 'header_three' ? 'selected' : '' }}>Header Three</option>
                            <option value="header_watch" {{ $headerControll === 'header_watch' ? 'selected' : '' }}>Header Watch</option>
                            <option value="header_market" {{ $headerControll === 'header_market' ? 'selected' : '' }}>Header Market</option>
                            <option value="header_modern" {{ $headerControll === 'header_modern' ? 'selected' : '' }}>Header Modern</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="FOOTER_CONTROLL">Footer Variant</label>
                        <select class="form-control" id="FOOTER_CONTROLL" name="FOOTER_CONTROLL">
                            <option value="footer_one" {{ $footerControll === 'footer_one' ? 'selected' : '' }}>Footer One</option>
                            <option value="footer_two" {{ $footerControll === 'footer_two' ? 'selected' : '' }}>Footer Two</option>
                            <option value="footer_three" {{ $footerControll === 'footer_three' ? 'selected' : '' }}>Footer Three</option>
                            <option value="footer_watch" {{ $footerControll === 'footer_watch' ? 'selected' : '' }}>Footer Watch</option>
                            <option value="footer_market" {{ $footerControll === 'footer_market' ? 'selected' : '' }}>Footer Market</option>
                            <option value="footer_modern" {{ $footerControll === 'footer_modern' ? 'selected' : '' }}>Footer Modern</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="primary_color">Primary Color</label>
                        <input type="color" class="form-control" id="primary_color" name="primary_color" value="{{ Settings::get('primary_color') ?? '#0d6efd' }}" style="height: 45px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="text_color">Text Color</label>
                        <input type="color" class="form-control" id="text_color" name="text_color" value="{{ Settings::get('text_color') ?? '#212529' }}" style="height: 45px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="button_bg_color">Button BG</label>
                        <input type="color" class="form-control" id="button_bg_color" name="button_bg_color" value="{{ Settings::get('button_bg_color') ?? '#0d6efd' }}" style="height: 45px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="button_hover_bg_color">Button Hover BG</label>
                        <input type="color" class="form-control" id="button_hover_bg_color" name="button_hover_bg_color" value="{{ Settings::get('button_hover_bg_color') ?? '#0b5ed7' }}" style="height: 45px;">
                    </div>
                </div>
            </div>

            <hr>
            <h5>Home Two Featured Categories</h5>
            <p class="text-muted">Add categories dynamically; one homepage section will render per selected category.</p>
            <div id="featured-cat-list">
                @php $initialCats = count($savedCats) ? $savedCats : [0,0]; @endphp
                @foreach($initialCats as $selId)
                    <div class="featured-cat-row d-flex align-items-center mb-2">
                        <select class="form-control featured-cat-select" style="max-width: 420px;">
                            <option value="">Select Category</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ $selId === $c->id ? 'selected' : '' }}>{{ $c->categoryName }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-featured-cat">Remove</button>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="home_two_featured_cats" id="home_two_featured_cats" value="{{ implode(',', $savedCats) }}">
            <div class="mt-2">
                <button type="button" id="add-featured-cat" class="btn btn-outline-primary btn-sm">Add Category</button>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="home_two_featured_limit">Products per load</label>
                        <input type="number" class="form-control" id="home_two_featured_limit" name="home_two_featured_limit" min="1" max="50" value="{{ $limit > 0 ? $limit : 10 }}">
                        <small class="text-muted">Number of products to show and load each click.</small>
                    </div>
                </div>
            </div>

            <hr>
            <h5>Home Modern Image Settings</h5>
            <p class="text-muted">Configure variable image sizes and custom banner images for Home Modern layout.</p>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="home_modern_hero_height_desktop">Hero Height (Desktop)</label>
                        <input type="number" class="form-control" id="home_modern_hero_height_desktop" name="home_modern_hero_height_desktop" min="180" max="900" value="{{ (int) (Settings::get('home_modern_hero_height_desktop') ?? 360) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="home_modern_hero_height_mobile">Hero Height (Mobile)</label>
                        <input type="number" class="form-control" id="home_modern_hero_height_mobile" name="home_modern_hero_height_mobile" min="140" max="600" value="{{ (int) (Settings::get('home_modern_hero_height_mobile') ?? 240) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="home_modern_product_image_height_desktop">Product Image Height (Desktop)</label>
                        <input type="number" class="form-control" id="home_modern_product_image_height_desktop" name="home_modern_product_image_height_desktop" min="120" max="600" value="{{ (int) (Settings::get('home_modern_product_image_height_desktop') ?? 190) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="home_modern_product_image_height_mobile">Product Image Height (Mobile)</label>
                        <input type="number" class="form-control" id="home_modern_product_image_height_mobile" name="home_modern_product_image_height_mobile" min="100" max="500" value="{{ (int) (Settings::get('home_modern_product_image_height_mobile') ?? 170) }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="home_modern_product_image_fit">Product Image Fit</label>
                        <select class="form-control" id="home_modern_product_image_fit" name="home_modern_product_image_fit">
                            @php $fitMode = (string) (Settings::get('home_modern_product_image_fit') ?? 'cover'); @endphp
                            <option value="cover" {{ $fitMode === 'cover' ? 'selected' : '' }}>Cover</option>
                            <option value="contain" {{ $fitMode === 'contain' ? 'selected' : '' }}>Contain</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="home_modern_banner_images">Banner Images (one per line)</label>
                        <textarea class="form-control" rows="5" id="home_modern_banner_images" name="home_modern_banner_images" placeholder="example: product/thumbnail/banner1.jpg&#10;https://example.com/banner2.jpg">{{ Settings::get('home_modern_banner_images') }}</textarea>
                        <small class="text-muted">Use relative path or full URL. These banners will appear between product sections.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="home_modern_banner_links">Banner Links (one per line)</label>
                        <textarea class="form-control" rows="4" id="home_modern_banner_links" name="home_modern_banner_links" placeholder="example: /shop&#10;/category/offer">{{ Settings::get('home_modern_banner_links') }}</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="home_modern_banner_heights">Banner Heights in px (one per line)</label>
                        <textarea class="form-control" rows="4" id="home_modern_banner_heights" name="home_modern_banner_heights" placeholder="example: 220&#10;280">{{ Settings::get('home_modern_banner_heights') }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button class="btn btn-success" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Settings</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
<script>
    $(function() {
        var categoryOptions = `{!! collect($categories)->map(function($c){ return '<option value="'.$c->id.'">'.e($c->categoryName).'</option>'; })->implode('') !!}`;
        function buildRow(selected) {
            var html = '<div class="featured-cat-row d-flex align-items-center mb-2">'
                + '<select class="form-control featured-cat-select" style="max-width: 420px;">'
                + '<option value="">Select Category</option>' + categoryOptions + '</select>'
                + '<button type="button" class="btn btn-outline-danger btn-sm ms-2 remove-featured-cat">Remove</button>'
                + '</div>';
            var $row = $(html);
            if (selected) { $row.find('select').val(String(selected)); }
            return $row;
        }
        function serializeFeaturedCats() {
            var ids = [];
            $('#featured-cat-list .featured-cat-select').each(function(){
                var v = $(this).val();
                if (v) { ids.push(v); }
            });
            var seen = {};
            ids = ids.filter(function(x){ if (seen[x]) return false; seen[x]=true; return true; });
            $('#home_two_featured_cats').val(ids.join(','));
        }
        $('#add-featured-cat').on('click', function(){
            $('#featured-cat-list').append(buildRow(null));
        });
        $(document).on('click', '.remove-featured-cat', function(){
            var $rows = $('#featured-cat-list .featured-cat-row');
            if ($rows.length > 1) {
                $(this).closest('.featured-cat-row').remove();
            } else {
                $(this).closest('.featured-cat-row').find('select').val('');
            }
            serializeFeaturedCats();
        });
        // Keep hidden input in sync on change
        $(document).on('change', '.featured-cat-select', function(){
            serializeFeaturedCats();
        });
        // Bind to this specific form submit and fallback to admin settings action
        $('form[action*="/admin/setting"]').on('submit', function(){
            serializeFeaturedCats();
        });
        // Initial serialization
        serializeFeaturedCats();
    });
</script>
@endpush
