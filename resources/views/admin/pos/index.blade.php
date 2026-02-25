@extends('layouts.app')

@push('css')
<style>
    .pos-container {
        display: flex;
        height: calc(100vh - 120px);
        gap: 20px;
    }
    .pos-products {
        flex: 1;
        overflow-y: auto;
        padding-right: 10px;
    }
    .pos-cart {
        width: 400px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .cart-items {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
    }
    .cart-summary {
        padding: 20px;
        border-top: 1px solid #eee;
        background: #f8f9fa;
    }
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .cart-item-info {
        flex: 1;
    }
    .cart-item-qty {
        width: 100px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .qty-btn {
        padding: 2px 8px;
        border: 1px solid #ddd;
        background: #fff;
        cursor: pointer;
    }
    .category-scroll {
        display: flex;
        overflow-x: auto;
        gap: 10px;
        padding-bottom: 15px;
        scrollbar-width: none;
    }
    .category-scroll::-webkit-scrollbar {
        display: none;
    }
    .category-btn {
        white-space: nowrap;
        padding: 8px 20px;
        border-radius: 20px;
        border: 1px solid #ddd;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s;
    }
    .category-btn.active {
        background: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-3">
    <div class="pos-container">
        <!-- Products Section -->
        <div class="pos-products">
            <div class="row mb-3">
                <div class="col-md-6">
                    <input type="text" id="product_search" class="form-control" placeholder="Search by name or code (Alt+S)...">
                </div>
                <div class="col-md-6">
                    <div class="category-scroll">
                        <button class="category-btn active" data-id="">All Categories</button>
                        @foreach($categories as $category)
                            <button class="category-btn" data-id="{{ $category->id }}">{{ $category->categoryName }}</button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div id="product_grid" class="row">
                @include('admin.pos.product_list')
            </div>
        </div>

        <!-- Cart Section -->
        <div class="pos-cart">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0 font-weight-bold">Cart Items</h5>
                <button class="btn btn-sm btn-outline-danger" onclick="clearCart()">Clear</button>
            </div>
            
            <div class="cart-items" id="cart_items_container">
                <!-- Cart items will be injected here -->
                <div class="text-center mt-5 text-muted">
                    <i class="fe-shopping-cart" style="font-size: 48px; opacity: 0.2;"></i>
                    <p class="mt-2">Cart is empty</p>
                </div>
            </div>

            <div class="cart-summary">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span id="summary_subtotal">৳ 0.00</span>
                </div>
                <div class="d-flex justify-content-between mb-2 align-items-center">
                    <span>Delivery</span>
                    <input type="number" id="delivery_charge" class="form-control form-control-sm text-right" style="width: 80px;" value="0">
                </div>
                <div class="d-flex justify-content-between mb-2 align-items-center">
                    <span>Discount</span>
                    <input type="number" id="discount_amount" class="form-control form-control-sm text-right" style="width: 80px;" value="0">
                </div>
                <hr>
                <div class="d-flex justify-content-between mb-3 font-weight-bold" style="font-size: 1.2rem;">
                    <span>Total</span>
                    <span id="summary_total" class="text-primary">৳ 0.00</span>
                </div>
                <button class="btn btn-primary btn-block py-2" data-toggle="modal" data-target="#checkoutModal">
                    <i class="fe-check-circle mr-1"></i> Checkout
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Complete Order</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="pos_order_form">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Customer Information</h6>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" id="cust_phone" class="form-control" placeholder="01xxxxxxxxx" required>
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" id="cust_name" class="form-control" placeholder="Customer Name" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea id="cust_address" class="form-control" rows="2" placeholder="Full Address"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment & Logistics</h6>
                            <div class="form-group">
                                <label>Store</label>
                                <select id="pos_store_id" class="form-control" required>
                                    @foreach($stores as $store)
                                        <option value="{{ $store->id }}">{{ $store->storeName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Payment Method</label>
                                <select id="pos_payment_type_id" class="form-control" required>
                                    @foreach($paymentTypes as $pt)
                                        <option value="{{ $pt->id }}">{{ $pt->paymentTypeName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Courier</label>
                                <select id="pos_courier_id" class="form-control">
                                    <option value="">Select Courier</option>
                                    @foreach($couriers as $courier)
                                        <option value="{{ $courier->id }}">{{ $courier->courierName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Paid Amount</label>
                                <input type="number" id="pos_payment_amount" class="form-control" value="0">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary px-4" id="confirm_order">Place Order</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    let cart = [];
    let currentCategory = '';
    let searchQuery = '';

    $(document).ready(function() {
        // Search Handling
        $('#product_search').on('keyup', function() {
            searchQuery = $(this).val();
            fetchProducts();
        });

        // Category Handling
        $('.category-btn').on('click', function() {
            $('.category-btn').removeClass('active');
            $(this).addClass('active');
            currentCategory = $(this).data('id');
            fetchProducts();
        });

        // Add to Cart
        $(document).on('click', '.product-card', function() {
            const product = {
                id: $(this).data('id'),
                name: $(this).data('name'),
                price: parseFloat($(this).data('price')),
                code: $(this).data('code'),
                quantity: 1
            };
            addToCart(product);
        });

        // Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchProducts(page);
        });

        // Input Changes
        $('#delivery_charge, #discount_amount').on('input', updateSummary);

        // Confirm Order
        $('#confirm_order').on('click', function() {
            submitOrder();
        });
    });

    function fetchProducts(page = 1) {
        $.ajax({
            url: "{{ route('admin.pos.search') }}",
            data: {
                query: searchQuery,
                category_id: currentCategory,
                page: page
            },
            success: function(html) {
                $('#product_grid').html(html);
            }
        });
    }

    function addToCart(product) {
        const index = cart.findIndex(item => item.id === product.id);
        if (index > -1) {
            cart[index].quantity++;
        } else {
            cart.push(product);
        }
        renderCart();
    }

    function updateQty(id, delta) {
        const index = cart.findIndex(item => item.id === id);
        if (index > -1) {
            cart[index].quantity += delta;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
        }
        renderCart();
    }

    function removeFromCart(id) {
        cart = cart.filter(item => item.id !== id);
        renderCart();
    }

    function clearCart() {
        cart = [];
        renderCart();
    }

    function renderCart() {
        const container = $('#cart_items_container');
        if (cart.length === 0) {
            container.html(`
                <div class="text-center mt-5 text-muted">
                    <i class="fe-shopping-cart" style="font-size: 48px; opacity: 0.2;"></i>
                    <p class="mt-2">Cart is empty</p>
                </div>
            `);
            updateSummary();
            return;
        }

        let html = '';
        cart.forEach(item => {
            html += `
                <div class="cart-item">
                    <div class="cart-item-info">
                        <div class="font-weight-bold text-truncate" style="max-width: 180px;">${item.name}</div>
                        <small class="text-muted">৳ ${item.price}</small>
                    </div>
                    <div class="cart-item-qty">
                        <button class="qty-btn" onclick="updateQty(${item.id}, -1)">-</button>
                        <input type="text" class="form-control form-control-sm text-center px-1" value="${item.quantity}" readonly style="width: 35px; border: none; background: transparent;">
                        <button class="qty-btn" onclick="updateQty(${item.id}, 1)">+</button>
                    </div>
                    <div class="text-right ml-2" style="width: 70px;">
                        ৳ ${(item.price * item.quantity).toFixed(2)}
                        <i class="fe-trash-2 text-danger ml-2" style="cursor: pointer;" onclick="removeFromCart(${item.id})"></i>
                    </div>
                </div>
            `;
        });
        container.html(html);
        updateSummary();
    }

    function updateSummary() {
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.price * item.quantity;
        });

        const delivery = parseFloat($('#delivery_charge').val()) || 0;
        const discount = parseFloat($('#discount_amount').val()) || 0;
        const total = subtotal + delivery - discount;

        $('#summary_subtotal').text(`৳ ${subtotal.toFixed(2)}`);
        $('#summary_total').text(`৳ ${total.toFixed(2)}`);
        $('#pos_payment_amount').val(total.toFixed(2));
    }

    function submitOrder() {
        if (cart.length === 0) {
            Swal.fire('Error', 'Cart is empty', 'error');
            return;
        }

        const data = {
            _token: "{{ csrf_token() }}",
            items: cart,
            subtotal: cart.reduce((acc, item) => acc + (item.price * item.quantity), 0),
            delivery_charge: $('#delivery_charge').val(),
            discount: $('#discount_amount').val(),
            customer_name: $('#cust_name').val(),
            customer_phone: $('#cust_phone').val(),
            customer_address: $('#cust_address').val(),
            store_id: $('#pos_store_id').val(),
            payment_type_id: $('#pos_payment_type_id').val(),
            courier_id: $('#pos_courier_id').val(),
            payment_amount: $('#pos_payment_amount').val()
        };

        if (!data.customer_name || !data.customer_phone) {
            Swal.fire('Error', 'Customer name and phone are required', 'error');
            return;
        }

        $('#confirm_order').attr('disabled', true).text('Processing...');

        $.ajax({
            url: "{{ route('admin.pos.store') }}",
            method: "POST",
            data: data,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire('Success', 'Order placed successfully!', 'success').then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                    $('#confirm_order').attr('disabled', false).text('Place Order');
                }
            },
            error: function(xhr) {
                Swal.fire('Error', 'Something went wrong', 'error');
                $('#confirm_order').attr('disabled', false).text('Place Order');
            }
        });
    }
</script>
@endpush
