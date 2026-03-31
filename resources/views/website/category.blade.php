@extends('website.layout')
@section('content')

    <section class="section-name bg padding-y-sm">
        <div class="container">
            <header class="section-heading">
                <h4 class="section-title">{{ $category ? $category->categoryName : 'Category Not Found' }}</h4>
            </header>
            
            @if($category && $categoryProducts->count() > 0)
                <div class="row no-gutters">
                    @foreach($categoryProducts as $product)
                        <div class="col-md-2 col-6">
                            <div href="#" class="card card-product-grid product-box-2">
                                <a href="{{ url('/product/'.$product->productSlug)  }}" class="img-wrap">
                                    <img class="img-fit lazyload"   src="{{ url('product/thumbnail/default.jpg') }}"  data-src="{{ url('/product/thumbnail/'.$product->productImage)  }}" alt="{{ $product->productName  }}">
                                </a>
                                <figcaption class="info-wrap">
                                    <a href="{{ url('/product/'.$product->productSlug)  }}" class="title text-truncate">{{ $product->productName  }}</a>
                                    <div class="price mt-1 text-center">
                                        {!! $product->htmlPrice() !!}
                                    </div>
                                </figcaption>
                                <button class="btn btn-success btn-sm btn-block" onclick="addToCart({{ $product->id }})">
                                    <i class="fa fa-shopping-cart"  aria-hidden="true"></i> অর্ডার করুন
                                </button>
                            </div>
                        </div> <!-- col.// -->
                    @endforeach
                </div>
                <div style=" display: flex; justify-content: center; margin-top: 39px; ">
                    {{ $categoryProducts->links() }}
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fa fa-search fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">{{ $category ? 'No Products Found' : 'Category Not Found' }}</h4>
                            <p class="text-muted">
                                @if($category)
                                    Sorry, no products are available in this category at the moment.
                                @else
                                    The category you are looking for does not exist.
                                @endif
                            </p>
                            <a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="fa fa-home"></i> Go to Homepage
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
