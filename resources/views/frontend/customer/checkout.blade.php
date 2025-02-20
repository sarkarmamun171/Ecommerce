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
                                <li><a href="cart.html">Cart</a></li>
                                <li>Checkout</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <!-- wpo-checkout-area start-->
        <div class="wpo-checkout-area section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="single-page-title">
                            @php
                                // $quantity = App\Models\Cart::where('customer_id', Auth::guard('cutomer')->id())->first()->quantity;
                                $count = App\Models\Cart::where('customer_id', Auth::guard('cutomer')->id())->count();
                            @endphp
                            <h2>Your Checkout</h2>
                            <p>There are {{ $count }} products in this list</p>
                        </div>
                    </div>
                </div>
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="checkout-wrap">
                        <div class="row">
                            <div class="col-lg-8 col-12">
                                <div class="caupon-wrap s3">
                                    <div class="biling-item">
                                        <div class="coupon coupon-3">
                                            <h2>Billing Address</h2>
                                        </div>
                                        <div class="billing-adress">
                                            <div class="contact-form form-style">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="First Name*" id="fname1"
                                                            name="fname" value="{{ Auth::guard('cutomer')->user()->fname }}">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Last Name*" id="lname2"
                                                            name="lname" value="{{ Auth::guard('cutomer')->user()->lname }}">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <select name="country" id="Country" class="form-control country">
                                                            <option value="">Select Country*</option>
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <select name="city" id="City" class="form-control city">
                                                            <option value="">Select City*</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Postcode / ZIP*" id="zip"
                                                            name="zip" value="{{ Auth::guard('cutomer')->user()->zip }}">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Company" id="company"
                                                            name="company" value="{{ Auth::guard('cutomer')->user()->company }}">
                                                    </div>
                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Phone Number*" id="phone"
                                                            name="phone" value="{{ Auth::guard('cutomer')->user()->phone }}">
                                                    </div>

                                                    <div class="col-lg-6 col-md-12 col-12">
                                                        <input type="text" placeholder="Email*" id="email"
                                                            name="email" value="{{ Auth::guard('cutomer')->user()->email }}">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <input type="text" placeholder="Address*" id="Adress"
                                                            name="address" value="{{ Auth::guard('cutomer')->user()->address }}">
                                                    </div>
                                                    <div class="col-lg-12 col-md-12 col-12">
                                                        <div class="note-area">
                                                            <textarea name="message"
                                                                placeholder="Additional Information or Any Message">
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="biling-item-3">

                                            {{-- <input id="toggle4" name="ship_check" value="1" type="checkbox">
                                            <label class="fontsize" for="toggle4">Ship to a Different Address?</label> --}}
                                            {{-- <input id="toggle4" name="ship_check" value="1" type="radio">
                                            <label class="fontsize" for="toggle4">Ship to a Different Address?</label> --}}
                                            {{-- <br>or<br> --}}
                                            {{-- <input type="hidden" id="office-delivery" name="ship_check" value="2" type="radio"> --}}
                                            {{-- <label class="fontsize" for="office-delivery">Want to Receive from office?</label> --}}

                                            <input id="toggle4" name="ship_check" type="checkbox"  value="0">
                                            <label class="fontsize" for="toggle4">Uncheck for Shipping to a Different Address?</label>

                                            <div class="billing-adress" id="open4">
                                                <div class="contact-form form-style">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="First Name*" id="ship_fname"
                                                                name="ship_fname">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Last Name*" id="ship_lname"
                                                                name="ship_lname">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <select name="ship_country" id="Country2" class="form-control country2 ">
                                                                <option value="">Select Country*</option>
                                                                @foreach ($countries as $country)
                                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <select name="ship_city" id="City2" class="form-control city2">
                                                                <option value="">Select City*</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Postcode / ZIP*" id="ship_zip"
                                                                name="ship_zip">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Company Name*" id="ship_company"
                                                                name="ship_company">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Email Address*" id="ship_email"
                                                                name="ship_email">
                                                        </div>
                                                        <div class="col-lg-6 col-md-12 col-12">
                                                            <input type="text" placeholder="Phone*" id="ship_phone"
                                                                name="ship_phone">
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-12">
                                                            <input type="text" placeholder="Address*" id="ship_address"
                                                                name="ship_address">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-12">
                                <div class="cout-order-area">
                                    <h3>Your Order</h3>
                                    <div class="oreder-item">
                                        <div class="title">
                                            <h2>Products <span>Subtotal</span></h2>
                                        </div>
                                        @foreach ($carts as $cart)
                                            <div class="oreder-product">
                                                <div class="images me-2">
                                                    <span>
                                                        <img style="max-width:100px!important" src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}" alt="">
                                                    </span>
                                                </div>
                                                @php
                                                    $subtotal = $cart->rel_to_product->after_discount * $cart->quantity;
                                                    $quantity = $cart->quantity
                                                @endphp
                                                <div class="product">
                                                    <ul>
                                                        <li class="first-cart">{{ $cart->rel_to_product->product_name }}(x {{ $cart->quantity }})</li>
                                                        <li>
                                                            <div class="rating-product">
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <i class="fi flaticon-star"></i>
                                                                <span>15</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                {{-- <span>&#2547;{{ $cart->rel_to_product->after_discount }}</span> --}}
                                                <span>&#2547;{{ $subtotal }}</span>
                                            </div>
                                         @endforeach

                                        <!-- Shipping -->
                                        <div class="title s2">
                                            <h2>Discount : <span>&#2547;{{ session('discount') }}</span></h2>
                                        </div>
                                        <div class="mt-3 mb-3">
                                            <div class="title border-0">
                                                <h2>Delivery Charge</h2>
                                            </div>
                                            <ul class="shipping-charge" id="shipping-charge">
                                                <li class="free">
                                                    <input  id="Free" class="charge" data-total="{{ session('total') }}" type="radio" name="charge" value="70" >
                                                    <label for="Free">Inside City: <span>&#2547; 70</span></label>
                                                </li>
                                                <li class="free">
                                                    <input id="Local" class="charge" data-total="{{ session('total') }}" type="radio" name="charge" value="100">
                                                    <label for="Local">Outside City: <span>&#2547; 100</span></label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="title s2">
                                            <h2>Total<span>&#2547;<span id="grand">{{ session('total') }}</span></span></h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="caupon-wrap s5">
                                    <div class="payment-area">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="payment-option" id="open5">
                                                    <h3>Payment</h3>
                                                    <div class="payment-select">
                                                        <ul>
                                                            <li class="">
                                                                <input id="remove" type="radio" name="payment_method"
                                                                    value="1">
                                                                <label for="remove">Cash on Delivery</label>
                                                            </li>
                                                            <li class="">
                                                                <input id="add" type="radio" name="payment_method" checked="checked" value="2">
                                                                <label for="add">Pay With SSLCOMMERZ</label>
                                                            </li>
                                                            <li class="">
                                                                <input id="getway" type="radio" name="payment_method"
                                                                    value="3">
                                                                <label for="getway">Pay With STRIPE</label>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <input type="hidden" name="discount" value="{{ session('discount') }}">
                                                    <input type="hidden" name="sub" value="{{ session('sub') }}">
                                                    {{-- <input type="hidden" name="customer_id" value="{{ Auth::guard('cutomer')->id() }}"> --}}
                                                    <input type="hidden" name="customer_id" value="{{ Auth::guard('cutomer')->id() }}">
                                                    <div id="open6" class="payment-name active">
                                                        <div class="contact-form form-style">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 col-12">
                                                                    <div class="submit-btn-area text-center">
                                                                        <button class="theme-btn" type="submit">Place
                                                                            Order</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- wpo-checkout-area end-->

@endsection

@section('footer_script')





    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkbox = document.querySelector('input[name="ship_check"]');
            if (checkbox) {
                checkbox.setAttribute("value", "0"); // Set the attribute to "0" on document ready

                checkbox.addEventListener("change", function() {
                    if (checkbox.checked) {
                        checkbox.setAttribute("value", "0"); // Change the attribute to "1" when checked
                    } else {
                        checkbox.setAttribute("value", "1"); // Change the attribute to "0" when unchecked
                    }
                });
            }
        });
    </script> --}}


