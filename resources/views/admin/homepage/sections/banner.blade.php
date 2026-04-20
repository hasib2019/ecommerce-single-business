{{--
    Reusable Banner Section Partial
    Variables: $sectionKey, $sectionLabel, $descHint
--}}
@php
    $savedLargeEn = \App\Setting::get("{$sectionKey}_large_en");
    $savedSmallEn = \App\Setting::get("{$sectionKey}_small_en");
    $savedLargeBn = \App\Setting::get("{$sectionKey}_large_bn");
    $savedSmallBn = \App\Setting::get("{$sectionKey}_small_bn");
@endphp

<div class="alert alert-info py-2 mb-4">
    <i class="fas fa-info-circle me-1"></i> {{ $descHint }}
</div>

{{-- Language tabs --}}
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#{{ $sectionKey }}-tab-en">
            🇺🇸 English
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#{{ $sectionKey }}-tab-bn">
            🇧🇩 Bangla
        </a>
    </li>
</ul>

<div class="tab-content">
    @foreach(['en' => [$savedLargeEn, $savedSmallEn], 'bn' => [$savedLargeBn, $savedSmallBn]] as $lang => $saved)
    @php [$savedLarge, $savedSmall] = $saved; @endphp
    <div class="tab-pane fade {{ $lang === 'en' ? 'show active' : '' }}" id="{{ $sectionKey }}-tab-{{ $lang }}">
        <div class="row">
            {{-- Large Banner --}}
            <div class="col-md-8">
                <label class="fw-semibold mb-2">
                    Large Banner
                    <small class="text-primary fw-normal">(Will be shown in large device)</small>
                </label>
                <div class="banner-file-wrap">
                    <button type="button"
                            class="btn-browse"
                            onclick="document.getElementById('{{ $sectionKey }}-{{ $lang }}-large-file').click()">Browse</button>
                    <span class="file-name-disp" id="{{ $sectionKey }}-{{ $lang }}-large-name">
                        {{ $savedLarge ? basename($savedLarge) : 'Choose File' }}
                    </span>
                </div>
                <input type="file" id="{{ $sectionKey }}-{{ $lang }}-large-file" accept="image/*" style="display:none;"
                       data-target="{{ $sectionKey }}-{{ $lang }}-large-value"
                       data-name="{{ $sectionKey }}-{{ $lang }}-large-name"
                       data-section="{{ $sectionKey }}"
                       data-lang="{{ $lang }}"
                       data-size="large"
                       class="banner-file-input">
                <input type="hidden" id="{{ $sectionKey }}-{{ $lang }}-large-value" value="{{ $savedLarge }}">
                <p class="hp-hint">Minimum dimensions required: 810px width X 350px height.</p>
                @if($savedLarge)
                    <div class="mt-2">
                        <img src="{{ asset('product/thumbnail/'.$savedLarge) }}"
                             class="img-fluid rounded"
                             style="max-height:80px; border:1px solid #eee; padding:3px;"
                             id="{{ $sectionKey }}-{{ $lang }}-large-preview"
                             alt="Preview">
                    </div>
                @else
                    <div class="mt-2" id="{{ $sectionKey }}-{{ $lang }}-large-preview-wrap" style="display:none;">
                        <img src="" id="{{ $sectionKey }}-{{ $lang }}-large-preview"
                             class="img-fluid rounded"
                             style="max-height:80px; border:1px solid #eee; padding:3px;" alt="">
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
                            class="btn-browse"
                            onclick="document.getElementById('{{ $sectionKey }}-{{ $lang }}-small-file').click()">Browse</button>
                    <span class="file-name-disp" id="{{ $sectionKey }}-{{ $lang }}-small-name">
                        {{ $savedSmall ? basename($savedSmall) : 'Choose File' }}
                    </span>
                </div>
                <input type="file" id="{{ $sectionKey }}-{{ $lang }}-small-file" accept="image/*" style="display:none;"
                       data-target="{{ $sectionKey }}-{{ $lang }}-small-value"
                       data-name="{{ $sectionKey }}-{{ $lang }}-small-name"
                       data-section="{{ $sectionKey }}"
                       data-lang="{{ $lang }}"
                       data-size="small"
                       class="banner-file-input">
                <input type="hidden" id="{{ $sectionKey }}-{{ $lang }}-small-value" value="{{ $savedSmall }}">
                <p class="hp-hint">Minimum dimensions required: 400px width X 200px height.</p>
                @if($savedSmall)
                    <div class="mt-2">
                        <img src="{{ asset('product/thumbnail/'.$savedSmall) }}"
                             class="img-fluid rounded"
                             style="max-height:80px; border:1px solid #eee; padding:3px;"
                             id="{{ $sectionKey }}-{{ $lang }}-small-preview"
                             alt="Preview">
                    </div>
                @else
                    <div class="mt-2" id="{{ $sectionKey }}-{{ $lang }}-small-preview-wrap" style="display:none;">
                        <img src="" id="{{ $sectionKey }}-{{ $lang }}-small-preview"
                             class="img-fluid rounded"
                             style="max-height:80px; border:1px solid #eee; padding:3px;" alt="">
                    </div>
                @endif
            </div>
        </div>

        {{-- Save --}}
        <div class="text-right mt-4">
            <button type="button"
                    class="btn btn-success px-5 btn-save-banner"
                    data-section="{{ $sectionKey }}"
                    data-lang="{{ $lang }}">
                Save
            </button>
        </div>
    </div>
    @endforeach
</div>

@push('js')
<script>
(function ($) {
    // Upload handler for banner sections
    $(document).on('change', '.banner-file-input', function () {
        var $input   = $(this);
        var file     = this.files[0];
        if (!file) return;
        var targetId    = $input.data('target');
        var nameId      = $input.data('name');
        var previewId   = targetId.replace('-value', '-preview');
        var previewWrap = targetId.replace('-value', '-preview-wrap');
        var fd = new FormData();
        fd.append('file', file);
        fd.append('_token', $('meta[name="csrf-token"]').attr('content'));
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
                    var src = '{{ asset('product/thumbnail/') }}/' + res.url;
                    if ($('#' + previewId).length) {
                        $('#' + previewId).attr('src', src).show();
                        $('#' + previewWrap).show();
                    }
                    toastr.success('Image uploaded.');
                } else { toastr.error('Upload failed.'); }
            },
            error: function () { toastr.error('Upload error.'); }
        });
    });

    // Save handler for banner sections
    $(document).on('click', '.btn-save-banner', function () {
        var section = $(this).data('section');
        var lang    = $(this).data('lang');
        var large   = $('#' + section + '-' + lang + '-large-value').val();
        var small   = $('#' + section + '-' + lang + '-small-value').val();
        $.post('{{ url('admin/homepage/save-banner') }}', {
            _token:       $('meta[name="csrf-token"]').attr('content'),
            section:      section,
            lang:         lang,
            large_banner: large,
            small_banner: small
        }, function (res) {
            if (res.status === 'success') {
                toastr.success('Banner saved successfully.');
            } else {
                toastr.error(res.message || 'Failed to save.');
            }
        });
    });
}(jQuery));
</script>
@endpush
