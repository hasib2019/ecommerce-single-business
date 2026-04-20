@extends('layouts.app')

@push('css')
<style>
    /* Sidebar nav */
    .hp-nav-list { list-style: none; margin: 0; padding: 0; }
    .hp-nav-list li a {
        display: block; padding: 10px 18px; color: #555; font-size: 0.9rem;
        border-left: 3px solid transparent; text-decoration: none;
        transition: all .15s;
    }
    .hp-nav-list li a:hover { background: #f0f4ff; color: #0d6efd; }
    .hp-nav-list li a.active {
        color: #0d6efd; font-weight: 600;
        border-left-color: #0d6efd; background: #f0f4ff;
    }
    /* Section panels */
    .section-panel { display: none; }
    .section-panel.active { display: block; }
    /* File browse row */
    .hp-file-row { display: flex; align-items: center; gap: 0; }
    .hp-file-row .btn-browse {
        border-radius: 4px 0 0 4px; border: 1px solid #ced4da;
        background: #fff; padding: 6px 14px; font-size: 0.87rem;
        white-space: nowrap; cursor: pointer;
    }
    .hp-file-row .file-name-input {
        flex: 1; border: 1px solid #ced4da; border-left: 0;
        border-right: 0; padding: 6px 10px; font-size: 0.87rem;
        background: #fff; color: #888; min-width: 0;
    }
    .hp-file-row .url-input {
        flex: 1; border: 1px solid #ced4da; border-left: 0;
        padding: 6px 10px; font-size: 0.87rem; min-width: 0;
    }
    .hp-file-row .btn-remove-row {
        border: none; background: none; color: #e05; font-size: 1.1rem;
        padding: 0 8px; cursor: pointer; line-height: 1;
    }
    /* Image preview */
    .hp-preview-thumb { width: 64px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; }
    .hp-preview-info { font-size: 0.78rem; color: #555; word-break: break-all; }
    /* Slider rows wrapper */
    .slider-row-wrap { border-bottom: 1px solid #eee; padding-bottom: 16px; margin-bottom: 16px; }
    .slider-row-wrap:last-child { border-bottom: none; }
    /* Banner section */
    .banner-file-wrap { display: flex; align-items: center; gap: 0; }
    .banner-file-wrap .btn-browse {
        padding: 7px 16px; border: 1px solid #ced4da; border-radius: 4px 0 0 4px;
        background: #fff; cursor: pointer; white-space: nowrap; font-size: 0.87rem;
    }
    .banner-file-wrap .file-name-disp {
        flex: 1; border: 1px solid #ced4da; border-left: 0; padding: 7px 10px;
        font-size: 0.87rem; color: #888; background: #fff;
    }
    .hp-hint { font-size: 0.78rem; color: #6c757d; margin-top: 4px; }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="mb-0">Homepage Settings</h4>
        </div>
    </div>
</div>

<div class="row">

    {{-- ===================== LEFT SIDEBAR NAV ===================== --}}
    <div class="col-md-2 col-lg-2">
        <div class="card" style="border-right: 2px solid #dee2e6;">
            <div class="card-body p-0">
                <ul class="hp-nav-list" id="hp-nav">
                    @foreach($sections as $key => $label)
                    <li>
                        <a href="javascript:void(0);"
                           class="hp-nav-link {{ $loop->first ? 'active' : '' }}"
                           data-section="{{ $key }}">
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    {{-- ===================== RIGHT CONTENT PANELS ===================== --}}
    <div class="col-md-10 col-lg-10">
        <div class="card">
            <div class="card-body">

                {{-- ======================================================
                     PANEL: HOME SLIDER  (DataTable – multiple slides)
                     ====================================================== --}}
                <div id="panel-slider" class="section-panel active">
                    <div class="alert alert-info py-2 mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        Minimum dimensions required: <strong>810px width × 350px height.</strong><br>
                        <small>We have limited banner height to maintain UI. We crop from both left &amp; right sides in view for different devices to make it responsive.</small>
                    </div>

                    <div id="slider-rows-container">
                        @forelse($sliders as $slider)
                        <div class="slider-row card mb-2 border" style="background:#fafafa;">
                            <div class="card-body py-2 px-3">
                                <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm btn-slider-browse" style="white-space:nowrap;">Browse</button>
                                    <input type="file" class="slider-file-input" accept="image/*" style="display:none;">
                                    <input type="text" class="form-control form-control-sm slider-filename-input"
                                           style="max-width:240px;"
                                           value="{{ $slider->image }}"
                                           placeholder="filename.jpg" readonly>
                                    <input type="text" class="form-control form-control-sm slider-url-input"
                                           style="max-width:260px;"
                                           value="{{ $slider->link }}"
                                           placeholder="http://">
                                    <input type="text" class="form-control form-control-sm slider-name-input"
                                           style="max-width:180px;"
                                           value="{{ $slider->name }}"
                                           placeholder="Slide name (optional)">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-slider-remove" title="Remove this slide">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @if($slider->image)
                                <div class="mt-2 slider-preview-wrap">
                                    <img src="{{ asset('product/thumbnail/'.$slider->image) }}"
                                         class="img-thumbnail slider-preview"
                                         style="max-height:80px; max-width:200px;"
                                         alt="Slide preview">
                                </div>
                                @else
                                <div class="mt-2 slider-preview-wrap" style="display:none;">
                                    <img src="" class="img-thumbnail slider-preview" style="max-height:80px; max-width:200px;" alt="">
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        {{-- empty: rows will be added via JS --}}
                        @endforelse
                    </div>

                    <div class="d-flex align-items-center mt-3" style="gap:10px;">
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btn-add-slider-row">
                            <i class="fas fa-plus me-1"></i> Add Slide
                        </button>
                        <button type="button" class="btn btn-success btn-sm px-4" id="btn-save-sliders">
                            Save All Slides
                        </button>
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: TODAY'S DEAL
                     ====================================================== --}}
                <div id="panel-today_deal" class="section-panel">

                    {{-- Language tabs --}}
                    <ul class="nav nav-tabs mb-4" id="deal-lang-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#deal-tab-en">
                                🇺🇸 English
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#deal-tab-bn">
                                🇧🇩 Bangla
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        @foreach(['en' => 'English', 'bn' => 'Bangla'] as $lang => $langLabel)
                        @php
                            $savedLarge = \App\Setting::get("today_deal_large_{$lang}");
                            $savedSmall = \App\Setting::get("today_deal_small_{$lang}");
                        @endphp
                        <div class="tab-pane fade {{ $lang === 'en' ? 'show active' : '' }}" id="deal-tab-{{ $lang }}">

                            <div class="row">
                                {{-- Large Banner --}}
                                <div class="col-md-8">
                                    <label class="fw-semibold mb-2">
                                        Large Banner
                                        <small class="text-primary fw-normal">(Will be shown in large device)</small>
                                    </label>
                                    <div class="banner-file-wrap">
                                        <button type="button"
                                                class="btn-browse hp-browse-btn"
                                                data-lang="{{ $lang }}"
                                                data-size="large"
                                                data-input="deal-{{ $lang }}-large-file">Browse</button>
                                        <span class="file-name-disp" id="deal-{{ $lang }}-large-name">
                                            {{ $savedLarge ? basename($savedLarge) : 'Choose File' }}
                                        </span>
                                    </div>
                                    <input type="file" id="deal-{{ $lang }}-large-file" accept="image/*" style="display:none;"
                                           data-target="deal-{{ $lang }}-large-value"
                                           data-name="deal-{{ $lang }}-large-name">
                                    <input type="hidden" id="deal-{{ $lang }}-large-value" value="{{ $savedLarge }}">
                                    <p class="hp-hint">Minimum dimensions required: 1370px width X 242px height.</p>
                                    @if($savedLarge)
                                        <div class="mt-2">
                                            <img src="{{ asset('product/thumbnail/'.$savedLarge) }}"
                                                 class="img-fluid rounded"
                                                 style="max-height:80px; border:1px solid #eee; padding:3px;"
                                                 id="deal-{{ $lang }}-large-preview"
                                                 alt="Large Banner Preview">
                                        </div>
                                    @else
                                        <div class="mt-2" id="deal-{{ $lang }}-large-preview-wrap" style="display:none;">
                                            <img src="" id="deal-{{ $lang }}-large-preview"
                                                 class="img-fluid rounded"
                                                 style="max-height:80px; border:1px solid #eee; padding:3px;"
                                                 alt="">
                                        </div>
                                    @endif
                                </div>

                                {{-- Small Banner --}}
                                <div class="col-md-4">
                                    <label class="fw-semibold mb-2">
                                        Small Banner
                                        <small class="text-primary fw-normal">(Will be shown in small device)</small>
                                    </label>
                                    <div class="banner-file-wrap">
                                        <button type="button"
                                                class="btn-browse hp-browse-btn"
                                                data-lang="{{ $lang }}"
                                                data-size="small"
                                                data-input="deal-{{ $lang }}-small-file">Browse</button>
                                        <span class="file-name-disp" id="deal-{{ $lang }}-small-name">
                                            {{ $savedSmall ? basename($savedSmall) : 'Choose File' }}
                                        </span>
                                    </div>
                                    <input type="file" id="deal-{{ $lang }}-small-file" accept="image/*" style="display:none;"
                                           data-target="deal-{{ $lang }}-small-value"
                                           data-name="deal-{{ $lang }}-small-name">
                                    <input type="hidden" id="deal-{{ $lang }}-small-value" value="{{ $savedSmall }}">
                                    <p class="hp-hint">Minimum dimensions required: 400px width X 200px height.</p>
                                    @if($savedSmall)
                                        <div class="mt-2">
                                            <img src="{{ asset('product/thumbnail/'.$savedSmall) }}"
                                                 class="img-fluid rounded"
                                                 style="max-height:80px; border:1px solid #eee; padding:3px;"
                                                 id="deal-{{ $lang }}-small-preview"
                                                 alt="Small Banner Preview">
                                        </div>
                                    @else
                                        <div class="mt-2" id="deal-{{ $lang }}-small-preview-wrap" style="display:none;">
                                            <img src="" id="deal-{{ $lang }}-small-preview"
                                                 class="img-fluid rounded"
                                                 style="max-height:80px; border:1px solid #eee; padding:3px;"
                                                 alt="">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Save button --}}
                            <div class="text-right mt-4">
                                <button type="button"
                                        class="btn btn-success px-5 btn-save-deal"
                                        data-lang="{{ $lang }}">
                                    Save
                                </button>
                            </div>
                        </div>
                        @endforeach

                    </div>{{-- end tab-content --}}
                </div>

                {{-- ======================================================
                     PANEL: BANNER LEVEL 1
                     ====================================================== --}}
                <div id="panel-banner_1" class="section-panel">
                    @include('admin.homepage.sections.banner', ['sectionKey' => 'banner_1', 'sectionLabel' => 'Banner Level 1', 'descHint' => 'Recommended size: 810px × 350px. The banner is cropped left & right for responsiveness. Add a link to route visitors to a product or category page.'])
                </div>

                {{-- ======================================================
                     PANEL: FLASH DEALS
                     ====================================================== --}}
                <div id="panel-flash_deal" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'flash_deal', 'hint' => 'Add flash deal items. Each item can have an image, a link, and a countdown end date/time.', 'hasCountdown' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: FEATURED PRODUCTS
                     ====================================================== --}}
                <div id="panel-featured_product" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'featured_product', 'hint' => 'Select products from the database to feature on the homepage.', 'hasProduct' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: BANNER LEVEL 2
                     ====================================================== --}}
                <div id="panel-banner_2" class="section-panel">
                    @include('admin.homepage.sections.banner', ['sectionKey' => 'banner_2', 'sectionLabel' => 'Banner Level 2', 'descHint' => 'Recommended size: 810px × 350px. Add a link to route visitors to a product or category page.'])
                </div>

                {{-- ======================================================
                     PANEL: BEST SELLING PRODUCTS
                     ====================================================== --}}
                <div id="panel-best_selling" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'best_selling', 'hint' => 'Select best-selling products from the database.', 'hasProduct' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: NEW PRODUCTS
                     ====================================================== --}}
                <div id="panel-new_product" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'new_product', 'hint' => 'Select new-arrival products to show on the homepage.', 'hasProduct' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: BANNER LEVEL 3
                     ====================================================== --}}
                <div id="panel-banner_3" class="section-panel">
                    @include('admin.homepage.sections.banner', ['sectionKey' => 'banner_3', 'sectionLabel' => 'Banner Level 3', 'descHint' => 'Recommended size: 810px × 350px. Add a link to route visitors to a product or category page.'])
                </div>

                {{-- ======================================================
                     PANEL: COUPON SECTION
                     ====================================================== --}}
                <div id="panel-coupon" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'coupon', 'hint' => 'Add coupon items with image, code, expiration date and link.', 'hasCountdown' => true, 'hasCoupon' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: CATEGORY WISE PRODUCTS
                     ====================================================== --}}
                <div id="panel-category_wise" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'category_wise', 'hint' => 'Select categories to display their products. One row per category.', 'hasCategory' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: CLASSIFIEDS
                     ====================================================== --}}
                <div id="panel-classified" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'classified', 'hint' => 'Classified listings with image, description, and link to vendor/product page.', 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: TOP SELLERS
                     ====================================================== --}}
                <div id="panel-top_seller" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'top_seller', 'hint' => 'Select top-selling products from the database.', 'hasProduct' => true, 'categories' => $categories, 'products' => $products])
                </div>

                {{-- ======================================================
                     PANEL: TOP BRANDS
                     ====================================================== --}}
                <div id="panel-top_brand" class="section-panel">
                    @include('admin.homepage.sections.datatable_section', ['sectionKey' => 'top_brand', 'hint' => 'Upload brand logos and link each to a brand or product page.', 'categories' => $categories, 'products' => $products])
                </div>

            </div>{{-- /card-body --}}
        </div>{{-- /card --}}
    </div>

