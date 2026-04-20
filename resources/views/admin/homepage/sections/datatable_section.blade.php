{{--
    Reusable DataTable Section Partial
    Variables: $sectionKey, $hint, $hasCountdown, $hasProduct, $hasCategory, $hasCoupon, $products, $categories
--}}
@php
    $hasCountdown = $hasCountdown ?? false;
    $hasProduct   = $hasProduct   ?? false;
    $hasCategory  = $hasCategory  ?? false;
    $hasCoupon    = $hasCoupon    ?? false;
@endphp

<div class="alert alert-info py-2 mb-3">
    <i class="fas fa-info-circle me-1"></i> {{ $hint }}
</div>

<div class="mb-2 text-right">
    <button type="button" class="btn btn-primary btn-sm btn-dt-add" data-section="{{ $sectionKey }}">
        <i class="fas fa-plus-circle me-1"></i> Add Item
    </button>
</div>

<div class="table-responsive">
    <table id="dt-{{ $sectionKey }}" class="table table-hover table-bordered w-100">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Link</th>
                @if($hasCountdown)<th>Countdown</th>@endif
                <th>Sort</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
</div>

{{-- Add/Edit Modal for this section --}}
<div class="modal fade" id="modal-{{ $sectionKey }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-{{ $sectionKey }}-title">Add Item</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="dt-item-id">
                <input type="hidden" class="dt-item-section" value="{{ $sectionKey }}">
                <input type="hidden" class="dt-item-image-value">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control dt-item-title" placeholder="Enter title">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Link / URL</label>
                            <input type="text" class="form-control dt-item-link" placeholder="https://...">
                        </div>
                    </div>
                </div>

                {{-- Image --}}
                <div class="form-group mb-3">
                    <label>Image</label>
                    <div>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-dt-pick-image" data-section="{{ $sectionKey }}">
                            <i class="fas fa-cloud-upload-alt me-1"></i> Browse / Upload
                        </button>
                        <input type="file" class="dt-file-input" accept="image/*" style="display:none;">
                    </div>
                    <div class="dt-preview-wrap mt-2" style="display:none;">
                        <img src="" class="img-thumbnail dt-preview" style="max-height:80px;" alt="">
                        <button type="button" class="btn btn-outline-danger btn-sm ms-2 btn-dt-clear-image">Remove</button>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Description</label>
                    <textarea class="form-control dt-item-description" rows="2" placeholder="Optional description..."></textarea>
                </div>

                <div class="row">
                    @if($hasCoupon)
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Coupon Code</label>
                            <input type="text" class="form-control dt-item-coupon" placeholder="e.g. SAVE20">
                        </div>
                    </div>
                    @endif

                    @if($hasCountdown)
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label>Countdown End</label>
                            <input type="datetime-local" class="form-control dt-item-countdown">
                        </div>
                    </div>
                    @endif

                    @if($hasProduct)
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Select Product</label>
                            <select class="form-control select2 dt-item-product">
                                <option value="">— None —</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}">{{ $p->productName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    @if($hasCategory)
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Select Category</label>
                            <select class="form-control select2 dt-item-category">
                                <option value="">— None —</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->categoryName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Sort Order</label>
                            <input type="number" class="form-control dt-item-sort" value="0" min="0">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label>Status</label>
                            <select class="form-control dt-item-status">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm btn-dt-save" data-section="{{ $sectionKey }}">
                    <i class="fas fa-save me-1"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
