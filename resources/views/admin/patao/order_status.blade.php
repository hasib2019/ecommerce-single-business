@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-xl-12">
    <div class="card-box">
      <h4 class="header-title mb-4">Order Status — {{ $status ?? 'Pending' }}</h4>
      <div class="table-responsive">
        <table class="table table-centered table-striped" id="pataoOrderTable" style="width: 100%;" data-status="{{ $status ?? 'Pending' }}">
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
  $.fn.dataTable.ext.errMode = 'throw';
  var tableEl = $("#pataoOrderTable");
  var table = tableEl.DataTable({
    ajax: {
      url: "/admin/all/order-status",
      data: function(d){
        d.status = tableEl.data('status') || 'Pending';
      }
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
});
</script>
@endpush