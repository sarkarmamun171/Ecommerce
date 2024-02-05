@extends('layouts.admin')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>FAQ List</h3>
                <a href="{{ route('faq.create') }}" class="badge bg-primary text-white">Add New FAQ</a>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>SL</th>
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($faqs as $sl=>$faq)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $faq->question }}</td>
                            <td>{{ Str::substr($faq->answer, 0, 90).'...' }}</td>
                            <td>
                                <div class="d-flex">
                                    <a  href="{{ route('faq.edit',$faq->id) }}" title="Edit QA" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-pencil"></i></a>
                                    &nbsp; &nbsp;
                                    <a title="view QA" href="{{ route('faq.show',$faq->id) }}" class="btn btn-primary shadow btn-xs sharp "><i class="fa fa-eye"></i></a>
                                    &nbsp; &nbsp;
                                    <form action="{{ route('faq.destroy',$faq->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button title="Delete QA" type="submit" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
