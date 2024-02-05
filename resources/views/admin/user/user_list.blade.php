@extends("layouts.admin")

@section("content")
@can('user_access')
    <div class="col-lg-8 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>User List </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>sl</td>
                            <td>Photo</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Action</td>
                        </tr>
                        @foreach ( $users as $key=>$user )

                        <tr>
                            <td>{{ $key++ }}</td>
                            <td>
                                @if ($user->photo == null)
                                <img width="70" src="{{ Avatar::create($user->name)->toBase64() }}" />
                                @else
                                    <img width="70" src="{{asset('uploads/user')}}/{{ $user->photo }}" alt="">
                                @endif

                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>

                                <div class="d-flex">
                                    {{-- <a href="#" class="btn btn-primary shadow btn-xs sharp mr-1"><i class="fa fa-pencil"></i></a> --}}
                                    <button data-link="{{ route('user.remove',$user->id) }}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></button>
                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </table>
                </div>
            </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add New User </h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('custom.register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form_label">Name</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form_label">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form_label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endcan

@endsection

@section('footer_script')
    <script>
        $('.del_btn').click(function(){

            var link = $(this).attr('data-link');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href=link;

                }
                })
        })
    </script>

    @if (session('delete'))
        <script>

            Swal.fire({
            title: 'Deleted',
            text: 'The user Deleted Successfully',
            imageUrl: 'https://unsplash.it/400/200',
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: 'Custom image',
            })
            // Swal.fire({
            // position: 'top-end',
            // icon: 'success',
            // title: 'The user Deleted Successfully',
            // showConfirmButton: false,
            // timer: 1500
            // })

            // Swal.fire(
            // 'Deleted!',
            // '{{ session('delete') }}',
            // 'success'
            // )
        </script>
    @endif
@endsection
