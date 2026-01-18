@extends('website.layout')

@section('content')
<section class="section-content padding-y bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-4 pt-4">
                    <h2 class="text-uppercase fw-bold">Track Your Order</h2>
                    <p class="text-muted mb-0">Enter your Invoice ID to see your order status.</p>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('tracking.track') }}" method="POST" class="row g-3 align-items-center">
                            @csrf
                            <div class="col-md-9">
                                <input type="text" name="invoice_id" value="{{ old('invoice_id', isset($invoiceId) ? $invoiceId : '') }}" class="form-control form-control-lg" placeholder="Enter Invoice ID">
                            </div>
                            <div class="col-md-3 mt-3 mt-md-0">
                                <button type="submit" class="btn btn-dark w-100 btn-lg">Track Order</button>
                            </div>
                        </form>
                        @if ($errors->has('invoice_id'))
                            <div class="text-danger mt-2">{{ $errors->first('invoice_id') }}</div>
                        @endif
                        @if (session('error'))
                            <div class="text-danger mt-2">{{ session('error') }}</div>
                        @endif
                    </div>
                </div>

                @isset($order)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-1">Invoice ID: <span class="fw-bold">{{ $order->invoiceID }}</span></h5>
                                    <p class="mb-0 text-muted">Order Date: {{ $order->orderDate }}</p>
                                </div>
                                <div>
                                    @php
                                        $status = $order->status ?? 'Processing';
                                        $badgeClass = 'badge-secondary';
                                        if (in_array($status, ['Delivered', 'Paid', 'Completed'])) {
                                            $badgeClass = 'badge-success';
                                        } elseif (in_array($status, ['Return', 'Lost', 'Canceled'])) {
                                            $badgeClass = 'badge-danger';
                                        } elseif (in_array($status, ['Customer Confirm', 'Customer On Hold', 'Pending Invoiced', 'Invoiced', 'Processing', 'Pending Payment'])) {
                                            $badgeClass = 'badge-warning';
                                        }
                                    @endphp
                                    <span class="badge {{ $badgeClass }} px-3 py-2" style="font-size: 0.9rem;">{{ $status }}</span>
                                </div>
                            </div>

                            @if ($order->deliveryDate || $order->completeDate)
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span class="text-muted">Order Timeline</span>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        @php
                                            $steps = 3;
                                            $current = 1;
                                            if ($order->deliveryDate) {
                                                $current = 2;
                                            }
                                            if ($order->completeDate) {
                                                $current = 3;
                                            }
                                            $percent = ($current / $steps) * 100;
                                        @endphp
                                        <div class="progress-bar bg-dark" role="progressbar" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2 small text-muted">
                                        <span>Placed</span>
                                        <span>Out for Delivery</span>
                                        <span>Completed</span>
                                    </div>
                                </div>
                            @endif

                            @if(isset($customer))
                                <div class="mb-4">
                                    <h6 class="fw-bold mb-2">Shipping Details</h6>
                                    <p class="mb-0">{{ $customer->customerName }}</p>
                                    <p class="mb-0">{{ $customer->customerPhone }}</p>
                                    <p class="mb-0 text-muted">{{ $customer->customerAddress }}</p>
                                </div>
                            @endif

                            <div>
                                <h6 class="fw-bold mb-3">Products</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $item)
                                                <tr>
                                                    <td>{{ $item->productName }}</td>
                                                    <td class="text-center">{{ $item->quantity }}</td>
                                                    <td class="text-right">৳ {{ number_format($item->productPrice) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-between border-top pt-3 mt-2">
                                    <span class="fw-bold">Subtotal</span>
                                    <span class="fw-bold">৳ {{ number_format($order->subTotal) }}</span>
                                </div>
                                <div class="d-flex justify-content-between pt-1">
                                    <span class="text-muted">Delivery Charge</span>
                                    <span class="text-muted">৳ {{ number_format($order->deliveryCharge) }}</span>
                                </div>
                                @if($order->discountCharge)
                                    <div class="d-flex justify-content-between pt-1">
                                        <span class="text-muted">Discount</span>
                                        <span class="text-muted">- ৳ {{ number_format($order->discountCharge) }}</span>
                                    </div>
                                @endif
                                <div class="d-flex justify-content-between border-top pt-3 mt-2">
                                    <span class="fw-bold">Total</span>
                                    <span class="fw-bold">৳ {{ number_format($order->paymentAmount ?? ($order->subTotal + $order->deliveryCharge - ($order->discountCharge ?? 0))) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>
</section>
@endsection

