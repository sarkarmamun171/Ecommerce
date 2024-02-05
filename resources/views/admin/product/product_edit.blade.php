@extends('layouts.admin')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3>Add New Product</h3>
            <a href="{{ route('product.list') }}" class="btn btn-primary"><i class="fa fa-list"></i> Product List</a>
        </div>
        <div class="card-body">
            <form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">
                @csrf

                @if (session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif
                <div class="row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Seclect Category</option>
                                @foreach ($categories as $category)
                                {{-- <option value="{{ $category->id }}">{{ $category->category_name }}</option> --}}
                                <option value="{{ $category->id }}" @if($category->id == $products->category_id) selected @endif>
                                    {{ $category->category_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Sub Category</label>
                            <select name="subcategory" id="subcategory" class="form-control">
                                <option value="">Seclect Sub Category</option>
                                @foreach ($subcategories as $subcategory)
                                {{-- <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option> --}}
                                <option value="{{ $subcategory->id }}" @if($subcategory->id == $products->subcategory_id) selected @endif>
                                    {{ $subcategory->subcategory_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('subcategory')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="" class="form-label">Product Brand</label>
                            <select name="brand" class="form-control">
                                <option value="">Seclect Product Brand</option>
                                @foreach ($brands as $brand)
                                {{-- <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option> --}}
                                <option value="{{ $brand->id }}" @if($brand->id == $products->brand_id) selected @endif>
                                    {{ $brand->brand_name }}
                                </option>
                                @endforeach
                            </select>
                            @error('brand')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Product Name</label>
                            <input type="text" class="form-control" name="product_name" value="{{ $products->product_name }}">
                            @error('product_name')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Price</label>
                            <input type="number" class="form-control" name="price" value="{{ $products->price }}">
                            @error('price')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Discount</label>
                            <input type="number" class="form-control" name="discount" value="{{ $products->discount }}">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Tags</label>
                            <input type="text" class="form-control required" name="tags" id="tags" value="{{ $products->tags }}">
                        @error('tags')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="" class="form-label">Short Description</label>
                            <textarea id="short_desp" name="short_desp" type="text" class="form-control" name="short_desp">{{ $products->short_desp }}</textarea>
                        </div>
                        {{-- @error('short_desp')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror --}}
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="" class="form-label">Long Description</label>
                            <textarea id="long_desp" name="long_desp" type="text" class="form-control" name="Long_desp">{{ $products->long_desp }}</textarea>
                        </div>
                        @error('long_desp')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror
                    </div>
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="" class="form-label">Additional Information</label>
                            <textarea type="text" class="form-control" name="additional_info">{{ $products->additional_info }}</textarea>
                            @error('additional_info')
                                <strong class="text-danger">{{$message}}</strong>
                            @enderror
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Preview Image</label>
                            <input type="file" class="form-control" name="preview" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"></input>
                        </div>
                        @error('preview')
                         <strong class="text-danger">{{$message}}</strong>
                        @enderror
                        <div class="my-2">
                            {{-- <img width="100" src="" id="blah" alt=""> --}}
                            <img src="{{ asset('uploads/product/preview') }}/{{ $products->preview }}" width="100">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mb-3">
                            {{-- <label for="" class="form-label">Gallery Image</label>
                            <input type="file" class="form-control" name="preview[]"></input> --}}
                            <div class="upload__box">
                                <span >Gallery Images</span>
                                <div class="upload__btn-box">
                                  <label class="upload__btn">
                                    <p class="m-0">Upload images</p>
                                    <input name="gallery[]" type="file" multiple="" data-max_length="20" class="upload__inputfile">
                                  </label>
                                </div>
                                <div class="upload__img-wrap"></div>
                            </div>
                        </div>
                        @error('gallery')
                            <strong class="text-danger">{{$message}}</strong>
                        @enderror

                    </div>
                    <div class="col-lg-4 m-auto">
                        <div class="mb-3">
                            <button type="submit" class="btn-primary p-3 rounded">Add New Product</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
    <script>
        $('#category').change(function(){
            var category_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url:'/getSubcategory2',
                data:{'category_id': category_id},
                success: function(data){
                    $('#subcategory').html(data);
                }

            });

            // alert(category_id);
        })

    </script>



    <script>
        $("#tags").selectize({
            delimiter: ",",
            persist: false,
            create: function (input) {
                return {
                    value: input,
                    text: input,
                };
            },
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#short_desp').summernote();
            // $('#short_desp').summernote('code', '')
            // $('#short_desp').html(escape($('#short_desp').summernote('code', '<b>some</b>')));
            $('#long_desp').summernote();
        });
    </script>

    <script>
jQuery(document).ready(function () {
  ImgUpload();
});

function ImgUpload() {
  var imgWrap = "";
  var imgArray = [];

  $('.upload__inputfile').each(function () {
    $(this).on('change', function (e) {
      imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
      var maxLength = $(this).attr('data-max_length');

      var files = e.target.files;
      var filesArr = Array.prototype.slice.call(files);
      var iterator = 0;
      filesArr.forEach(function (f, index) {

        if (!f.type.match('image.*')) {
          return;
        }

        if (imgArray.length > maxLength) {
          return false
        } else {
          var len = 0;
          for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i] !== undefined) {
              len++;
            }
          }
          if (len > maxLength) {
            return false;
          } else {
            imgArray.push(f);

            var reader = new FileReader();
            reader.onload = function (e) {
              var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
              imgWrap.append(html);
              iterator++;
            }
            reader.readAsDataURL(f);
          }
        }
      });
    });
  });

  $('body').on('click', ".upload__img-close", function (e) {
    var file = $(this).parent().data("file");
    for (var i = 0; i < imgArray.length; i++) {
      if (imgArray[i].name === file) {
        imgArray.splice(i, 1);
        break;
      }
    }
    $(this).parent().parent().remove();
  });
}
// function ImgUpload() {
//     var imgWrap = "";
//     var imgArray = [];

//     $('.upload__inputfile').each(function () {
//         $(this).on('change', function (e) {
//             imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
//             var maxLength = $(this).attr('data-max_length');

//             var files = e.target.files;
//             var filesArr = Array.prototype.slice.call(files);
//             var iterator = 0;

//             filesArr.forEach(function (f, index) {
//                 if (!f.type.match('image.*')) {
//                     return;
//                 }

//                 if (imgArray.length >= maxLength) {
//                     return false;
//                 } else {
//                     imgArray.push(f);

//                     var reader = new FileReader();
//                     reader.onload = function (e) {
//                         var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
//                         imgWrap.append(html);
//                         iterator++;
//                     };
//                     reader.readAsDataURL(f);
//                 }
//             });
//         });
//     });

//     // Handling removal of uploaded images
//     $('body').on('click', ".upload__img-close", function (e) {
//         var file = $(this).parent().data("file");
//         for (var i = 0; i < imgArray.length; i++) {
//             if (imgArray[i].name === file) {
//                 imgArray.splice(i, 1);
//                 break;
//             }
//         }
//         $(this).parent().parent().remove();
//     });
// }

    </script>
@endsection
