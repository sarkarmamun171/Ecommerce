@extends('layouts.admin')

@section('content')
        <div class="col-lg-8">
            @can('subcategory_access')
                <div class="card">
                    <div class="card-header">
                        <h3>Sub Category List</h3>

                    </div>
                    <div class="card-body">
                        @if (session('deleted'))
                            <div class="alert alert-danger">{{ session('deleted') }}</div>
                        @endif
                        <div class="row">
                            @foreach ($categories as $category )
                                <div class="col-lg-6">
                                    <div class="card bg-light">
                                        <div class="card-header">
                                            <h3>{{ $category->category_name }}</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th>Subcategory Name</th>
                                                    <th>Action</th>
                                                </tr>

                                                @foreach (App\Models\Subcategory::where('category_id', $category->id)->get() as $subcategory)
                                                    <tr>
                                                        <td>{{ $subcategory->subcategory_name }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <a  href="{{route('subcategory.edit', $subcategory->id)}}" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-pencil"></i></a>
                                                                &nbsp; &nbsp;
                                                                <a href="{{route('subcategory.delete', $subcategory->id)}}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            @endcan
        </div>
        <div class="col-lg-4">
            @can('add_subcategory')
                <div class="card">
                    <div class="card-header">Add New Subcategory</div>
                    <div class="card-body">
                        @if (session('exist'))
                            <div class="alert alert-warning">{{ session('exist') }}</div>
                        @endif
                        <form action="{{ route('subcategory.store') }}" method="POST">

                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @csrf

                            <div class="mb-3">
                                <select name="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label">Subcategory Name</label>
                                <input type="text" name="subcategory_name" class="form-control">
                                @error('subcategory_name')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Add Subcategory</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
        </div>
@endsection
