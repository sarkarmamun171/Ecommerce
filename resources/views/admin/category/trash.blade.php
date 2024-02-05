@extends('layouts.admin')

@section('content')
    @can('trash_category')
        <div class="col-lg-8">
            <form action="{{ route('restore.checked') }}" method="POST" >
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h3>Category List</h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered">
                            <tr>
                                <th>
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th>Sl</th>
                                <th>Category Name</th>
                                <th>Category Image</th>
                                <th>Action</th>
                            </tr>
                            @forelse ($categories as $sl=>$category)
                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" name="category_id[]" value="{{ $category->id }}" id="cate{{ $category->id }}" >
                                            <label class="custom-control-label" for="cate{{ $category->id }}"></label>
                                        </div>
                                    </td>
                                    <td>{{$sl+1}}</td>
                                    <td>{{$category->category_name}}</td>
                                    <td><img src="{{asset('uploads/category')}}/{{$category->category_img}}" width="50"></td>
                                    <td>
                                        <div class="d-flex">
                                            <a title="restore" href="{{route('category.restore', $category->id)}}" class="btn btn-info shadow btn-xs sharp del_btn"><i class="fa fa-reply"></i></a>
                                            &nbsp; &nbsp;
                                            <a title="delete" href="{{route('category.hard.delete', $category->id)}}" class="btn btn-danger shadow btn-xs sharp del_btn"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-info">No Trash Found</td>
                                </tr>
                            @endforelse
                        </table>
                        <button class="btn btn-info" type="submit">Restore Checked</button>
                        <button class="btn btn-danger" type="submit" formaction="{{route('delete.checked.permanent')}}">Delete Permanently</button>
                    </div>
                </div>
            </form>
        </div>
        @else
            <h3 class="danger"> Sorry!! You have not permission to access this page.</h3>
        @endcan
@endsection
@section('footer_script')
    <script>
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endsection
