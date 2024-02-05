@extends('layouts.admin')
@section('content')
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Edit FAQ</h3>
                <a href="{{ route('faq.index') }}" class="badge bg-primary text-white">FAQ List</a>
            </div>
            <div class="card-body">
                <form action="{{ route('faq.update',$faq->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Question</label>
                        <input type="text" name="question" class="form-control" value="{{ $faq->question }}">
                        @error('question')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Answer</label>
                        <textarea type="text" name="answer" class="form-control">{{ $faq->answer }}</textarea>
                        @error('answer')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
