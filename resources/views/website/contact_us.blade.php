@extends('website.layout')

@section('content')
<section class="section-content padding-y bg-light">
    <div class="container">
        <div class="text-center mb-5 pt-4">
            <h2 class="text-uppercase fw-bold">CONTACT US</h2>
            <p class="text-muted">Have a question or remark? Feel free to contact us!</p>
        </div>

        <div class="row mb-5">
            <!-- Email -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-black text-white rounded p-3 me-3">
                            <i class="fa fa-envelope fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 fw-bold">Email</h5>
                            <p class="card-text text-muted">support@email.com.bd</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Whatsapp -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-black text-white rounded p-3 me-3">
                            <i class="fab fa-whatsapp fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 fw-bold">Whatsapp</h5>
                            <p class="card-text text-muted">01767099211</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Find Us -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm p-3">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-box bg-black text-white rounded p-3 me-3">
                            <i class="fa fa-map-marker-alt fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1 fw-bold">Find Us</h5>
                            <p class="card-text text-muted mb-0 fw-bold">Office Address :-</p>
                            <small class="text-muted">Newmarket , Dhaka -1205</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center pb-5">
            <div class="col-lg-10">
                <div class="bg-white p-5 shadow-sm rounded">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="phone" class="form-label fw-bold">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="subject" class="form-label fw-bold">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Subject" required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="message" class="form-label fw-bold">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-black px-5 py-2 fw-bold">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('js')
@if(Session::has('success'))
    <script>
        $(document).ready(function() {
            showFrontendAlert('success', '{{ Session::get('success') }}');
        });
    </script>
@endif
@endpush

<style>
    .bg-black {
        background-color: #000 !important;
    }
    .btn-black {
        background-color: #000;
        color: #fff;
        border-radius: 4px;
        transition: all 0.3s;
    }
    .btn-black:hover {
        background-color: #333;
        color: #fff;
        transform: translateY(-2px);
    }
    .icon-box {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    .form-control {
        border-radius: 4px;
        padding: 12px 15px;
        border: 1px solid #ddd;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #000;
    }
    .form-label {
        font-size: 14px;
    }
</style>
@endsection
