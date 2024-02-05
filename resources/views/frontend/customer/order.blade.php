@extends('frontend.master')

@section('content')
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
                    <h3>My Orders</h3>
                </div>
                @if (session('success'))
                    <span class="alert alert-success">{{ session('success') }}</span>
                @endif
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($myorders as $sl=>$order)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->total }}</td>
                            <td>
                                @if ($order->status == 0)
                                    <span class="badge bg-secondary">Placed</span>
                                @elseif ($order->status == 1)
                                    <span class="badge bg-info text-dark">Processing</span>
                                @elseif ($order->status == 2)
                                    <span class="badge bg-primary">Shipped</span>
                                @elseif ($order->status == 3)
                                    <span class="badge bg-primary text-dark">Out for Delivery</span>
                                @elseif ($order->status == 4)
                                    <span class="badge bg-success">Received</span>
                                @elseif ($order->status == 5)
                                    <span class="badge bg-danger">Canceled</span>
                                @endif
                            </td>
                            <td>

                                @if ($order->status != 5)
                                    <a href="{{ route('cancel.myorder', $order->id) }}" class="btn btn-outline-danger">Cancel Order</a>
                                    <a href="{{ route('order.invoice.download', $order->id) }}" class="btn btn-outline-success">Download Invoice </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $myorders->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
