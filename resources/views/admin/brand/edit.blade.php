@extends('layouts.admin')

@section('content')
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Update Brand</h3>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('brand.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <input type="hidden" name="brand_id" value="{{ $brand_info->id }}">
                    <label for="brand_name" class="form-label">Brand Name</label>
                    <input type="text" name="brand_name" id="brand_name" class="form-control" value="{{ $brand_info->brand_name }}">
                    @error('brand_name')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Brand Logo</label>
                    <input type="file" name="brand_logo" class="form-control" >
                    @error('brand_logo')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Brand</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