(function ($) {
    'use strict';
    var SK          = '{{ $sectionKey }}';
    var csrfToken   = $('meta[name="csrf-token"]').attr('content');
    var dtTable;
    var $modal      = $('#modal-' + SK);

    // Init DataTable for this section
    function initDT() {
        dtTable = $('#dt-' + SK).DataTable({
            ajax: { url: '{{ url('admin/homepage/data') }}?section=' + SK, type: 'GET' },
            columns: [
                { data: 'id',            title: '#' },
                { data: 'image_preview', title: 'Image',    orderable: false },
                { data: 'title',         title: 'Title',    defaultContent: '—' },
                { data: 'link',          title: 'Link',     defaultContent: '—',
                  render: function(d){ return d ? '<a href="'+d+'" target="_blank">'+d+'</a>' : '—'; } },
                @if($hasCountdown)
                { data: 'countdown_end', title: 'Countdown', defaultContent: '—' },
                @endif
                { data: 'sort_order',    title: 'Sort' },
                { data: 'status_btn',    title: 'Status',   orderable: false },
                { data: 'actions',       title: 'Actions',  orderable: false }
            ],
            order: [[{{ $hasCountdown ? 6 : 5 }}, 'asc']],
            pageLength: 25
        });
    }

    // Only init when panel becomes visible (on sidebar click) – use MutationObserver
    var observer = new MutationObserver(function (muts) {
        muts.forEach(function (m) {
            if (m.target.classList.contains('active') && !dtTable) {
                initDT();
            }
        });
    });
    var panelEl = document.getElementById('panel-' + SK);
    if (panelEl) {
        observer.observe(panelEl, { attributes: true, attributeFilter: ['class'] });
        // If already active on page load
        if (panelEl.classList.contains('active') && !dtTable) initDT();
    }

    // ---- Add button ----
    $(document).on('click', '.btn-dt-add[data-section="' + SK + '"]', function () {
        $modal.find('.dt-item-id').val('');
        $modal.find('.dt-item-title').val('');
        $modal.find('.dt-item-link').val('');
        $modal.find('.dt-item-description').val('');
        $modal.find('.dt-item-coupon').val('');
        $modal.find('.dt-item-countdown').val('');
        $modal.find('.dt-item-product').val('').trigger('change');
        $modal.find('.dt-item-category').val('').trigger('change');
        $modal.find('.dt-item-sort').val('0');
        $modal.find('.dt-item-status').val('Active');
        $modal.find('.dt-item-image-value').val('');
        $modal.find('.dt-preview').attr('src', '');
        $modal.find('.dt-preview-wrap').hide();
        $modal.find('#modal-' + SK + '-title').text('Add Item');
        if ($.fn.select2) { $modal.find('.select2').select2({ dropdownParent: $modal, width: '100%' }); }
        $modal.modal('show');
    });

    // ---- Browse/upload ----
    $(document).on('click', '.btn-dt-pick-image[data-section="' + SK + '"]', function () {
        $modal.find('.dt-file-input').trigger('click');
    });
    $(document).on('change', '#modal-' + SK + ' .dt-file-input', function () {
        var file = this.files[0];
        if (!file) return;
        var fd = new FormData();
        fd.append('file', file);
        fd.append('_token', csrfToken);
        $.ajax({
            url: '{{ url('admin/media') }}',
            type: 'POST', data: fd, processData: false, contentType: false,
            success: function (res) {
                if (res.status === 'success') {
                    $modal.find('.dt-item-image-value').val(res.url);
                    var src = '{{ asset('product/thumbnail/') }}/' + res.url;
                    $modal.find('.dt-preview').attr('src', src);
                    $modal.find('.dt-preview-wrap').show();
                    toastr.success('Image uploaded.');
                } else { toastr.error('Upload failed.'); }
            },
            error: function () { toastr.error('Upload error.'); }
        });
    });
    $(document).on('click', '#modal-' + SK + ' .btn-dt-clear-image', function () {
        $modal.find('.dt-item-image-value').val('');
        $modal.find('.dt-preview').attr('src', '');
        $modal.find('.dt-preview-wrap').hide();
        $modal.find('.dt-file-input').val('');
    });

    // ---- Save ----
    $(document).on('click', '.btn-dt-save[data-section="' + SK + '"]', function () {
        var id     = $modal.find('.dt-item-id').val();
        var isEdit = !!id;
        var payload = {
            _token:        csrfToken,
            section:       SK,
            title:         $modal.find('.dt-item-title').val(),
            link:          $modal.find('.dt-item-link').val(),
            description:   $modal.find('.dt-item-description').val(),
            coupon_code:   $modal.find('.dt-item-coupon').val(),
            countdown_end: $modal.find('.dt-item-countdown').val(),
            product_id:    $modal.find('.dt-item-product').val(),
            category_id:   $modal.find('.dt-item-category').val(),
            sort_order:    $modal.find('.dt-item-sort').val(),
            status:        $modal.find('.dt-item-status').val(),
            image:         $modal.find('.dt-item-image-value').val()
        };
        if (isEdit) { payload._method = 'PUT'; }
        var url = isEdit ? '{{ url('admin/homepage') }}/' + id : '{{ url('admin/homepage') }}';
        $.ajax({
            url: url, type: 'POST', data: payload,
            success: function (res) {
                if (res.status === 'success') {
                    toastr.success(res.message);
                    $modal.modal('hide');
                    if (dtTable) dtTable.ajax.reload();
                } else { toastr.error(res.message || 'Error.'); }
            },
            error: function () { toastr.error('Server error.'); }
        });
    });

    // ---- Edit ----
    $(document).on('click', '#dt-' + SK + ' .btn-edit-item', function () {
        var id = $(this).data('id');
        $.get('{{ url('admin/homepage') }}/' + id, function (item) {
            $modal.find('.dt-item-id').val(item.id);
            $modal.find('.dt-item-title').val(item.title);
            $modal.find('.dt-item-link').val(item.link);
            $modal.find('.dt-item-description').val(item.description);
            $modal.find('.dt-item-coupon').val(item.coupon_code);
            if (item.countdown_end) { $modal.find('.dt-item-countdown').val(item.countdown_end.substring(0, 16)); }
            if ($.fn.select2) { $modal.find('.select2').select2({ dropdownParent: $modal, width: '100%' }); }
            $modal.find('.dt-item-product').val(item.product_id).trigger('change');
            $modal.find('.dt-item-category').val(item.category_id).trigger('change');
            $modal.find('.dt-item-sort').val(item.sort_order);
            $modal.find('.dt-item-status').val(item.status);
            if (item.image) {
                $modal.find('.dt-item-image-value').val(item.image);
                $modal.find('.dt-preview').attr('src', '{{ asset('product/thumbnail/') }}/' + item.image);
                $modal.find('.dt-preview-wrap').show();
            }
            $modal.find('#modal-' + SK + '-title').text('Edit Item');
            $modal.modal('show');
        });
    });

    // ---- Delete ----
    $(document).on('click', '#dt-' + SK + ' .btn-delete-item', function () {
        var id = $(this).data('id');
        if (!confirm('Delete this item? This cannot be undone.')) return;
        $.ajax({
            url: '{{ url('admin/homepage') }}/' + id,
            type: 'POST',
            data: { _token: csrfToken, _method: 'DELETE' },
            success: function (res) {
                if (res.status === 'success') {
                    toastr.success('Deleted.');
                    if (dtTable) dtTable.ajax.reload();
                } else { toastr.error(res.message || 'Failed.'); }
            }
        });
    });

    // ---- Toggle status ----
    $(document).on('click', '#dt-' + SK + ' .btn-toggle-status', function () {
        var id     = $(this).data('id');
        var status = $(this).data('status');
        $.post('{{ url('admin/homepage/status') }}', { _token: csrfToken, id: id, status: status }, function (res) {
            if (res.status === 'success') {
                toastr.success('Status updated.');
                if (dtTable) dtTable.ajax.reload();
            }
        });
    });

}(jQuery));
</script>
@endpush
