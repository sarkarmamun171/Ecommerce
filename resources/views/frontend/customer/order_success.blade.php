@extends('frontend.master')

@section('content')
        <!-- start error-404-section -->
        <section class="error-404-section section-padding">
            <div class="container">
                <div class="row">
                    <div class="col col-xs-12">
                        <div class="content clearfix">
                            <div class="error">
                                <img src="{{ asset('frontend/images/order_success.webp') }}" alt>
                            </div>
                            <div class="error-message">
                                <h3>Thank You</h3>
                                <p>Your Order has been placed successfully!</p>
                                <a href="index.html" class="theme-btn">Back to home</a>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end error-404-section -->
@endsection
