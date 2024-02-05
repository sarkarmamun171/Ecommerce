@extends('layouts.admin')

@section('content')
    @can('product_access')
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>Product List</h3>
                    <a href="{{ route('product') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Add Product</a>
                </div>
                <div class="card-body">
                    @if (session('delete'))
                    <div class="alert alert-success">{{session('delete')}}</div>
                @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            {{-- <th>Subcategory</th> --}}


                            <th>Status</th>
                            <th>Brand Name</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Discount(%)</th>
                            <th>After Discount</th>
                            <th>Preview</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($products as $sl=>$product)
                            <tr>
                                <td>{{ $sl+1}}</td>
                                <td>{{ $product->rel_to_category->category_name}}</td>
                                <td><input  data-id="{{$product->id}}" {{ $product->status == 1 ?'checked':'' }} class="check" type="checkbox" data-toggle="toggle" data-size="sm" value="{{ $product->status }}" ></td>
                                {{-- <td>{{ $product->subcategory_name}}</td> --}}
                                {{-- <td>{{ $product->brand_name}}</td> --}}
                                {{-- <td>{{ $product->rel_to_category ? $product->rel_to_category->category_name : 'N/A' }}</td>
                                <td>{{ $product->rel_to_subcategory ? $product->rel_to_subcategory->subcategory_name : 'N/A' }}</td> --}}
                                <td>{{ $product->rel_to_brand ? $product->rel_to_brand->brand_name : 'N/A' }}</td>

                                {{-- <td>{{ $product->rel_to_category->category_name}}</td>
                                <td>{{ $product->rel_to_subcategory->subcategory_name}}</td>
                                <td>{{ $product->rel_to_brand->brand_name}}</td> --}}
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>{{ $product->after_discount }}</td>
                                <td>
                                    <img width="70" src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="">
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a  title="inventory" href="{{route('inventory', $product->id)}}" class="btn btn-primary shadow btn-xs sharp"><i class="fa fa-archive"></i></a>
                                        &nbsp; &nbsp;
                                        <a  title="view" href="{{route('product.show', $product->id)}}" class="btn btn-info shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
                                        &nbsp; &nbsp;
                                        <a title="delete" href="{{route('product.delete', $product->id)}}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                                        &nbsp; &nbsp;
                                        <a title="edit" href="{{route('product.edit', $product->id)}}" class="btn btn-info shadow btn-xs sharp"><i class="fa fa-pencil"></i></a>
                                    </div>
                                </td>


                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
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
            var product_id = $(this).attr('data-id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url:'/changeStatus',
                data:{'product_id':product_id, 'status':status},
                success: function(data){
                    // alert(data);
                }
            });
        });
    </script>

@endsection
