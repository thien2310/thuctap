@extends('layouts.main')

@section('content')

@section('name')

Category

@endsection

<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3>Thêm mới Danh mục</h3>
            </div>

            <div class="card-body card-body-customize px-2">
                <div class="class">
                    <form action="" enctype="multipart/form-data" method="" id="formCreateCategory">
                        @csrf

                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="">Lựa chọn danh mục</label>
                                        <select class="form-select" name="parent_id">
                                            <option value="0">Danh mục cha</option>
                                            @foreach($category as $categories)
                                            <option value="{{ $categories['id'] }}">{{ $categories['name'] }}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text category-parent_id-error"></span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Chọn trạng thái</label>
                                        <select class="form-select" name="status">

                                            @foreach($statuses as $value)
                                            <option value="{{$value['id']}}">{{ $value['name'] }}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text category-status-error"></span>
                                    </div>


                                    <div class="col-md-12">
                                        <label for="">Tên danh mục</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                        <span class="text-danger error-text category-name-error"></span>
                                    </div>



                                </div>

                            </div>

                            <div class="col-md-5">
                                <div class="form-group text-center mb-4">
                                    <label for="">Ảnh icon</label>
                                    <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
                                    <div class="main-img-preview img-holder">

                                        <img class="thumbnail img-preview " src="{{ asset('font-icon/image-icon.png') }}">
                                    </div>
                                    <div class="input-group" style="width: 100%; text-align: center">
                                        <div class="input-group-btn" style="margin: 0 auto">
                                            <br>
                                            <div class="fileUpload fake-shadow cursor-pointer">
                                                <input class="form-control" id="" type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger error-text category-file-error"></span>

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




@endsection
@section('scrip')
<script>
    $('#formCreateCategory').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        // var data = $('#form').serialize();
        // console.log(data);
        $.ajax({
            method: 'post',
            url: "{!! route('categories.store') !!}",
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {

                $(form).find('span.error-text').text('');
            },
            success: function(data) {
                // console.log(data);
                if (data.code == 0) {
                    $.each(data.error, function(prefix, val) {
                        $(form).find('span.category-' + prefix + '-error').text(val[0]);
                        toastr.warning(data.message);
                    })
                } else if (data.code == 3) {
                    $(form)[0].reset();
                    window.location.href = "{{ route('categories.index') }}";
                    toastr.success(data.message);

                } else if (data.code == 2) {

                    toastr.warning(data.message);
                }
            },
            error: function(e) {
                toastr.error('Đã có lỗi xảy ra');
            },
        });

        //reset input type


    })

    $('input[type="file"][name="file"]').val('');
    // image show
    $('input[type="file"][name="file"]').on('change', function() {
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
</script>




@endsection
