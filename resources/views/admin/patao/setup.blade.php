@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-xl-12">
    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h4 class="header-title mb-0">Patao Sandbox/Test Setup</h4>
        <button id="patao-check-btn" type="button" class="btn {{ (!empty($data['access_token']) && !empty($data['refresh_token'])) ? 'btn-success' : 'btn-danger' }}">Check Connection & Sync Token</button>
      </div>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <form method="post" action="{{ route('admin.patao.setup.save') }}">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="base_url">Base URL</label>
              <input type="text" class="form-control" id="base_url" name="base_url" value="{{ old('base_url', $data['base_url']) }}" placeholder="https://sandbox.example.com/api">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="client_id">Client ID</label>
              <input type="text" class="form-control" id="client_id" name="client_id" value="{{ old('client_id', $data['client_id']) }}" placeholder="client-id">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="client_secret">Client Secret</label>
              <input type="text" class="form-control" id="client_secret" name="client_secret" value="{{ old('client_secret', $data['client_secret']) }}" placeholder="client-secret">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $data['username']) }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="password">Password</label>
              <input type="text" class="form-control" id="password" name="password" value="{{ old('password', $data['password']) }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="grant_type">Grant Type</label>
              <input type="text" class="form-control" id="grant_type" name="grant_type" value="{{ old('grant_type', $data['grant_type']) }}" placeholder="client_credentials">
            </div>
          </div>
        </div>

        <!-- Token Information Section -->
        <div class="row mt-4">
          <div class="col-12">
            <h5 class="text-muted mb-3">Token Information</h5>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="access_token">Access Token</label>
              <div class="input-group">
                <input type="password" class="form-control" id="access_token" readonly 
                       value="{{ !empty($data['access_token']) ? substr($data['access_token'], 0, 20) . '...' : 'Not available' }}"
                       data-full-value="{{ $data['access_token'] ?? '' }}">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary toggle-visibility" type="button" data-target="access_token">
                    <i class="fa fa-eye"></i>
                  </button>
                  <button class="btn btn-outline-secondary copy-token" type="button" data-target="access_token" 
                          {{ empty($data['access_token']) ? 'disabled' : '' }}>
                    <i class="fa fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="refresh_token">Refresh Token</label>
              <div class="input-group">
                <input type="password" class="form-control" id="refresh_token" readonly 
                       value="{{ !empty($data['refresh_token']) ? substr($data['refresh_token'], 0, 20) . '...' : 'Not available' }}"
                       data-full-value="{{ $data['refresh_token'] ?? '' }}">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary toggle-visibility" type="button" data-target="refresh_token">
                    <i class="fa fa-eye"></i>
                  </button>
                  <button class="btn btn-outline-secondary copy-token" type="button" data-target="refresh_token"
                          {{ empty($data['refresh_token']) ? 'disabled' : '' }}>
                    <i class="fa fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="expires_in">Expires In (seconds)</label>
              <div class="input-group">
                <input type="text" class="form-control" id="expires_in" readonly 
                       value="{{ $data['expires_in'] ?? 'Not available' }}">
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary copy-token" type="button" data-target="expires_in"
                          {{ empty($data['expires_in']) ? 'disabled' : '' }}>
                    <i class="fa fa-copy"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-right">
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@push('js')
<script>
$(function(){
  var isChecking = false;
  $(document).on('click', '#patao-check-btn', function(e){
    console.log('work')
    e.preventDefault();
    if (isChecking) return;
    isChecking = true;
    var $btn = $(this);
    var originalText = $btn.text();
    $btn.text('Checking...');
    $.ajax({
      url: "{{ route('admin.patao.check') }}",
      method: "POST",
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function(resp) {
        console.log('work', resp);
        if (resp && resp.ok) {
          $btn.removeClass('btn-danger').addClass('btn-success').text('Connected & Synced');
        } else {
          $btn.removeClass('btn-success').addClass('btn-danger').text('Connection Failed');
        }
      },
      error: function(xhr) {
        $btn.removeClass('btn-success').addClass('btn-danger').text('Connection Failed');
      },
      complete: function() {
        setTimeout(function(){
          $btn.text(originalText);
          isChecking = false;
        }, 1200);
      }
    });
  });

  // Toggle visibility for token fields
  $(document).on('click', '.toggle-visibility', function(e){
    e.preventDefault();
    var target = $(this).data('target');
    var $input = $('#' + target);
    var $icon = $(this).find('i');
    
    if ($input.attr('type') === 'password') {
      // Show full token
      $input.attr('type', 'text').val($input.data('full-value'));
      $icon.removeClass('fa-eye').addClass('fa-eye-slash');
    } else {
      // Hide token (show truncated version)
      $input.attr('type', 'password');
      var fullValue = $input.data('full-value');
      if (fullValue && fullValue.length > 20) {
        $input.val(fullValue.substr(0, 20) + '...');
      } else if (fullValue) {
        $input.val(fullValue);
      } else {
        $input.val('Not available');
      }
      $icon.removeClass('fa-eye-slash').addClass('fa-eye');
    }
  });

  // Copy to clipboard functionality
  $(document).on('click', '.copy-token', function(e){
    e.preventDefault();
    var target = $(this).data('target');
    var $input = $('#' + target);
    var valueToCopy = $input.data('full-value') || $input.val();
    
    if (!valueToCopy || valueToCopy === 'Not available') {
      alert('No token available to copy');
      return;
    }

    // Create temporary textarea to copy text
    var $temp = $('<textarea>');
    $('body').append($temp);
    $temp.val(valueToCopy).select();
    
    try {
      document.execCommand('copy');
      // Change icon temporarily to show success
      var $icon = $(this).find('i');
      var originalClass = $icon.attr('class');
      $icon.removeClass().addClass('fa fa-check text-success');
      
      setTimeout(function(){
        $icon.removeClass().addClass(originalClass);
      }, 1000);
    } catch (err) {
      alert('Failed to copy to clipboard');
    }
    
    $temp.remove();
  });
});
</script>
@endpush