</div>
@endsection

@push('js')
<script>
(function ($) {
    'use strict';

    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // ----------------------------------------------------------------
    // Home Slider – add new empty row
    // ----------------------------------------------------------------
    var SLIDER_ROW_TPL = `
        <div class="slider-row card mb-2 border" style="background:#fafafa;">
            <div class="card-body py-2 px-3">
                <div class="d-flex align-items-center flex-wrap" style="gap:8px;">
                    <button type="button" class="btn btn-outline-secondary btn-sm btn-slider-browse" style="white-space:nowrap;">Browse</button>
                    <input type="file" class="slider-file-input" accept="image/*" style="display:none;">
                    <input type="text" class="form-control form-control-sm slider-filename-input" style="max-width:240px;" placeholder="filename.jpg" readonly>
                    <input type="text" class="form-control form-control-sm slider-url-input" style="max-width:260px;" placeholder="http://">
                    <input type="text" class="form-control form-control-sm slider-name-input" style="max-width:180px;" placeholder="Slide name (optional)">
                    <button type="button" class="btn btn-outline-danger btn-sm btn-slider-remove" title="Remove"><i class="fas fa-times"></i></button>
                </div>
                <div class="mt-2 slider-preview-wrap" style="display:none;">
                    <img src="" class="img-thumbnail slider-preview" style="max-height:80px; max-width:200px;" alt="">
                </div>
            </div>
        </div>`;

    $('#btn-add-slider-row').on('click', function () {
        $('#slider-rows-container').append(SLIDER_ROW_TPL);
    });

    // Remove a slider row
    $(document).on('click', '.btn-slider-remove', function () {
        $(this).closest('.slider-row').remove();
    });

    // Browse button triggers hidden file input in same row
    $(document).on('click', '.btn-slider-browse', function () {
        $(this).closest('.slider-row').find('.slider-file-input').trigger('click');
    });

    // When file selected, upload and update row
    $(document).on('change', '.slider-file-input', function () {
        var $row  = $(this).closest('.slider-row');
        var file  = this.files[0];
        if (!file) return;

        var fd = new FormData();
        fd.append('file', file);
        fd.append('_token', csrfToken);

        $.ajax({
            url: '{{ url('admin/media') }}',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === 'success') {
                    $row.find('.slider-filename-input').val(res.url);
                    var previewSrc = '{{ asset('product/thumbnail/') }}/' + res.url;
                    $row.find('.slider-preview').attr('src', previewSrc);
                    $row.find('.slider-preview-wrap').show();
                    toastr.success('Image uploaded.');
                } else {
                    toastr.error('Upload failed.');
                }
            },
            error: function () { toastr.error('Upload error.'); }
        });
    });

    // Save all slider rows
    $('#btn-save-sliders').on('click', function () {
        var slides = [];
        $('#slider-rows-container .slider-row').each(function () {
            var image = $(this).find('.slider-filename-input').val().trim();
            var url   = $(this).find('.slider-url-input').val().trim() || '#';
            var name  = $(this).find('.slider-name-input').val().trim();
            if (image) {
                slides.push({ image: image, url: url, name: name });
            }
        });

        $.ajax({
            url:  '{{ url('admin/homepage/save-sliders') }}',
            type: 'POST',
            data: { _token: csrfToken, slides: slides },
            success: function (res) {
                if (res.status === 'success') {
                    toastr.success('Sliders saved successfully.');
                } else {
                    toastr.error(res.message || 'Failed to save.');
                }
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ----------------------------------------------------------------
    // Panel switching via sidebar nav
    // ----------------------------------------------------------------
    $('#hp-nav').on('click', '.hp-nav-link', function (e) {
        e.preventDefault();
        var section = $(this).data('section');

        // Update active state
        $('#hp-nav .hp-nav-link').removeClass('active');
        $(this).addClass('active');

        // Show the matching panel
        $('.section-panel').removeClass('active');
        $('#panel-' + section).addClass('active');
    });

    // ----------------------------------------------------------------
    // Today's Deal – Browse button triggers hidden file input
    // ----------------------------------------------------------------
    $(document).on('click', '.hp-browse-btn', function () {
        var inputId = $(this).data('input');
        $('#' + inputId).trigger('click');
    });

    // When a file is selected for Today's Deal, upload it immediately
    $(document).on('change', '#deal-en-large-file, #deal-en-small-file, #deal-bn-large-file, #deal-bn-small-file', function () {
        var $input  = $(this);
        var file    = this.files[0];
        if (!file) return;

        var targetId = $input.data('target');   // e.g. deal-en-large-value
        var nameId   = $input.data('name');     // e.g. deal-en-large-name

        // Derive preview id: replace '-value' with '-preview' from targetId
        var previewId    = targetId.replace('-value', '-preview');
        var previewWrapId = targetId.replace('-value', '-preview-wrap');

        var fd = new FormData();
        fd.append('file', file);
        fd.append('_token', csrfToken);

        $.ajax({
            url: '{{ url('admin/media') }}',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === 'success') {
                    $('#' + targetId).val(res.url);
                    $('#' + nameId).text(res.url);

                    var previewSrc = '{{ asset('product/thumbnail/') }}/' + res.url;
                    if ($('#' + previewId).length) {
                        $('#' + previewId).attr('src', previewSrc).show();
                        $('#' + previewWrapId).show();
                    }
                    toastr.success('Image uploaded successfully.');
                } else {
                    toastr.error('Image upload failed.');
                }
            },
            error: function () { toastr.error('Upload error. Please try again.'); }
        });
    });

    // ----------------------------------------------------------------
    // Today's Deal – Save button
    // ----------------------------------------------------------------
    $(document).on('click', '.btn-save-deal', function () {
        var lang  = $(this).data('lang');
        var large = $('#deal-' + lang + '-large-value').val();
        var small = $('#deal-' + lang + '-small-value').val();

        $.ajax({
            url:  '{{ url('admin/homepage/save-today-deal') }}',
            type: 'POST',
            data: {
                _token:       csrfToken,
                lang:         lang,
                large_banner: large,
                small_banner: small
            },
            success: function (res) {
                if (res.status === 'success') {
                    toastr.success("Today's Deal (" + (lang === 'en' ? 'English' : 'Bangla') + ") saved successfully.");
                } else {
                    toastr.error(res.message || 'Failed to save.');
                }
            },
            error: function () { toastr.error('Server error. Please try again.'); }
        });
    });

}(jQuery));
</script>
@endpush
