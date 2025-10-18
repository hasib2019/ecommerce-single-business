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
                        </select>
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