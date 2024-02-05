@extends('layouts.admin')

@section('content')
    <div class="col-lg-12">
        @php
            $tabularData = explode("\n", $products->short_desp); // Assuming each line is a row
        @endphp
        <div class="card">
            <div class="card-header">
                <h3>Product Details</h3>
                <a href="{{ route('product.list') }}" class="btn btn-primary"><i class="fa fa-list"></i> Product List</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <td>Product Name</td>
                        <td>{{ $products->product_name }}</td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>{{ $products->price }}</td>
                    </tr>
                    <tr>
                        <td>Short Description</td>
                        <td>{!! $products->short_desp !!}</td>

                    </tr>
                    <tr>
                        <td>Long Description</td>
                        <td>{!! $products->long_desp !!}</td>

                        {{-- <td>{{ $products->long_desp }}</td> --}}

                    </tr>
                    <tr>
                        <td>Additional Information</td>
                        <td>{!!html_entity_decode($products->additional_info)!!}</td>
                        {{-- <td>{{ $products->additional_info }}</td> --}}
                    </tr>
                    <tr>
                        <td>Preview</td>
                        <td>
                            <img width="200" src="{{ asset('uploads/product/preview') }}/{{$products->preview}}" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td>Gallery</td>
                        <td>
                            @foreach ($galleries as $gal)
                                <img width="100" src="{{asset('uploads/product/gallery')}}/{{$gal->gallery}}" alt="">
                            @endforeach
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
@endsection
