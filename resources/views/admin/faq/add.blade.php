@extends('layouts.admin')
@section('content')
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Add New FAQ</h3>
                <a href="{{ route('faq.index') }}" class="badge bg-primary text-white">FAQ List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('faq.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Question</label>
                        <input type="text" name="question" class="form-control">
                        @error('question')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Answer</label>
                        <input type="text" name="answer" class="form-control">
                        @error('answer')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
