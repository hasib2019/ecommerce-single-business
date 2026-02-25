@foreach($products as $product)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
        <div class="card product-card h-100" data-id="{{ $product->id }}" data-name="{{ $product->productName }}" data-price="{{ $product->productSalePrice > 0 ? $product->productSalePrice : $product->productRegularPrice }}" data-code="{{ $product->productCode }}" style="cursor: pointer; transition: transform 0.2s;">
            <div class="product-img-wrapper" style="width: 100%; height: 120px; overflow: hidden; background: #f8f9fa;">
                @if($product->productImage && file_exists(public_path('product/thumbnail/' . $product->productImage)))
                    <img src="{{ asset('product/thumbnail/' . $product->productImage) }}" class="card-img-top" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;" alt="{{ $product->productName }}">
                @else
                    <img src="https://via.placeholder.com/150?text=No+Image" class="card-img-top" style="width: 100%; height: 100%; object-fit: contain; padding: 5px;" alt="{{ $product->productName }}">
                @endif
            </div>
            <div class="card-body p-2 text-center">
                <h6 class="card-title text-truncate mb-1" style="font-size: 13px;">{{ $product->productName }}</h6>
                <p class="card-text fw-bold text-primary mb-0">৳ {{ $product->productSalePrice > 0 ? $product->productSalePrice : $product->productRegularPrice }}</p>
                <small class="text-muted">{{ $product->productCode }}</small>
            </div>
        </div>
    </div>
@endforeach

<div class="col-12 mt-3 d-flex justify-content-center">
    {{ $products->links('pagination::bootstrap-4') }}
</div>
