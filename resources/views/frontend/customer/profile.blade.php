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
                                <li>Customer Profile</li>
                            </ol>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </section>
        <!-- end page-title -->

        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="card text-center my-3 pt-3" >
                        @if (Auth::guard('cutomer')->user()->photo == null)
                            <img width="70" class="m-auto" src="{{ Avatar::create(Auth::guard('cutomer')->user()->fname)->toBase64() }}" />
                        @else
                            <img width="70" class="m-auto"  src="{{asset('uploads/customer')}}/{{ Auth::guard('cutomer')->user()->photo }}" alt="">
                        @endif
                        <div class="card-body">
                          <h5 class="card-title">{{ Auth::guard('cutomer')->user()->fname .' '. Auth::guard('cutomer')->user()->lname }}</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item bg-light py-3">Update Profile</li>
                          <li class="list-group-item bg-light py-3"><a href="{{ route('customer.order') }}" class="text-dark">My Order</a></li>
                          <li class="list-group-item bg-light py-3">Wishlist</li>
                          <li class="list-group-item bg-light py-3"><a href="{{ route('customer.logout') }}" class="text-dark">Logout</a></li>
                        </ul>

                      </div>
                </div>
                <div class="col-lg-9">
                    <div class="card my-3">
                        <div class="card-header">
                            <h3>Update Profile Information</h3>
                        </div>
                        @if (session('success'))
                            <span class="alert alert-success">{{ session('success') }}</span>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row my-3">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">First Name</label>
                                            <input type="text" class="form-control" name="fname" value="{{ Auth::guard('cutomer')->user()->fname }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" name="lname" value="{{ Auth::guard('cutomer')->user()->lname }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="{{ Auth::guard('cutomer')->user()->email }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Country</label>
                                            <input type="text" class="form-control" name="country" value="{{ Auth::guard('cutomer')->user()->country }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" value="{{ Auth::guard('cutomer')->user()->phone }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Zip</label>
                                            <input type="number" class="form-control" name="zip" value="{{ Auth::guard('cutomer')->user()->zip }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Image</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Address</label>
                                            <input type="text" class="form-control" name="address" value="{{ Auth::guard('cutomer')->user()->address }}">
                                        </div>
                                    </div>
                                    {{-- <input type="text" name="abcd"> --}}
                                    <div class="col-lg-12">
                                        <div class="mb-3 text-center my-3">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
