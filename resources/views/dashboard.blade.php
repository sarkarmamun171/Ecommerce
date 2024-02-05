
@extends('layouts.admin')


@section('content')
    <div class="col-lg-8 m-auto">
        <div class="card">
            <div class="card-header">
                <h3>Admin Panel</h3>
            </div>
            <div class="card-body">
                <p>Welcome to Dashbord, {{Auth::user()->name}}</p>
            </div>
        </div>
    </div>
@endsection