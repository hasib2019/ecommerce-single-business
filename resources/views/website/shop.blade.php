@extends('website.layout')
@section('content')

    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                {{-- <h4 class="section-title">All products</h4> --}}
            </header>
            <div class="row ">
                @foreach($shop as $product)
                <div class="col-lg-custom-5 col-md-4 col-6 mb-3"> 
                     <div class="card h-100 border-0 shadow-sm rounded-3 product-card" 
                          style="transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); cursor: pointer;" 
                          onmouseover="this.style.transform='translateY(-8px)'; this.classList.remove('shadow-sm'); this.classList.add('shadow-lg');" 
                          onmouseout="this.style.transform='translateY(0)'; this.classList.add('shadow-sm'); this.classList.remove('shadow-lg');"> 
                         <div class="position-relative overflow-hidden rounded-top-3"> 
                            <a href="{{ url('/product/' . $product->productSlug) }}" class="d-block bg-light"> 
                                 <img class="img-fluid w-100 lazyload" 
                                      src="{{ asset('product/thumbnail/default.jpg') }}" 
                                      data-src="{{ asset('/product/thumbnail/' . $product->productImage) }}" 
                                      alt="{{ $product->productName }}" 
                                      style="height: 220px; object-fit: cover; opacity: 0.9; filter: brightness(0.95); transition: all 0.5s ease;" 
                                      onmouseover="this.style.opacity='1'; this.style.filter='brightness(1.05)'; this.style.transform='scale(1.05)';" 
                                      onmouseout="this.style.opacity='0.9'; this.style.filter='brightness(0.95)'; this.style.transform='scale(1)';"> 
                             </a> 
                             <div class="position-absolute top-0 end-0 p-2"> 
                                 <button class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                         style="width: 35px; height: 35px; transition: all 0.2s;" title="Wishlist" 
                                         onmouseover="this.classList.add('bg-danger'); this.querySelector('i').classList.remove('text-danger'); this.querySelector('i').classList.add('text-white');" 
                                         onmouseout="this.classList.remove('bg-danger'); this.querySelector('i').classList.add('text-danger'); this.querySelector('i').classList.remove('text-white');"> 
                                     <i class="far fa-heart text-danger"></i> 
                                 </button> 
                             </div> 
                         </div> 
                         
                         <div class="card-body p-3 d-flex flex-column text-center"> 
                            <a href="{{ url('/product/' . $product->productSlug) }}" class="text-decoration-none text-dark mb-2"> 
                                 <h6 class="fw-bold text-truncate mb-0" style="font-size: 1rem; transition: color 0.2s;" 
                                     onmouseover="this.style.color='#17a2b8';" 
                                     onmouseout="this.style.color='inherit';">{{ $product->productName }}</h6> 
                             </a> 
                             
                             <div class="mb-3 text-primary fw-bold" style="font-size: 1.1rem;"> 
                                 {!! $product->htmlPrice() !!} 
                             </div> 
 
                             <button class="btn btn-outline-dark w-100 mt-auto rounded-pill fw-bold py-2" 
                                     style="transition: all 0.3s;" 
                                     onclick="addToCart({{ $product->id }})" 
                                     onmouseover="this.classList.remove('btn-outline-dark'); this.classList.add('btn-dark');" 
                                     onmouseout="this.classList.add('btn-outline-dark'); this.classList.remove('btn-dark');"> 
                                 <i class="fa fa-shopping-bag me-1"></i>  অর্ডার করুন 
                             </button> 
                         </div> 
                     </div> 
                 </div>
                @endforeach
            </div>
            <div style=" display: flex; justify-content: center; margin-top: 39px; ">
                {{ $shop->links() }}
            </div>
        </div>
    </section>

@endsection
