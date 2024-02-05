@extends('layouts.admin')


@section('content')
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Update Profile Information</h3>
            </div>
            <div class="card-body">
                <form action="{{route('user.profile.update')}}" method="POST">
                    @csrf
                    <label for="user_name" class="">Name</label>
                    <div class="mb-3">
                        <input style="font-weight: 400; font-size:larger; color:black;" id="user_name" type="text" name="user_name" class="form-control" placeholder="Name" value="{{Auth::user()->name}}">
                        @error('name')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <label for="user_email" class="">Email</label>
                    <div class="mb-3">
                        <input style="font-weight: 400; font-size:larger; color:black;" id="user_email" type="text" name="user_email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}">
                        @error('email')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <li>Laravel: {{ app()->version() }}</li>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Update Password</h3>
            </div>
            <div class="card-body">
                <form action="{{route('user.pass.update')}}" method="POST">
                    @if (session('pass-update'))
                        <strong class="alert alert-success">{{session('pass-update')}}</strong>
                    @endif
                    @csrf
                    <!-- <label for="old_password" class="">Old Password</label> -->
                    <div class="mb-3">
                        <input style="font-weight: 400; font-size:larger; color:black;" id="old_password" type="text" name="current_password" class="form-control" placeholder="old password">
                        @error('current_password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        @if (session('current-pass'))
                            <strong class="text-danger">{{session('current-pass')}}</strong>
                        @endif

                    </div>
                    <!-- <label for="password" class="">New Password</label> -->
                    <div class="mb-3">
                        <input style="font-weight: 400; font-size:larger; color:black;" id="password" type="text" name="password" class="form-control" placeholder="new password">
                        @error('password')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <!-- <label for="password" class="">New Password</label> -->
                    <div class="mb-3">
                        <input style="font-weight: 400; font-size:larger; color:black;" id="password confirmation" type="text" name="password_confirmation" class="form-control" placeholder="password confirmation">
                        @error('password_confirmation')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Update Profile Photo</h3>
            </div>
            <div class="card-body">
                <form action="{{route('user.photo.update')}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    <label for="password" class="">Upload Photo</label>
                    <div class="mb-3">
                        <input style="font-weight: 400; font-size:larger; color:black;" id="photo" type="file" name="photo" class="form-control"
                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        @error('photo')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <img src="" id="blah" alt="" width="200" >
                    </div>


                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <br>
                    <div class="flex-end">
                        @if (session('photo-update'))
                            <strong class="alert alert-success">{{session('photo-update')}}</strong>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
