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
                                <li><a href="product.html">Product</a></li>
                                <li>Product Details</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- product-single-section  start-->
        <div class="product-single-section section-padding">
            <div class="container">
                <div class="product-details">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="product-single-img">
                                    <div class="product-active owl-carousel">
                                        @foreach (App\Models\ProductGallery::where('product_id',$product_details->id)->get() as $gallery)
                                            <div class="item">
                                                <img src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="product-thumbnil-active  owl-carousel">
                                        @foreach (App\Models\ProductGallery::where('product_id',$product_details->id)->get() as $gallery)
                                            <div class="item">
                                                <img src="{{ asset('uploads/product/gallery') }}/{{ $gallery->gallery }}" alt="">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @php
                                $avg = 0;
                                if($reviews->count() != 0){
                                    $avg = round($total_stars/$reviews->count());
                                }
                            @endphp
                            <div class="col-lg-7">
                                <div class="product-single-content">
                                    <h2>{{ $product_details->product_name }}t</h2>
                                    <div class="price">
                                        <span class="present-price">&#2547;{{ number_format($product_details->after_discount )}}</span>
                                        @if ($product_details->discount)
                                        <del class="old-price">&#2547;{{ number_format($product_details->price )}}</del>
                                        @endif
                                    </div>
                                    <div class="rating-product">
                                        @for ($i=1; $i<=$avg; $i++)
                                            <i class="fi flaticon-star"></i>
                                        @endfor
                                        <span>{{ $reviews->count() }}</span>
                                    </div>
                                    <p>Aliquam proin at turpis sollicitudin faucibus.
                                        Non nunc molestie interdum nec sit duis vitae vestibulum id.
                                        Ipsum non donec egestas quis. A habitant tellus nibh blandit.
                                        Faucibus dictumst nibh et aliquet in auctor. Amet ultrices urna ullamcorper
                                        sagittis.
                                        Hendrerit orci ac fusce pulvinar. Diam tincidunt integer eget morbi diam scelerisque
                                        mattis.
                                    </p>
                                    <div class="product-filter-item color">
                                        <div class="color-name">
                                            <span>Color :</span>
                                            <ul class="color_avl">
                                                @foreach ($available_colors as $colors)
                                                @if ($colors->rel_to_color->color_name == 'NA')
                                                    <li class="color"><input class="color_id" id="{{ $colors->color_id }}" type="radio" name="color_id" value="{{ $colors->color_id }}">
                                                        <label style="background-color: transparent; font-size:14px; border:2px solid #000; text-align:center; line-height:30px" for="{{ $colors->color_id }}">{{ $colors->rel_to_color->color_name }}</label>
                                                    </li>
                                                @else
                                                    <li class="color"><input class="color_id" id="{{ $colors->color_id }}" type="radio" name="color_id" value="{{ $colors->color_id }}">
                                                        <label style="background-color: {{ $colors->rel_to_color->color_code }}" for="{{ $colors->color_id }}"></label>
                                                    </li>
                                                @endif
                                                @endforeach
                                            </ul>
                                            @error('size_id')
                                                <strong class="text-danger">Please Select Your Color  </strong>
                                             @enderror
                                        </div>
                                    </div>
                                    <div class="product-filter-item color filter-size">
                                        <div class="color-name">
                                            <span>Sizes:</span>
                                            <ul class="size_avl">
                                                @foreach ($available_sizes as $size)

                                                    <li class="size">
                                                        <input class="size_id" id="{{ $size->size_id }}" type="radio" name="size_id" value="{{ $size->size_id }}">
                                                        <label for="{{ $size->size_id }}">{{ $size->rel_to_size->size_name }}</label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @error('size_id')
                                                <strong class="text-danger">Please Select a Size </strong>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="pro-single-btn">
                                        <div class="quantity cart-plus-minus">
                                            <input class="text-value" type="text" name="quantity" value="1">
                                        </div>
                                        @auth('cutomer')
                                            <button type="submit" class="theme-btn-s2 cart_btn">Add to cart</button>
                                        @else
                                            <a href="{{ route('cutomer.login') }}" class="theme-btn-s2">Add to cart</a>
                                        @endauth

                                        @auth('cutomer')
                                            <button  class="wl-btn theme-btn-s2 cart_btn text-white" type="submit" formaction="{{route('wishlist.store')}}"><i class="fi flaticon-heart"></i></button>
                                        @else
                                            {{-- <button title="you have to login first" class="wl-btn theme-btn-s2 cart_btn text-danger" type="submit" formaction="{{ route('cutomer.login') }}"><i class="fi flaticon-heart"></i></button> --}}
                                            <a href="{{ route('cutomer.login') }}" class="wl-btn theme-btn-s2 cart_btn text-white"><i class="fi flaticon-heart"></i></a>
                                        @endauth
                                    </div>
                                    <ul class="important-text">
                                        <li><span>SKU:</span>FTE569P</li>
                                        <li><span>Categories:</span>Best Seller, sale</li>
                                        <li><span>Tags:</span>Fashion, Coat, Pink</li>
                                        <li class="stock"></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="product_id" value="{{ $product_details->id }}">
                    </form>
                </div>

                <div class="product-tab-area">
                    <ul class="nav nav-mb-3 main-tab" id="tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="descripton-tab" data-bs-toggle="pill"
                                data-bs-target="#descripton" type="button" role="tab" aria-controls="descripton"
                                aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Ratings-tab" data-bs-toggle="pill" data-bs-target="#Ratings"
                                type="button" role="tab" aria-controls="Ratings" aria-selected="false">Reviews
                                ({{ $reviews->count() }})</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="Information-tab" data-bs-toggle="pill"
                                data-bs-target="#Information" type="button" role="tab" aria-controls="Information"
                                aria-selected="false">Additional info</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="descripton" role="tabpanel"
                            aria-labelledby="descripton-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="Descriptions-item">
                                            <p>Amet consectetur proin diam cras egestas augue habitant integer turpis
                                                egestas egestas. A lectus proin suscipit viverra venenatis eget eget
                                                libero scelerisque. Lacinia parturient id eu vel justo cursus eu. Libero
                                                cursus nisl sollicitudin commodo magnis quam ultrices morbi. Et vitae
                                                eget bibendum quam sed velit. Eget ornare urna nibh ullamcorper sed.
                                                Habitant adipiscing dignissim aliquet laoreet ultrices etiam nulla sed
                                                ut. Lectus ut vitae dignissim in cum id id velit egestas. Magna vel leo
                                                hac massa at.

                                                <br> <br> Urna fermentum id eget turpis eleifend id vitae. Mauris
                                                malesuada ac arcu adipiscing etiam velit at tortor cras. Lacus eget
                                                mollis gravida vulputate sed habitasse enim tempor ullamcorper. Dictum
                                                enim quis morbi tincidunt. Nibh congue massa et arcu viverra lobortis.
                                                Lectus ullamcorper id ut dictumst odio elit. Tristique dapibus diam
                                                velit pharetra quisque odio. </p>
                                            <div class="Description-table">
                                                <ul>
                                                    <li>While thus cackled sheepishly rigid after due one assenting</li>
                                                    <li>Et vitae eget bibendum quam sed velit. Eget ornare urna nibh ullamcorper sed.</li>
                                                    <li>Habitant adipiscing dignissim aliquet laoreet ultrices etiam nulla sed ut.</li>
                                                    <li>Lacinia parturient id eu vel justo cursus eu.</li>
                                                    <li>Mauris malesuada ac arcu adipiscing etiam velit at tortor cras.</li>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="Ratings" role="tabpanel" aria-labelledby="Ratings-tab">
                            <div class="container">
                                <div class="rating-section">
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="comments-area">
                                                <div class="comments-section">
                                                    <h3 class="comments-title">{{ $reviews->count() }} Reviews for {{ $product_details->product_name }}</h3>
                                                    <ol class="comments">
                                                        @foreach ($reviews as $review)
                                                            <li class="comment even thread-even depth-1" id="comment-1">
                                                                <div id="div-comment-1">
                                                                    <div class="comment-theme">
                                                                        <div class="comment-image">
                                                                            @if ($review->rel_to_customer->photo == null)
                                                                                <img width="70" class="m-auto" src="{{ Avatar::create($review->rel_to_customer->fname.' '.$review->rel_to_customer->lname)->toBase64() }}" />
                                                                            @else
                                                                                <img width="70" class="m-auto"  src="{{asset('uploads/customer')}}/{{ $review->rel_to_customer->photo }}" alt="">
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="comment-main-area">
                                                                        <div class="comment-wrapper">
                                                                            <div class="comments-meta">
                                                                                <h4>{{ $review->rel_to_customer->fname.' '.$review->rel_to_customer->lname }}</h4>
                                                                                <span class="comments-date">{{ $review->updated_at->diffForHumans() }}</span>
                                                                                <div class="rating-product">
                                                                                    @for ($i=1; $i<=$review->star; $i++)
                                                                                        <i class="fi flaticon-star"></i>
                                                                                    @endfor
                                                                                </div>
                                                                            </div>
                                                                            <div class="comment-area">
                                                                                <p>{{ $review->review }}
                                                                                    {{-- <a class="comment-reply-link"
                                                                                            href="#"><span>Reply...</span></a> --}}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div> <!-- end comments-section -->

                                                <div class="col col-lg-10 col-12 review-form-wrapper">
                                                    {{-- here customer is cutomer --}}
                                                    @auth('cutomer')
                                                        @if (App\Models\OrderProduct::where('customer_id', Auth::guard('cutomer')->id())->where('product_id',$product_details->id)->exists())
                                                            @if (App\Models\OrderProduct::where('customer_id', Auth::guard('cutomer')->id())->where('product_id',$product_details->id)->whereNotNull('review')->first() == false)
                                                                <div class="review-form">
                                                                    <h4>Add a review</h4>
                                                                    <form action="{{ route('review.store') }}" method="POST">
                                                                        @csrf
                                                                        <div class="give-rat-sec">
                                                                            <div class="give-rating">
                                                                                <label>
                                                                                    <input type="radio" name="stars" value="1">
                                                                                    <span class="icon">★</span>
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="stars" value="2">
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="stars" value="3">
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="stars" value="4">
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                </label>
                                                                                <label>
                                                                                    <input type="radio" name="stars" value="5">
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                    <span class="icon">★</span>
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <textarea class="form-control"
                                                                                placeholder="Write Comment..." name="review"></textarea>
                                                                        </div>
                                                                        <div class="name-input">
                                                                            <input type="text" class="form-control" placeholder="Name" value="{{ Auth::guard('cutomer')->user()->fname }}"
                                                                            required>
                                                                        </div>
                                                                        <div class="name-email">
                                                                            <input type="email" class="form-control" placeholder="Email" value="{{ Auth::guard('cutomer')->user()->email }}"
                                                                                required>
                                                                        </div>
                                                                        <input type="hidden" class="form-control" name="product_id" value="{{ $product_details->id }}"
                                                                        required>
                                                                        <div class="rating-wrapper">
                                                                            <div class="submit">
                                                                                <button type="submit" class="theme-btn-s2">Post
                                                                                    review</button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                            <div class="alert alert-warning">
                                                                <h3>Already Reviewed</h3>
                                                            </div>
                                                            @endif
                                                        @else
                                                            <div class="alert alert-warning">
                                                                <h3>Please review after purchasing the product</h3>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div> <!-- end comments-area -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						<div class="tab-pane fade" id="Information" role="tabpanel" aria-labelledby="Information-tab">
                            <div class="container">
                                <div class="Additional-wrap">
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table-responsive">
                                                <tbody>
                                                    <tr>
                                                        <td>Weight (w/o wheels)</td>
                                                        <td>2 LBS</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Weight Capacity</td>
                                                        <td>60 LBS</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Width</td>
                                                        <td>50″</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Seat back height</td>
                                                        <td>30.4″</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Color</td>
                                                        <td>Black, Blue, Red, White</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Size</td>
                                                        <td>S, M, L, X, XL</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="related-product">
            </div>
        </div>
        <!-- product-single-section  end-->

@endsection

@section('footer_script')
    <script>
        $('.color_id').click(function(){
            var color_id = $(this).val();
            var product_id = '{{ $product_details->id }}'

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $.ajax({
                url:'/getSize',
                type: 'POST',
                data:{'color_id': color_id, 'product_id': product_id},
                success: function(data){
                    $('.size_avl').html(data);

                    //get quantity
                    $('.size_id').click(function(){
                        var size_id = $(this).val();
                        // alert(size_id);
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url:'/getQuantity',
                            type: 'POST',
                            data:{'color_id': color_id, 'product_id': product_id, 'size_id': size_id},
                            success: function(data){
                                $('.stock').html(data);

                                var q = $('.abc').val();
                                if(q == 0){
                                    $('.cart_btn').attr('disabled','')
                                }
                                else{
                                    $('.cart_btn').removeAttr('disabled','')
                                }
                            }

                        })


                    });


                }
            });
        });
    </script>

@if (session('cart_added'))
    <script>
        Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '{{ session('cart_added') }}',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
@endif
@if (session('wish_added'))
    <script>
        Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '{{ session('wish_added') }}',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
@endif
@if (session('wish_removed'))
    <script>
        Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: '{{ session('wish_removed') }}',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
@endif



@endsection
