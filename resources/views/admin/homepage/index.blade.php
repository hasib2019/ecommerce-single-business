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
                    <li>
                        <a href="javascript:void(0);"
                           class="hp-nav-link"
                           data-section="layout_template"
                           style="border-bottom:1px solid #dee2e6; font-weight:600; color:#0d6efd;">
                            <i class="fas fa-th-large me-1"></i> Layout / Template
                        </a>
                    </li>
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
                     PANEL: LAYOUT / TEMPLATE
                     ====================================================== --}}
                @php $currentTemplate = \App\Setting::get('HOME_CONTROLL') ?? 'home_one'; @endphp
                <div id="panel-layout_template" class="section-panel">
                    <h5 class="fw-semibold mb-1">Homepage Layout / Template</h5>
                    <p class="text-muted small mb-4">Choose how the homepage looks for your visitors. Changes take effect immediately after saving.</p>

                    <div class="row g-3" id="template-cards">

                        @php
                        $templates = [
                            'home_one'   => ['label' => 'Classic',       'desc' => 'Sidebar category menu + hero slider + sections.',           'icon' => 'fa-columns'],
                            'home_two'   => ['label' => 'Modern Grid',   'desc' => 'Full-width slider + featured category product tabs.',        'icon' => 'fa-th'],
                            'home_three' => ['label' => 'Three',         'desc' => 'Category grid layout with product tabs.',                    'icon' => 'fa-list-alt'],
                            'home_market'=> ['label' => 'Market',        'desc' => 'Marketplace style with multi-category product grid.',        'icon' => 'fa-store'],
                            'home_modern'=> ['label' => 'Ultra Modern',  'desc' => 'Clean, minimal layout for a premium shopping experience.',   'icon' => 'fa-magic'],
                            'home_watch' => ['label' => 'Watch/Luxury',  'desc' => 'Dark-accent template for high-end or electronics stores.',   'icon' => 'fa-clock'],
                            'home_linky' => ['label' => 'Linky Style',   'desc' => 'Category icon bar + horizontal product carousels + category-wise tabs. Inspired by linky.com.bd.', 'icon' => 'fa-rocket'],
                        ];
                        @endphp

                        @foreach($templates as $tKey => $tInfo)
                        <div class="col-6 col-md-4 col-lg-3">
                            <label class="template-card d-block border rounded p-3 text-center cursor-pointer h-100
                                {{ $currentTemplate === $tKey ? 'border-primary bg-light' : 'border-secondary' }}"
                                style="cursor:pointer; transition:all .2s;">
                                <input type="radio" name="homepage_template" value="{{ $tKey }}"
                                       class="template-radio d-none"
                                       {{ $currentTemplate === $tKey ? 'checked' : '' }}>
                                <div class="mb-2" style="font-size:2rem; color:{{ $currentTemplate === $tKey ? '#0d6efd' : '#aaa' }};">
                                    <i class="fas {{ $tInfo['icon'] }}"></i>
                                </div>
                                <div class="fw-semibold mb-1">{{ $tInfo['label'] }}</div>
                                <small class="text-muted d-block">{{ $tInfo['desc'] }}</small>
                                @if($currentTemplate === $tKey)
                                <span class="badge bg-primary mt-2">Active</span>
                                @endif
                            </label>
                        </div>
                        @endforeach

                    </div>

                    <div class="text-right mt-4">
                        <button type="button" class="btn btn-success px-5" id="btn-save-template">Save Layout</button>
                    </div>
                </div>

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
                    @php
                        $fdBg      = \App\Setting::get('flash_deal_bg_color')     ?? '#e2cce5';
                        $fdOutline = \App\Setting::get('flash_deal_use_outline')   ?? '1';
                        $fdOC      = \App\Setting::get('flash_deal_outline_color') ?? '#000000';
                    @endphp
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Flash Deal Section Settings</h6>
                            <div class="form-group mb-3">
                                <label>Background Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="fd_bg_text" value="{{ $fdBg }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="fd_bg_color" value="{{ $fdBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="fd_use_outline" {{ $fdOutline == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="fd_use_outline">Use Outline</label>
                            </div>
                            <div class="form-group mb-0">
                                <label>Outline color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="fd_oc_text" value="{{ $fdOC }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="fd_oc_color" value="{{ $fdOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-success px-5 btn-save-section-style" data-section="flash_deal" data-bg="fd_bg_color" data-outline="fd_use_outline" data-oc="fd_oc_color">Save</button>
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: FEATURED PRODUCTS
                     ====================================================== --}}
                <div id="panel-featured_product" class="section-panel">
                    @php
                        $fpBg      = \App\Setting::get('featured_product_bg_color')     ?? '#ffffff';
                        $fpOutline = \App\Setting::get('featured_product_use_outline')   ?? '1';
                        $fpOC      = \App\Setting::get('featured_product_outline_color') ?? '#dfdfe6';
                    @endphp
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Featured Products Section Settings</h6>
                            <div class="form-group mb-3">
                                <label>Background Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="fp_bg_text" value="{{ $fpBg }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="fp_bg_color" value="{{ $fpBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="fp_use_outline" {{ $fpOutline == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="fp_use_outline">Use Outline</label>
                            </div>
                            <div class="form-group mb-0">
                                <label>Outline color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="fp_oc_text" value="{{ $fpOC }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="fp_oc_color" value="{{ $fpOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-success px-5 btn-save-section-style" data-section="featured_product" data-bg="fp_bg_color" data-outline="fp_use_outline" data-oc="fp_oc_color">Save</button>
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: BANNER LEVEL 2
                     ====================================================== --}}
                <div id="panel-banner_2" class="section-panel">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#b2-tab-en">&#x1F1FA;&#x1F1F8; English</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#b2-tab-bn">&#x1F1E7;&#x1F1E9; Bangla</a></li>
                    </ul>
                    <div class="tab-content">
                        @foreach(['en','bn'] as $b2lang)
                        @php $b2Items = json_decode(\App\Setting::get("banner_2_links_{$b2lang}") ?? '[]', true) ?: []; @endphp
                        <div class="tab-pane fade {{ $b2lang==='en'?'show active':'' }}" id="b2-tab-{{ $b2lang }}">
                            <h6 class="fw-semibold">Banner &amp; Links <span class="text-muted fw-normal">(Max 3)</span></h6>
                            <p class="text-muted small mb-3">Minimum dimensions required: 1370px width X 360px height (If use a single banner).</p>
                            <div class="bl-rows-wrap" id="b2-rows-{{ $b2lang }}">
                                @forelse($b2Items as $b2item)
                                <div class="bl-row d-flex align-items-center mb-2" style="gap:6px;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm bl-browse" style="white-space:nowrap;">Browse</button>
                                    <input type="file" class="bl-file-input" accept="image/*" style="display:none;">
                                    <input type="text" class="form-control form-control-sm bl-img" value="{{ $b2item['image']??''  }}" placeholder="image path" readonly style="max-width:220px;">
                                    <input type="text" class="form-control form-control-sm bl-link" value="{{ $b2item['link']??''  }}" placeholder="Link URL">
                                    <button type="button" class="btn btn-outline-danger btn-sm bl-remove"><i class="fas fa-times"></i></button>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2 bl-add-row" data-wrap="b2-rows-{{ $b2lang }}"><i class="fas fa-plus-circle me-1"></i> Add New</button>
                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-success px-5 btn-save-banner-links" data-section="banner_2" data-lang="{{ $b2lang }}" data-wrap="b2-rows-{{ $b2lang }}">Save</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: BEST SELLING PRODUCTS
                     ====================================================== --}}
                <div id="panel-best_selling" class="section-panel">
                    @php
                        $bsBg      = \App\Setting::get('best_selling_bg_color')     ?? '#ffffff';
                        $bsOutline = \App\Setting::get('best_selling_use_outline')   ?? '1';
                        $bsOC      = \App\Setting::get('best_selling_outline_color') ?? '#dfdfe6';
                    @endphp
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Best Selling Products Section Settings</h6>
                            <div class="form-group mb-3">
                                <label>Background Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="bs_bg_text" value="{{ $bsBg }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="bs_bg_color" value="{{ $bsBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="bs_use_outline" {{ $bsOutline == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="bs_use_outline">Use Outline</label>
                            </div>
                            <div class="form-group mb-0">
                                <label>Outline color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="bs_oc_text" value="{{ $bsOC }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="bs_oc_color" value="{{ $bsOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-success px-5 btn-save-section-style" data-section="best_selling" data-bg="bs_bg_color" data-outline="bs_use_outline" data-oc="bs_oc_color">Save</button>
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: NEW PRODUCTS
                     ====================================================== --}}
                <div id="panel-new_product" class="section-panel">
                    @php
                        $npBg      = \App\Setting::get('new_product_bg_color')     ?? '#f5f5f5';
                        $npOutline = \App\Setting::get('new_product_use_outline')   ?? '0';
                        $npOC      = \App\Setting::get('new_product_outline_color') ?? '#000000';
                    @endphp
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">New Products Section Settings</h6>
                            <div class="form-group mb-3">
                                <label>Background Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="np_bg_text" value="{{ $npBg }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="np_bg_color" value="{{ $npBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="np_use_outline" {{ $npOutline == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="np_use_outline">Use Outline</label>
                            </div>
                            <div class="form-group mb-0">
                                <label>Outline color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="np_oc_text" value="{{ $npOC }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="np_oc_color" value="{{ $npOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-success px-5 btn-save-section-style" data-section="new_product" data-bg="np_bg_color" data-outline="np_use_outline" data-oc="np_oc_color">Save</button>
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: BANNER LEVEL 3
                     ====================================================== --}}
                <div id="panel-banner_3" class="section-panel">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#b3-tab-en">&#x1F1FA;&#x1F1F8; English</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#b3-tab-bn">&#x1F1E7;&#x1F1E9; Bangla</a></li>
                    </ul>
                    <div class="tab-content">
                        @foreach(['en','bn'] as $b3lang)
                        @php $b3Items = json_decode(\App\Setting::get("banner_3_links_{$b3lang}") ?? '[]', true) ?: []; @endphp
                        <div class="tab-pane fade {{ $b3lang==='en'?'show active':'' }}" id="b3-tab-{{ $b3lang }}">
                            <h6 class="fw-semibold">Banner &amp; Links <span class="text-muted fw-normal">(Max 3)</span></h6>
                            <p class="text-muted small mb-3">Minimum dimensions required: 436px width X 236px height (If use a single banner).</p>
                            <div class="bl-rows-wrap" id="b3-rows-{{ $b3lang }}">
                                @forelse($b3Items as $b3item)
                                <div class="bl-row d-flex align-items-center mb-2" style="gap:6px;">
                                    <button type="button" class="btn btn-outline-secondary btn-sm bl-browse" style="white-space:nowrap;">Browse</button>
                                    <input type="file" class="bl-file-input" accept="image/*" style="display:none;">
                                    <input type="text" class="form-control form-control-sm bl-img" value="{{ $b3item['image']??''  }}" placeholder="image path" readonly style="max-width:220px;">
                                    <input type="text" class="form-control form-control-sm bl-link" value="{{ $b3item['link']??''  }}" placeholder="Link URL">
                                    <button type="button" class="btn btn-outline-danger btn-sm bl-remove"><i class="fas fa-times"></i></button>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-outline-success btn-sm mt-2 bl-add-row" data-wrap="b3-rows-{{ $b3lang }}"><i class="fas fa-plus-circle me-1"></i> Add New</button>
                            <div class="text-right mt-3">
                                <button type="button" class="btn btn-success px-5 btn-save-banner-links" data-section="banner_3" data-lang="{{ $b3lang }}" data-wrap="b3-rows-{{ $b3lang }}">Save</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: COUPON SECTION
                     ====================================================== --}}
                <div id="panel-coupon" class="section-panel">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#coupon-tab-en">&#x1F1FA;&#x1F1F8; English</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#coupon-tab-bn">&#x1F1E7;&#x1F1E9; Bangla</a></li>
                    </ul>
                    <div class="tab-content">
                        @foreach(['en','bn'] as $clang)
                        @php
                            $cBgImg = \App\Setting::get("coupon_bg_image_{$clang}")  ?? '';
                            $cBgCol = \App\Setting::get("coupon_bg_color_{$clang}")  ?? '#000000';
                            $cTitle = \App\Setting::get("coupon_title_{$clang}")     ?? '';
                            $cSub   = \App\Setting::get("coupon_subtitle_{$clang}")  ?? '';
                            $cTMode = \App\Setting::get("coupon_text_mode_{$clang}") ?? 'dark';
                        @endphp
                        <div class="tab-pane fade {{ $clang==='en'?'show active':'' }}" id="coupon-tab-{{ $clang }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="fw-semibold">Background Image</label>
                                        <div class="d-flex" style="gap:0;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm coupon-bg-browse" data-lang="{{ $clang }}" style="border-radius:4px 0 0 4px;white-space:nowrap;">Browse</button>
                                            <input type="file" id="coupon_bg_file_{{ $clang }}" accept="image/*" style="display:none;">
                                            <span class="border border-left-0 px-3 py-2 flex-grow-1 text-muted small" id="coupon_bg_fname_{{ $clang }}" style="background:#fff;">{{ $cBgImg ? basename($cBgImg) : 'Choose File' }}</span>
                                        </div>
                                        <input type="hidden" id="coupon_bg_value_{{ $clang }}" value="{{ $cBgImg }}">
                                        @if($cBgImg)
                                        <div class="mt-2"><img src="{{ asset('product/thumbnail/'.$cBgImg) }}" class="img-thumbnail" id="coupon_bg_preview_{{ $clang }}" style="max-height:70px;" alt=""></div>
                                        @else
                                        <div class="mt-2" id="coupon_bg_preview_wrap_{{ $clang }}" style="display:none;"><img src="" class="img-thumbnail" id="coupon_bg_preview_{{ $clang }}" style="max-height:70px;" alt=""></div>
                                        @endif
                                        <p class="text-muted small mt-1">Minimum dimensions required: 552px width X 322px height.</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label>Title</label>
                                                <input type="text" class="form-control" id="coupon_title_{{ $clang }}" value="{{ $cTitle }}" placeholder="Title">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mb-3">
                                                <label>Subtitle</label>
                                                <input type="text" class="form-control" id="coupon_subtitle_{{ $clang }}" value="{{ $cSub }}" placeholder="Subtitle">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Coupon Text Color</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="coupon_text_mode_{{ $clang }}" id="ctm_light_{{ $clang }}" value="light" {{ $cTMode==='light'?'checked':'' }}>
                                            <label class="form-check-label" for="ctm_light_{{ $clang }}">Light</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="coupon_text_mode_{{ $clang }}" id="ctm_dark_{{ $clang }}" value="dark" {{ $cTMode==='dark'?'checked':'' }}>
                                            <label class="form-check-label" for="ctm_dark_{{ $clang }}">Dark</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="fw-semibold">Background Color</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control ss-color-text" id="coupon_bgcol_text_{{ $clang }}" value="{{ $cBgCol }}">
                                            <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="coupon_bgcol_{{ $clang }}" value="{{ $cBgCol }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="button" class="btn btn-success px-5 btn-save-coupon" data-lang="{{ $clang }}">Save</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: CATEGORY WISE PRODUCTS
                     ====================================================== --}}
                <div id="panel-category_wise" class="section-panel">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#cw-tab-en">&#x1F1FA;&#x1F1F8; English</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cw-tab-bn">&#x1F1E7;&#x1F1E9; Bangla</a></li>
                    </ul>
                    <div class="tab-content">
                        @foreach(['en','bn'] as $cwlang)
                        @php
                            $cwSecBg = \App\Setting::get("category_wise_section_bg_{$cwlang}")    ?? '#f2f4f5';
                            $cwConBg = \App\Setting::get("category_wise_content_bg_{$cwlang}")    ?? '#ffffff';
                            $cwOutl  = \App\Setting::get("category_wise_use_outline_{$cwlang}")   ?? '0';
                            $cwOC    = \App\Setting::get("category_wise_outline_color_{$cwlang}") ?? '#000000';
                            $cwSaved = array_values(array_filter(array_map('intval', explode(',', \App\Setting::get("category_wise_cats_{$cwlang}") ?? ''))));
                        @endphp
                        <div class="tab-pane fade {{ $cwlang==='en'?'show active':'' }}" id="cw-tab-{{ $cwlang }}">
                            <div class="card border mb-4">
                                <div class="card-body">
                                    <h6 class="fw-semibold mb-3">Section Settings</h6>
                                    <div class="form-group mb-3">
                                        <label>Section Background color</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control ss-color-text" id="cw_secbg_text_{{ $cwlang }}" value="{{ $cwSecBg }}">
                                            <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="cw_secbg_{{ $cwlang }}" value="{{ $cwSecBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Content Background color</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control ss-color-text" id="cw_conbg_text_{{ $cwlang }}" value="{{ $cwConBg }}">
                                            <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="cw_conbg_{{ $cwlang }}" value="{{ $cwConBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                        </div>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="cw_use_outline_{{ $cwlang }}" {{ $cwOutl=='1'?'checked':'' }}>
                                        <label class="form-check-label" for="cw_use_outline_{{ $cwlang }}">Use Outline</label>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Outline color</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control ss-color-text" id="cw_oc_text_{{ $cwlang }}" value="{{ $cwOC }}">
                                            <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="cw_oc_{{ $cwlang }}" value="{{ $cwOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h6 class="fw-semibold mb-2">Categories</h6>
                            <div id="cw-cats-{{ $cwlang }}">
                                @forelse($cwSaved as $cwCatId)
                                <div class="cw-cat-row d-flex align-items-center mb-2" style="gap:6px;">
                                    <select class="form-control cw-cat-select">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id===$cwCatId?'selected':'' }}>{{ $cat->categoryName }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-danger btn-sm cw-cat-remove"><i class="fas fa-times"></i></button>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2 cw-add-cat" data-cats="cw-cats-{{ $cwlang }}"><i class="fas fa-plus-circle me-1"></i> Add Category</button>
                            <div class="text-right mt-4">
                                <button type="button" class="btn btn-success px-5 btn-save-category-wise"
                                    data-lang="{{ $cwlang }}"
                                    data-secbg="cw_secbg_{{ $cwlang }}"
                                    data-conbg="cw_conbg_{{ $cwlang }}"
                                    data-outline="cw_use_outline_{{ $cwlang }}"
                                    data-oc="cw_oc_{{ $cwlang }}"
                                    data-cats="cw-cats-{{ $cwlang }}">Save</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: CLASSIFIEDS
                     ====================================================== --}}
                <div id="panel-classified" class="section-panel">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#cl-tab-en">&#x1F1FA;&#x1F1F8; English</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cl-tab-bn">&#x1F1E7;&#x1F1E9; Bangla</a></li>
                    </ul>
                    <div class="tab-content">
                        @foreach(['en','bn'] as $cllang)
                        @php
                            $clLarge = \App\Setting::get("classified_large_{$cllang}")         ?? '';
                            $clSmall = \App\Setting::get("classified_small_{$cllang}")         ?? '';
                            $clSecBg = \App\Setting::get("classified_section_bg_{$cllang}")    ?? '#fff9ed';
                            $clOutl  = \App\Setting::get("classified_use_outline_{$cllang}")   ?? '0';
                            $clOC    = \App\Setting::get("classified_outline_color_{$cllang}") ?? '#000000';
                        @endphp
                        <div class="tab-pane fade {{ $cllang==='en'?'show active':'' }}" id="cl-tab-{{ $cllang }}">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="fw-semibold">Large Banner <small class="text-primary fw-normal">(Will be shown in large device)</small></label>
                                        <div class="d-flex" style="gap:0;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm cl-browse" data-lang="{{ $cllang }}" data-size="large" style="border-radius:4px 0 0 4px;white-space:nowrap;">Browse</button>
                                            <input type="file" id="cl_large_file_{{ $cllang }}" accept="image/*" style="display:none;" data-size="large" data-lang="{{ $cllang }}">
                                            <span class="border border-left-0 px-3 py-2 flex-grow-1 text-muted small" id="cl_large_fname_{{ $cllang }}" style="background:#fff;">{{ $clLarge ? basename($clLarge) : 'Choose File' }}</span>
                                        </div>
                                        <input type="hidden" id="cl_large_value_{{ $cllang }}" value="{{ $clLarge }}">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="fw-semibold">Small Banner <small class="text-primary fw-normal">(Will be shown in small device)</small></label>
                                        <div class="d-flex" style="gap:0;">
                                            <button type="button" class="btn btn-outline-secondary btn-sm cl-browse" data-lang="{{ $cllang }}" data-size="small" style="border-radius:4px 0 0 4px;white-space:nowrap;">Browse</button>
                                            <input type="file" id="cl_small_file_{{ $cllang }}" accept="image/*" style="display:none;" data-size="small" data-lang="{{ $cllang }}">
                                            <span class="border border-left-0 px-3 py-2 flex-grow-1 text-muted small" id="cl_small_fname_{{ $cllang }}" style="background:#fff;">{{ $clSmall ? basename($clSmall) : 'Choose File' }}</span>
                                        </div>
                                        <input type="hidden" id="cl_small_value_{{ $cllang }}" value="{{ $clSmall }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card border">
                                        <div class="card-body">
                                            <h6 class="fw-semibold mb-3">Section Settings</h6>
                                            <div class="form-group mb-3">
                                                <label>Section Background color</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control ss-color-text" id="cl_secbg_text_{{ $cllang }}" value="{{ $clSecBg }}">
                                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="cl_secbg_{{ $cllang }}" value="{{ $clSecBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                                </div>
                                            </div>
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" id="cl_use_outline_{{ $cllang }}" {{ $clOutl=='1'?'checked':'' }}>
                                                <label class="form-check-label" for="cl_use_outline_{{ $cllang }}">Use Outline</label>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label>Outline color</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control ss-color-text" id="cl_oc_text_{{ $cllang }}" value="{{ $clOC }}">
                                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="cl_oc_{{ $cllang }}" value="{{ $clOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-4">
                                <button type="button" class="btn btn-success px-5 btn-save-classified"
                                    data-lang="{{ $cllang }}"
                                    data-secbg="cl_secbg_{{ $cllang }}"
                                    data-outline="cl_use_outline_{{ $cllang }}"
                                    data-oc="cl_oc_{{ $cllang }}">Save</button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: TOP SELLERS
                     ====================================================== --}}
                <div id="panel-top_seller" class="section-panel">
                    @php
                        $tsBg      = \App\Setting::get('top_seller_bg_color')     ?? '#fff9ed';
                        $tsOutline = \App\Setting::get('top_seller_use_outline')   ?? '0';
                        $tsOC      = \App\Setting::get('top_seller_outline_color') ?? '#000000';
                    @endphp
                    <div class="card border">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Top Sellers Section Settings</h6>
                            <div class="form-group mb-3">
                                <label>Background Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="ts_bg_text" value="{{ $tsBg }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="ts_bg_color" value="{{ $tsBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="ts_use_outline" {{ $tsOutline=='1'?'checked':'' }}>
                                <label class="form-check-label" for="ts_use_outline">Use Outline</label>
                            </div>
                            <div class="form-group mb-0">
                                <label>Outline color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="ts_oc_text" value="{{ $tsOC }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="ts_oc_color" value="{{ $tsOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-success px-5 btn-save-section-style" data-section="top_seller" data-bg="ts_bg_color" data-outline="ts_use_outline" data-oc="ts_oc_color">Save</button>
                    </div>
                </div>

                {{-- ======================================================
                     PANEL: TOP BRANDS
                     ====================================================== --}}
                <div id="panel-top_brand" class="section-panel">
                    @php
                        $tbBg      = \App\Setting::get('top_brand_bg_color')     ?? '#f0f2f5';
                        $tbOutline = \App\Setting::get('top_brand_use_outline')   ?? '0';
                        $tbOC      = \App\Setting::get('top_brand_outline_color') ?? '#000000';
                        $tbSelCats = array_values(array_filter(array_map('intval', explode(',', \App\Setting::get('top_brand_selected_cats') ?? ''))));
                    @endphp
                    <div class="card border mb-4">
                        <div class="card-body">
                            <h6 class="fw-semibold mb-3">Top Brands Section Settings</h6>
                            <div class="form-group mb-3">
                                <label>Background Color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="tb_bg_text" value="{{ $tbBg }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="tb_bg_color" value="{{ $tbBg }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="tb_use_outline" {{ $tbOutline=='1'?'checked':'' }}>
                                <label class="form-check-label" for="tb_use_outline">Use Outline</label>
                            </div>
                            <div class="form-group mb-0">
                                <label>Outline color</label>
                                <div class="input-group">
                                    <input type="text" class="form-control ss-color-text" id="tb_oc_text" value="{{ $tbOC }}">
                                    <span class="input-group-text p-1"><input type="color" class="ss-color-picker" id="tb_oc_color" value="{{ $tbOC }}" style="width:32px;height:32px;border:none;padding:0;cursor:pointer;"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="fw-semibold">Top Brands <span class="text-muted fw-normal">(Max 12)</span></label>
                        <select class="form-control" id="tb_cats_select" multiple size="8">
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ in_array($cat->id, $tbSelCats)?'selected':'' }}>{{ $cat->categoryName }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl (or Cmd) to select multiple. Max 12.</small>
                    </div>
                    <div class="text-right mt-3">
                        <button type="button" class="btn btn-success px-5" id="btn-save-top-brands">Save</button>
                    </div>
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
    // Template selector – card highlight
    // ----------------------------------------------------------------
    $(document).on('change', '.template-radio', function () {
        $('.template-card').removeClass('border-primary bg-light').addClass('border-secondary');
        $('.template-card i').css('color', '#aaa');
        $('.template-card .badge').remove();
        var $lbl = $(this).closest('.template-card');
        $lbl.addClass('border-primary bg-light').removeClass('border-secondary');
        $lbl.find('i').css('color', '#0d6efd');
        $lbl.append('<span class="badge bg-primary mt-2">Active</span>');
    });

    $('#btn-save-template').on('click', function () {
        var tpl = $('input[name="homepage_template"]:checked').val();
        if (!tpl) { toastr.warning('Please select a template.'); return; }
        $.ajax({
            url:  '{{ url('admin/homepage/save-template') }}',
            type: 'POST',
            data: { _token: csrfToken, template: tpl },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
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

    // ----------------------------------------------------------------
    // Color picker ↔ text input two-way sync
    // ----------------------------------------------------------------
    $(document).on('input', '.ss-color-picker', function () {
        var $text = $(this).closest('.input-group').find('.ss-color-text');
        $text.val($(this).val());
    });
    $(document).on('input', '.ss-color-text', function () {
        var val = $(this).val().trim();
        if (/^#[0-9a-fA-F]{6}$/.test(val)) {
            $(this).closest('.input-group').find('.ss-color-picker').val(val);
        }
    });

    // ----------------------------------------------------------------
    // Save Section Style (flash_deal, featured_product, best_selling,
    //                      new_product, top_seller)
    // ----------------------------------------------------------------
    $(document).on('click', '.btn-save-section-style', function () {
        var $btn    = $(this);
        var section = $btn.data('section');
        var bgId    = $btn.data('bg');
        var outlId  = $btn.data('outline');
        var ocId    = $btn.data('oc');

        $.ajax({
            url:  '{{ url('admin/homepage/save-section-style') }}',
            type: 'POST',
            data: {
                _token:      csrfToken,
                section:     section,
                bg_color:    $('#' + bgId).val(),
                use_outline: $('#' + outlId).is(':checked') ? '1' : '0',
                outline_color: $('#' + ocId).val()
            },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ----------------------------------------------------------------
    // Banner Links rows (banner_2, banner_3)
    // ----------------------------------------------------------------
    var BL_ROW_TPL = `
        <div class="bl-row d-flex align-items-center mb-2" style="gap:6px;">
            <button type="button" class="btn btn-outline-secondary btn-sm bl-browse" style="white-space:nowrap;">Browse</button>
            <input type="file" class="bl-file-input" accept="image/*" style="display:none;">
            <input type="text" class="form-control form-control-sm bl-img" value="" placeholder="image path" readonly style="max-width:220px;">
            <input type="text" class="form-control form-control-sm bl-link" value="" placeholder="Link URL">
            <button type="button" class="btn btn-outline-danger btn-sm bl-remove"><i class="fas fa-times"></i></button>
        </div>`;

    $(document).on('click', '.bl-add-row', function () {
        var wrapId = $(this).data('wrap');
        var $wrap  = $('#' + wrapId);
        if ($wrap.find('.bl-row').length >= 3) {
            toastr.warning('Maximum 3 banners allowed.');
            return;
        }
        $wrap.append(BL_ROW_TPL);
    });

    $(document).on('click', '.bl-remove', function () {
        $(this).closest('.bl-row').remove();
    });

    $(document).on('click', '.bl-browse', function () {
        $(this).siblings('.bl-file-input').trigger('click');
    });

    $(document).on('change', '.bl-file-input', function () {
        var $row = $(this).closest('.bl-row');
        var file = this.files[0];
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
                    $row.find('.bl-img').val(res.url);
                    toastr.success('Image uploaded.');
                } else { toastr.error('Upload failed.'); }
            },
            error: function () { toastr.error('Upload error.'); }
        });
    });

    $(document).on('click', '.btn-save-banner-links', function () {
        var $btn    = $(this);
        var section = $btn.data('section');
        var lang    = $btn.data('lang');
        var wrapId  = $btn.data('wrap');
        var items   = [];
        $('#' + wrapId + ' .bl-row').each(function () {
            var img  = $(this).find('.bl-img').val().trim();
            var link = $(this).find('.bl-link').val().trim() || '#';
            if (img) items.push({ image: img, link: link });
        });
        $.ajax({
            url:  '{{ url('admin/homepage/save-banner-links') }}',
            type: 'POST',
            data: { _token: csrfToken, section: section, lang: lang, items: items },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ----------------------------------------------------------------
    // Coupon Section
    // ----------------------------------------------------------------
    $(document).on('click', '.coupon-bg-browse', function () {
        var lang = $(this).data('lang');
        $('#coupon_bg_file_' + lang).trigger('click');
    });

    $(document).on('change', '[id^="coupon_bg_file_"]', function () {
        var lang = this.id.replace('coupon_bg_file_', '');
        var file = this.files[0];
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
                    $('#coupon_bg_value_' + lang).val(res.url);
                    $('#coupon_bg_fname_' + lang).text(res.url);
                    var src = '{{ asset('product/thumbnail/') }}/' + res.url;
                    $('#coupon_bg_preview_' + lang).attr('src', src);
                    $('#coupon_bg_preview_wrap_' + lang).show();
                    toastr.success('Image uploaded.');
                } else { toastr.error('Upload failed.'); }
            },
            error: function () { toastr.error('Upload error.'); }
        });
    });

    $(document).on('click', '.btn-save-coupon', function () {
        var lang = $(this).data('lang');
        $.ajax({
            url:  '{{ url('admin/homepage/save-coupon-section') }}',
            type: 'POST',
            data: {
                _token:    csrfToken,
                lang:      lang,
                bg_image:  $('#coupon_bg_value_' + lang).val(),
                bg_color:  $('#coupon_bgcol_' + lang).val(),
                title:     $('#coupon_title_' + lang).val(),
                subtitle:  $('#coupon_subtitle_' + lang).val(),
                text_mode: $('input[name="coupon_text_mode_' + lang + '"]:checked').val() || 'dark'
            },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ----------------------------------------------------------------
    // Category Wise
    // ----------------------------------------------------------------
    var CW_CAT_OPTIONS = `{!! $categories->map(fn($c) => '<option value="'.$c->id.'">'.$c->categoryName.'</option>')->implode('') !!}`;

    $(document).on('click', '.cw-add-cat', function () {
        var catsId = $(this).data('cats');
        var row = '<div class="cw-cat-row d-flex align-items-center mb-2" style="gap:6px;">'
            + '<select class="form-control cw-cat-select"><option value="">Select Category</option>' + CW_CAT_OPTIONS + '</select>'
            + '<button type="button" class="btn btn-outline-danger btn-sm cw-cat-remove"><i class="fas fa-times"></i></button>'
            + '</div>';
        $('#' + catsId).append(row);
    });

    $(document).on('click', '.cw-cat-remove', function () {
        $(this).closest('.cw-cat-row').remove();
    });

    $(document).on('click', '.btn-save-category-wise', function () {
        var $btn   = $(this);
        var lang   = $btn.data('lang');
        var cats   = [];
        $('#' + $btn.data('cats') + ' .cw-cat-select').each(function () {
            var v = $(this).val();
            if (v) cats.push(v);
        });
        $.ajax({
            url:  '{{ url('admin/homepage/save-category-wise') }}',
            type: 'POST',
            data: {
                _token:      csrfToken,
                lang:        lang,
                section_bg:  $('#' + $btn.data('secbg')).val(),
                content_bg:  $('#' + $btn.data('conbg')).val(),
                use_outline: $('#' + $btn.data('outline')).is(':checked') ? '1' : '0',
                outline_color: $('#' + $btn.data('oc')).val(),
                cats:        cats
            },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ----------------------------------------------------------------
    // Classified
    // ----------------------------------------------------------------
    $(document).on('click', '.cl-browse', function () {
        var lang = $(this).data('lang');
        var size = $(this).data('size');
        $('#cl_' + size + '_file_' + lang).trigger('click');
    });

    $(document).on('change', '[id^="cl_large_file_"], [id^="cl_small_file_"]', function () {
        var parts = this.id.split('_'); // cl, large/small, file, lang
        var size  = parts[1];
        var lang  = parts[3];
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
                    $('#cl_' + size + '_value_' + lang).val(res.url);
                    $('#cl_' + size + '_fname_' + lang).text(res.url);
                    toastr.success('Image uploaded.');
                } else { toastr.error('Upload failed.'); }
            },
            error: function () { toastr.error('Upload error.'); }
        });
    });

    $(document).on('click', '.btn-save-classified', function () {
        var $btn = $(this);
        var lang = $btn.data('lang');
        $.ajax({
            url:  '{{ url('admin/homepage/save-classified') }}',
            type: 'POST',
            data: {
                _token:        csrfToken,
                lang:          lang,
                large_banner:  $('#cl_large_value_' + lang).val(),
                small_banner:  $('#cl_small_value_' + lang).val(),
                section_bg:    $('#' + $btn.data('secbg')).val(),
                use_outline:   $('#' + $btn.data('outline')).is(':checked') ? '1' : '0',
                outline_color: $('#' + $btn.data('oc')).val()
            },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ----------------------------------------------------------------
    // Top Brands
    // ----------------------------------------------------------------
    $('#btn-save-top-brands').on('click', function () {
        var cats = $('#tb_cats_select').val() || [];
        if (cats.length > 12) {
            toastr.warning('Please select at most 12 brands.');
            return;
        }
        $.ajax({
            url:  '{{ url('admin/homepage/save-top-brands') }}',
            type: 'POST',
            data: {
                _token:        csrfToken,
                bg_color:      $('#tb_bg_color').val(),
                use_outline:   $('#tb_use_outline').is(':checked') ? '1' : '0',
                outline_color: $('#tb_oc_color').val(),
                cats:          cats
            },
            success: function (res) {
                if (res.status === 'success') toastr.success(res.message);
                else toastr.error(res.message || 'Failed to save.');
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

}(jQuery));
</script>
@endpush
