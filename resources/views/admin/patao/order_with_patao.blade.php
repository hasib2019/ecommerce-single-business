@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-xl-12">
    <div class="card-box">
      <h4 class="header-title mb-4">Order with Patao - Processing Orders</h4>
      <div class="table-responsive">
        <table class="table table-centered table-striped" id="pataoOrderTable" style="width: 100%;" data-status="Processing">
          <thead>
            <tr>
              <th></th>
              <th>Invoice ID</th>
              <th>Name</th>
              <th>Products</th>
              <th>Total</th>
              <th>Courier</th>
              <th>Order Date</th>
              <th>Status</th>
              <th>Notes</th>
              <th>User</th>
              <th class="hidden-sm">Action</th>
            </tr>
          </thead>
          <tbody></tbody>
          <tfoot>
            <tr>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
$(function(){
  // Ensure CSRF token is sent with AJAX POSTs (meta and cookie)
  var metaToken = $('meta[name="csrf-token"]').attr('content') || null;
  var xsrfCookie = (function(){
    var m = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : null;
  })();
  var csrfHeaders = {};
  if (metaToken) csrfHeaders['X-CSRF-TOKEN'] = metaToken; // matches csrf_token()
  if (xsrfCookie) csrfHeaders['X-XSRF-TOKEN'] = xsrfCookie; // matches XSRF-TOKEN cookie
  if (Object.keys(csrfHeaders).length) {
    $.ajaxSetup({ headers: csrfHeaders });
  }
  var status = 'Processing';
  var table = $("#pataoOrderTable").DataTable({
    ajax: {
      url: "{{ url('admin/order/show') }}?status=" + status,
    },
    ordering: false,
    processing: true,
    serverSide: true,
    pageLength: 50,
    rowId: "id",
    columnDefs: [
      { targets: 0, checkboxes: { selectRow: true } }
    ],
    columns: [
      { data: 'id', searchable: false },
      { data: 'invoice', searchable: false },
      { data: 'customerInfo', width: "15%", searchable: false },
      { data: 'products', width: "15%", searchable: false },
      { data: 'subTotal', searchable: false },
      { data: 'courierName', width: "10%", searchable: false },
      { data: 'orderDate', width: "10%", searchable: false },
      { data: 'statusButton', width: "10%", searchable: false, render: function(data, type, row){
         var btn = '<button type="button" class="btn btn-primary btn-xs btn-send-patao" data-order-id="'+row.id+'"><i class="fas fa-paper-plane mr-1"></i> Send with Patao</button>';
         return btn;
       } },
      { data: 'notification', width: "15%", searchable: false },
      { data: 'name', searchable: false },
      { data: 'action', searchable: false }
    ]
  });

  // Prefetch Patao stores once on page load for all forms
  window.pataoStores = window.pataoStores || null;
  window.pataoStoresFetched = window.pataoStoresFetched || false;
  function extractPataoStores(res){
    var list = [];
    if (res && res.ok && res.data) {
      var d = res.data.data;
      if (Array.isArray(d)) {
        list = d;
      } else if (d && Array.isArray(d.data)) {
        list = d.data;
      } else if (d && d.data && !Array.isArray(d.data) && typeof d.data === 'object') {
        list = [d.data];
      } else if (Array.isArray(res.data.data)) {
        list = res.data.data;
      } else if (res.data.data && typeof res.data.data === 'object') {
        list = [res.data.data];
      } else if (d && Array.isArray(d.items)) {
        list = d.items;
      } else if (d && d.items && typeof d.items === 'object') {
        list = [d.items];
      }
    }
    return list;
  }
  function filterActiveStores(list){
    return Array.isArray(list) ? list.filter(function(st){
      return st && (st.is_active === true || st.is_active === 1 || st.is_active === '1');
    }) : [];
  }
  function prefetchPataoStores(){
    if (window.pataoStoresFetched) return;
    $.get("{{ url('admin/patao/stores') }}", function(res){
      var list = extractPataoStores(res);
      var active = filterActiveStores(list);
      window.pataoStores = active;
      window.pataoStoresFetched = true;
    });
  }
  prefetchPataoStores();


  $(document).on('click', '.btn-send-patao', function (e) {
    e.preventDefault();
    var $tr = $(this).closest('tr');
    var rowData = table.row($tr).data() || {};

    function stripHtmlWithBreaks(html){
      var text = (html || '').replace(/<br\s*\/?\s*>/gi, '\n').replace(/<[^>]+>/g, '');
      return text;
    }

    var invoiceText = stripHtmlWithBreaks(rowData.invoice);
    var invoiceParts = invoiceText.split('\n');
    var merchantOrderId = (invoiceParts[0] || '').trim();

    var customerText = stripHtmlWithBreaks(rowData.customerInfo);
    var customerParts = customerText.split('\n');
    var recipientName = (customerParts[0] || '').trim();
    var recipientPhone = (customerParts[1] || '').trim();
    var recipientAddress = (customerParts.slice(2).join(' ') || '').trim();

    var amountToCollect = (rowData.subTotal || '').toString().replace(/[^0-9.]/g, '');
    var itemDescription = 'this is a Cloth item, price- ' + (amountToCollect || '');

    function buildStoreOptionsHtml(list){
      var filtered = filterActiveStores(list);
      if (!Array.isArray(filtered) || filtered.length === 0) {
        return '<option value="">No active stores found</option>';
      }
      var defaultFound = false;
      var options = filtered.map(function(st){
        var id = st.store_id || st.id || '';
        var name = st.store_name || st.name || 'Unnamed';
        var addr = st.store_address || '';
        var isDefault = (st.is_default_store === true || st.is_default_store === 1 || st.is_default_store === '1');
        var selectedAttr = '';
        if (isDefault && !defaultFound) {
          selectedAttr = ' selected';
          defaultFound = true;
        }
        return '<option value="' + id + '"' + selectedAttr + '>' + name + (addr ? ' — ' + addr : '') + '</option>';
      }).join('');
      var placeholder = defaultFound ? '<option value="" disabled>Select Store</option>' : '<option value="" disabled selected>Select Store</option>';
      return placeholder + options;
    }
    var formHtml = ''
      + '<div class="text-left">'
      + '  <div class="form-group">'
      + '    <label>Store</label>'
      + '    <select id="patao-store" class="form-control">' + (window.pataoStoresFetched ? buildStoreOptionsHtml(window.pataoStores) : '<option value="">Loading stores...</option>') + '</select>'
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Merchant Order ID (Invoice No)</label>'
      + '    <input type="text" id="patao-merchant-order-id" class="form-control" value="' + merchantOrderId + '">' 
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Recipient Name</label>'
      + '    <input type="text" id="patao-recipient-name" class="form-control" value="' + recipientName + '">' 
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Recipient Phone</label>'
      + '    <input type="text" id="patao-recipient-phone" class="form-control" value="' + recipientPhone + '">' 
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Recipient Address</label>'
      + '    <textarea id="patao-recipient-address" class="form-control" rows="2">' + recipientAddress + '</textarea>'
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Delivery Type</label>'
      + '    <select id="patao-delivery-type" class="form-control">'
      + '      <option value="48">Express</option>'
      + '      <option value="49">Normal</option>'
      + '      <option value="50">Gold</option>'
      + '    </select>'
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Item Type</label>'
      + '    <select id="patao-item-type" class="form-control">'
      + '      <option value="2" selected>Parcel</option>'
      + '      <option value="1">Document</option>'
      + '    </select>'
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Special Instruction</label>'
      + '    <input type="text" id="patao-special-instruction" class="form-control" placeholder="Need to Delivery before 5 PM">'
      + '  </div>'
      + '  <div class="form-row">'
      + '    <div class="form-group col-6">'
      + '      <label>Item Quantity</label>'
      + '      <input type="number" id="patao-item-quantity" class="form-control" min="1" value="1">'
      + '    </div>'
      + '    <div class="form-group col-6">'
      + '      <label>Item Weight (kg)</label>'
      + '      <input type="text" id="patao-item-weight" class="form-control" value="0.5">'
      + '    </div>'
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Item Description</label>'
      + '    <textarea id="patao-item-description" class="form-control" rows="2">' + itemDescription + '</textarea>'
      + '  </div>'
      + '  <div class="form-group">'
      + '    <label>Amount to Collect</label>'
      + '    <input type="number" id="patao-amount-to-collect" class="form-control" value="' + (amountToCollect || '') + '">' 
      + '  </div>'
      + '</div>';

    Swal.fire({
      title: 'Send with Patao',
      html: formHtml,
      showCancelButton: true,
      confirmButtonText: 'Send',
      cancelButtonText: 'Cancel',
      focusConfirm: false,
      didOpen: () => {
        var $s = $('#patao-store');
        function render(list){
          var filtered = filterActiveStores(list);
          $s.empty();
          if (Array.isArray(filtered) && filtered.length) {
            $s.html(buildStoreOptionsHtml(filtered));
          } else {
            $s.append('<option value="">No active stores found</option>');
          }
        }
        if (window.pataoStoresFetched) {
          render(window.pataoStores);
        } else {
          $s.empty().append('<option value="">Loading stores...</option>');
          var tries = 0;
          var timer = setInterval(function(){
            if (window.pataoStoresFetched) {
              clearInterval(timer);
              render(window.pataoStores);
            } else if (++tries >= 20) { // wait a bit longer (~6s)
              clearInterval(timer);
              $s.empty().append('<option value="">No active stores found</option>');
            }
          }, 300);
        }
      },
      preConfirm: () => {
        var storeId = $('#patao-store').val();
        var payload = {
          order_id: rowData.id || $(this).data('order-id'),
          store_id: storeId,
          merchant_order_id: $('#patao-merchant-order-id').val(),
          recipient_name: $('#patao-recipient-name').val(),
          recipient_phone: $('#patao-recipient-phone').val(),
          recipient_address: $('#patao-recipient-address').val(),
          delivery_type: parseInt($('#patao-delivery-type').val() || '48', 10),
          item_type: parseInt($('#patao-item-type').val() || '2', 10),
          special_instruction: $('#patao-special-instruction').val(),
          item_quantity: parseInt($('#patao-item-quantity').val() || '1', 10),
          item_weight: $('#patao-item-weight').val(),
          item_description: $('#patao-item-description').val(),
          amount_to_collect: parseFloat($('#patao-amount-to-collect').val() || '0'),
          _token: $('meta[name="csrf-token"]').attr('content') || undefined
        };
        if (!payload.store_id) {
          Swal.showValidationMessage('Please select a Store');
          return false;
        }
        if (!payload.recipient_name || !payload.recipient_phone || !payload.recipient_address) {
          Swal.showValidationMessage('Recipient name, phone and address are required');
          return false;
        }
        if (!payload.merchant_order_id) {
          Swal.showValidationMessage('Merchant Order ID (invoice no) is required');
          return false;
        }
        return new Promise(function(resolve, reject){
          $.ajax({
            url: "{{ url('admin/patao/orders') }}",
            method: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json; charset=UTF-8',
            headers: $.ajaxSettings.headers || {},
            success: function(res){
              if (res && res.ok) {
                resolve(res);
              } else {
                reject(res && res.message ? res.message : 'Order creation failed');
              }
            },
            error: function(xhr){
              var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : (xhr.responseText || 'Request failed');
              reject(msg);
            }
          });
        });
      }
    }).then((result) => {
      if (result.isConfirmed) {
        var resp = result.value || {};
        var data = resp.data || {};
        Swal.fire('Sent', 'Order created successfully', 'success');
      }
    });
  });
});
</script>
@endpush