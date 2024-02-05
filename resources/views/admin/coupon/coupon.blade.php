@extends('layouts.admin')

@section('content')
    @can('coupon_access')
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Coupon List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Coupon</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Limit</th>
                            <th>Validity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($coupons as $sl=>$coupon )
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $coupon->coupon }}</td>
                            <td>{{ $coupon->type==1?'Percentage':'Solid' }}</td>
                            <td>{{ $coupon->amount}} {{ $coupon->type==1?'%':'Taka' }}</td>
                            <td>{{ $coupon->limit}}</td>
                            <td>
                                @if (Carbon\Carbon::now() > $coupon->validity)
                                    <span class="badge badge-outline-danger">Expired</span>
                                @else
                                <span class="badge badge-outline-success">{{ Carbon\Carbon::now()->diffInDays($coupon->validity, false)}} Days Left</span>

                                @endif
                            </td>
                            <td>
                                <input  data-id="{{$coupon->id}}" {{ $coupon->status == 1 ?'checked':'' }} class="check" type="checkbox" data-toggle="toggle" data-size="sm" value="{{ $coupon->status }}" >
                            </td>
                            <td>
                                <a title="delete" href="{{route('coupon.delete', $coupon->id)}}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        @can('add_coupon')
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3>Add New Coupon</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('coupon.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Coupon Name</label>
                                <input type="text" name="coupon" class="form-control">
                                @error('coupon')
                                    <strong class="text-danger">Please Enter Coupon Name</strong>
                                @enderror
                                @if (session('coupon'))
                                <strong class="text-success">{{ session('coupon') }}</strong>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Coupon Type</label>
                                <select name="type" class="form-control">
                                    <option value="">Select Coupon Type</option>
                                    <option value="1">Percentage</option>
                                    <option value="2">Solid Amount</option>
                                </select>
                                @error('type')
                                <strong class="text-danger">Please Enter Coupon type</strong>
                            @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Coupon Amount</label>
                                <input type="number" name="amount" class="form-control">
                                @error('amount')
                                    <strong class="text-danger">Please Enter Coupon amount</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Coupon Limit</label>
                                <input type="number" name="limit" class="form-control">
                                @error('limit')
                                    <strong class="text-danger">Please Enter Coupon limit</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Coupon Validity</label>
                                <input type="date" name="validity" class="form-control">
                                @error('validity')
                                    <strong class="text-danger">Please Enter Coupon validity date</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit"  class="btn btn-primary">Add Coupon</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
    @endcan
@endsection


@section('footer_script')

    <script>
        $('.check').change(function(){
            if($(this).val() == 1){
                $(this).attr('value', 0)
            }
            else{
                $(this).attr('value',1)
            }
            var status = $(this).val();
            var coupon_id = $(this).attr('data-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url:'/CouponchangeStatus',
                data:{'coupon_id':coupon_id, 'status':status},
                success: function(data){
                    // alert(data);
                }
            });
        });
    </script>

@endsection
