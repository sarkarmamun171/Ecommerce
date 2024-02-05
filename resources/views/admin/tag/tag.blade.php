@extends('layouts.admin')
@section('content')
<div class="col-lg-8">
    <div class="card">
        <div class="card-header">
            <h3>Tag List</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>SL</th>
                    <th>Tag</th>
                    <th>Action</th>
                </tr>
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->tag }}</td>
                        <td><a href="" class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
<div class="col-lg-4">
    <div class="card">
        <div class="card-header">
            <h3>Add New Tag</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('tag.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label">Tag Name</label>
                    <input type="text" name="tag" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Add Tag</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
