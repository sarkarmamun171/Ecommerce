@extends('frontend.master')

@section('content')

        <!-- start wpo-page-title -->
        <section class="wpo-page-title">
            <h2 class="d-none">Hide</h2>
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="wpo-breadcumb-wrap">
                            <ol class="wpo-breadcumb-wrap">
                                <li><a href="index.html">Home</a></li>
                                <li>{{ $subcategories->subcategory_name }}</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- start of themart-interestproduct-section -->
        <section class="themart-interestproduct-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="wpo-section-title">
                            <h2>{{ $subcategories->subcategory_name }}</h2>
                        </div>
                    </div>
                </div>
                <div class="product-wrap">
                    <div class="row">
                        @forelse ($subcategory_products as $subcategory_products)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="product-item">
                                <div class="image">
                                    <img height="250" src="{{asset('uploads/product/preview')}}/{{ $subcategory_products->preview }}" alt="">
                                    <div class="tag new">New</div>
                                </div>
                                <div class="text">
                                    <h2>
                                        <a href="{{ route('product.details', $subcategory_products->slug) }}" title="{{ $subcategory_products->product_name }}">
                                            @if (strlen($subcategory_products->product_name) > 40)
                                                {{Str::substr($subcategory_products->product_name, 0, 40).'...'}}
                                            @else
                                                {{$subcategory_products->product_name}}
                                            @endif
                                         </a>
                                    </h2>

                                    <div class="rating-product">
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <i class="fi flaticon-star"></i>
                                        <span>130</span>
                                    </div>
                                    <div class="price">
                                        <span class="present-price">&#2547;{{ number_format($subcategory_products->after_discount )}}</span>
                                        @if ($subcategory_products->discount)
                                           <del class="old-price">&#2547;{{ number_format($subcategory_products->price )}}</del>
                                        @endif
                                    </div>
                                    <div class="shop-btn">
                                        <a class="theme-btn-s2" href="product.html">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                            <div class="alert alert-info">
                                <h3>No Products Found</h3>
                            </div>
                        @endforelse
                        <div class="more-btn">
                            <a class="theme-btn-s2" href="product.html">Load More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end of themart-interestproduct-section -->
@endsection
