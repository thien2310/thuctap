@extends('layouts.main')

@section('content')

@section('name')

Product

@endsection


<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3>Thêm mới sản phẩm</h3>
            </div>

            <div class="card-body card-body-customize px-2">
                <div class="class">
                    <form action="" method="post" enctype="multipart/form-data" id="createProduct">

                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">

                                    <div class="col-md-12">
                                        <label for="">Danh mục sản phẩm (*)</label>


                                        <select class="form-control cate-Select2" name="cate_id">
                                            <option></option>
                                            @foreach($categorySelect as $cate)
                                            <option value="{{$cate['id']}}">{{$cate['name']}}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text product-cate_id-error"></span>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Tên sản phẩm (*)</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                        <span class="text-danger error-text product-name-error"></span>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Hãng sản xuất (*)</label>
                                        <select class="form-select" name="origin">
                                            <option> </option>
                                            @foreach($origins as $origin)
                                            <option value="{{$origin->id}}">{{$origin->name}}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text product-origin-error"></span>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Xuất xứ (*)</label>
                                        <select class="form-select" name="manufacturer">
                                            <option></option>
                                            @foreach($manufacturers as $manufacturer)
                                            <option value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text product-manufacturer-error"></span>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Thẻ tag</label>

                                        <select class="form-select tag_select2" name="tags[]" multiple="multiple">
                                            @foreach($tags as $tag)
                                            <option value="{{ $tag->id}}">{{$tag->name}}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text "></span>

                                        <span class="input-group-btn">
                                            <button class="btn btn-addon" type="button" data-toggle="modal" data-target="#createTag" style="border: 1px solid #ccc; --bs-btn-hover-color: blue; margin: 5px;"><i class="fa fa-plus"></i></button>
                                        </span>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Miêu tả ngắn gọn</label>

                                        <textarea name="intro" class="ckeditor" id="intro" rows="10" cols="130">

                                         </textarea>

                                        <span class="text-danger error-text product-intro-error"></span>
                                        <br>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="">Miêu tả chi tiết</label>

                                        <textarea name="body" id="" class="ckeditor" id="body" rows="10" cols="130">

                                         </textarea>

                                        <span class="text-danger error-text product-body-error"></span>
                                        <br>
                                    </div>

                                </div>

                            </div>
                            <div class="col-md-4">

                                <div class="col-md-12">
                                    <label for="">Giá trước giảm</label>
                                    <input type="text" class="form-control" name="base_price" value="{{ old('base_price') }}">
                                    <span class="text-danger error-text product-base_price-error"></span>
                                    <br>
                                </div>

                                <div class="col-md-12">
                                    <label for="">Giá bán (*)</label>
                                    <input type="text" class="form-control" name="price" value="{{ old('price') }}">
                                    <span class="text-danger error-text product-price-error"></span>
                                    <br>
                                </div>

                                <div class="col-md-12">

                                    <label for="">Trạng thái</label>

                                    <select class="form-select" name="status">
                                        @foreach($statuses as $status)
                                        <option value="{{ $status['id'] }}">{{ $status['name']}}</option>
                                        @endforeach
                                    </select>

                                    <span class="text-danger error-text product-status-error"></span>
                                    <br>
                                </div>
                                <div class="col-md-12">
                                    <label for="">Tình trạng </label>
                                    <select class="form-select" name="state">
                                        @foreach($state as $sta)
                                        <option value="{{ $sta['id'] }}">{{ $sta['name'] }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger error-text product-state-error"></span>
                                    <br>
                                </div>


                                <div class="form-group text-center mb-4">
                                    <label for="">Ảnh sản phẩm</label>
                                    <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
                                    <div class="main-img-preview img-holder">

                                        <img class="thumbnail img-preview " src="{{ asset('font-icon/image-icon.png') }}">
                                    </div>
                                    <div class="input-group" style="width: 100%; text-align: center">
                                        <div class="input-group-btn" style="margin: 0 auto">
                                            <br>
                                            <div class="fileUpload fake-shadow cursor-pointer">
                                                <input class="form-control" id="" type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger error-text banner-file-error"></span>

                                </div>

                                <div class="form-group text-center">
                                    <label for="">Gallery ảnh</label>

                                    <div class="row gallery-area border ">
                                        <div class="col-md-4 p-2 ">

                                            <div class="gallery-item ">
                                                <button class="btn btn-sm btn-danger" type="button">
                                                    <i class="fa fa-times mr-0"></i>
                                                </button>
                                                <div class="form-group ">
                                                    <div class="img-chooser " title="Chọn ảnh">
                                                        <label for="">
                                                            <img src="\uploads\products\about-01jpg-1682008289-iEjc.jpg" width="120px">
                                                            <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 p-2">
                                            <label class="gallery-item d-flex align-items-center justify-content-center cursor-pointer" for="gallery-chooser">
                                                <i class="fa fa-plus fa-2x text-secondary"></i>
                                            </label>
                                            <input class="d-none" type="file"  name="gallery[]" accept=".jpg,.png,.jpeg" id="gallery-chooser" multiple>
                                        </div>
                                    </div>
                                    <span class="invalid-feedback">
                                        <strong>

                                        </strong>
                                    </span>
                                </div>


                            </div>

                            <hr>
                            <div class="text-right">
                                <button class="btn btn-success btn-cons" type="submit">
                                    <i class="fa fa-save"></i> LƯU</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

@include('admin.product.model')

@endsection

@section('script')

<script>
    $(document).ready(function() {
        if ($("#body").length > 0) {
            CKEDITOR.replace('#body')
        }
    })
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $('#createProduct').on('submit', function(e) {
        e.preventDefault();

        var body = CKEDITOR.instances.body.getData();
        var intro = CKEDITOR.instances.intro.getData();
        var form = this;
        var formData = new FormData(form);
        formData.append('body', body);
        formData.append('intro', intro);

        $.ajax({
            method: "POST",
            url: "{!! route('product.store') !!}",
            processData: false,
            data: formData,
            dataType: "json",
            contentType: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(res) {
                CKEDITOR.instances.body.setData('');
                CKEDITOR.instances.intro.setData('');

                if (res.code == 0) {
                    // $(form)[0].reset();
                    $.each(res.error, function(prefix, val) {
                        $(form).find('span.product-' + prefix + '-error').text(val[0]);
                        toastr.warning(res.message);
                    })
                };

                if (res.code == 1) {
                    $(form)[0].reset();
                    toastr.success(res.message);

                    window.location.href = "{{ route('product.index') }}";
                }

            }

        })

    });

    $('#submitTagProduct').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        $.ajax({
            method: "POST",
            url: "{!! route('tag.store') !!}",
            processData: false,
            data: new FormData(form),
            dataType: "json",
            contentType: false,
            beforeSend: function() {
                $(form).find('span.error-text').text('');
            },
            success: function(res) {

                if (res.code == 0) {
                    $.each(res.error, function(prefix, val) {
                        $(form).find('span.tag-' + prefix + '-error').text(val[0]);
                        toastr.warning(res.message);
                    })
                };

                if (res.code == 3) {
                    $(form)[0].reset();
                    toastr.warning(res.message);
                    location.reload()
                }


            }

        })


    })

    $('input[type="file"][name="image"]').val('');
    // image show
    $('input[type="file"][name="image"]').on('change', function() {
        var img_path = $(this)[0].value;
        var img_holder = $('.img-holder');
        var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

        // alert(extension);
        if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
            if (typeof(FileReader) != 'undefined') {
                img_holder.empty();
                var render = new FileReader();

                render.onload = function(e) {
                    $('<img/>', {
                        'src': e.target.result,
                        'class': 'img-fluid',
                        'style': 'max-width:200px;margin-bottom:10px;'
                    }).appendTo(img_holder);

                }
                img_holder.show();
                render.readAsDataURL($(this)[0].files[0]);

            } else {
                $(img_holder).html('Không đúng định dạng');
            }
        } else {
            $(img_holder).empty();
        }
    });

    $('#gallery-chooser').fileinput({
        theme: 'fa',
        uploadUrl:"",
    });
</script>

<script>
    $(".cate-Select2").select2({
        allowClear: true,
        placeholder: "Lựa chọn sản phẩm"
    })

    $(".tag_select2").select2({
        placeholder: 'Chọn thẻ tag',
        allowClear: true,
        tags: false
    })
</script>





@endsection