<script>
    const checkbox = document.querySelector('input[name="ship_check"]');

    checkbox.addEventListener("change", function() {
        if (checkbox.checked) {
            checkbox.value = "1";
        } else {
            checkbox.value = "0";
        }
    });
</script>

    {{-- <script>
        const checkboxes = document.getElementsByName("ship_check");

        for (const checkbox of checkboxes) {
            checkbox.addEventListener("change", function() {
                if (checkbox.checked) {
                    checkbox.setAttribute("value", "1");
                } else {
                    checkbox.setAttribute("value", "0");
                }
            });
        }
    </script> --}}


    {{-- <script>
        const radioBtn = document.getElementById('office-delivery');
        const shippingCharge = document.getElementById('shipping-charge');

        radioBtn.addEventListener('change', function() {
        if (radioBtn.checked) {
            // If the radio button is selected, hide the shipping-charge ul
            shippingCharge.style.display = 'none';
        } else {
            // If the radio button is not selected, show the shipping-charge ul
            shippingCharge.style.display = 'inline-block';
        }
        });
    </script> --}}


    <script>
        $('.charge').click(function(){
            var charge = $(this).val();
            var total = $(this).attr('data-total');
            var grand_total = parseInt(total) + parseInt(charge);
            $('#grand').html(grand_total);
            // alert(grand_total);
        })
    </script>

    <script>
        $('.country').change(function(){
            var country_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url:'/getCity',
                data:{'country_id':country_id},
                success: function(data){
                    $('.city').html(data);
                }
            });


        });
    </script>
    <script>
        $('.country2').change(function(){
            var country_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url:'/getCity',
                data:{'country_id':country_id},
                success: function(data){
                    $('.city2').html(data);
                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#Country').select2();
            $('#City').select2();
            $('#Country2').select2();
            $('#City2').select2();

        });
    </script>
@endsection
