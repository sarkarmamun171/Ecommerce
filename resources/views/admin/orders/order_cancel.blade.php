@extends('layouts.admin')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Order List</h3>
            <a href="" class="btn btn-info">Order Cancel Requests</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Charge</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach ($cancel_orders as $order )
                    <tr>
                        <td>{{ $order->order_id }}</td>
                        <td>{{ $order->rel_to_customer->fname.' '. $order->rel_to_customer->lname}}</td>
                        <td>{{ $order->total}}</td>
                        <td>{{ $order->discount}}</td>
                        <td>{{ $order->charge}}</td>
                        <td>
                            @if ($order->status == 0)
                                <span class="badge badge-light">Placed</span>
                            @elseif ($order->status == 1)
                            <span class="badge badge-primary">Processing</span>
                            @elseif ($order->status == 2)
                            <span class="badge badge-secondary">Shipped</span>
                            @elseif ($order->status == 3)
                            <span class="badge badge-info">Out for Delivery</span>
                            @elseif ($order->status == 4)
                            <span class="badge badge-success">Delivered</span>
                            @elseif ($order->status == 5)
                            <span class="badge badge-danger">Canceled</span>

                            @endif

                        </td>
                        <td>
                            <form action="{{ route('order.status.update') }}" method="POST">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->order_id }}">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Select Status
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button name="status" class="dropdown-item" {{ $order->status==5?'selected':'' }} style="color:{{ $order->status==5?'blue':'' }}" value="5">Canceled</button>
                                    </div>
                                  </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

</div>
@endsection
