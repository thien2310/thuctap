@extends('layouts.main')

@section('content')

@section('name')

Banner

@endsection

<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3> Sửa banner</h3>
            </div>

            <div class="card-body card-body-customize px-2">
                <div class="class">
                    <form action="{{ route('banner.update',['id' => $banner->id ]) }}" method="post" enctype="multipart/form-data" id="EditBanner">

                        @csrf
                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Tiêu đề</label>
                                        <input type="text" class="form-control" name="name" value="{{old('name') ?? $banner->name  }}">
                                        <span class="text-danger error-text banner-name-error"></span>
                                        <br>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="">Chọn trạng thái</label>
                                        <select class="form-select" name="status">
                                            @foreach($statuses as $value)
                                            <option {{ $banner->status == $value['id'] ? 'selected' : '' }} value="{{$value['id']}}"> {{ $value['name'] }}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text banner-status-error"></span>
                                        <br>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Miêu tả chi tiết</label>
                                        <textarea name="intro" id="editor1" rows="10" cols="80">
                                            {!! $banner->intro !!}
                                        </textarea>

                                        <span class="text-danger error-text banner-intro-error"></span>
                                        <br>
                                    </div>



                                </div>

                            </div>

                            <div class="col-md-5">
                                <div class="form-group text-center mb-4">
                                    <label for="">Ảnh icon</label>
                                    <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 2MB.</p>
                                    <div class="main-img-preview img-holder">

                                        <img class="thumbnail img-preview " width="400px" src="{{ $banner->image->path }}">
                                    </div>
                                    <div class="input-group" style="width: 100%; text-align: center">
                                        <div class="input-group-btn" style="margin: 0 auto"> 
                                            <br>
                                            <div class="fileUpload fake-shadow cursor-pointer">
                                                <input class="form-control" id="" type="file" name="file" class="form-control" accept=".jpg,.jpeg,.png">
                                            </div>
                                        </div>
                                    </div>

                                    <span class="text-danger error-text banner-file-error"></span>

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

@section('script')
<script>
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


    $('#EditBanner').on('submit', function(e) {
        e.preventDefault();
        var form = this;

        $.ajax({
            method: $(form).attr('method'),
            url: $(form).attr('action'),
            data: new FormData(form),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function() {
                $(form).find('span.error-text')
            },
            success: function(data) {

                if (data.code == 0) {
                    $.each(data.error, function(prefix, val) {
                        $(form).find('span.banner-' + prefix + '-error').text(val[0]);
                        toastr.warning(data.message);
                    })
                } else if (data.code == 3) {
                    $(form)[0].reset();
                    window.location.href = "{{ route('banner.index') }}";
                    toastr.success(data.message);

                } else if (data.code == 2) {
                    toastr.warning(data.message);
                }
            },
            error: function(e) {
                toastr.error('Đã có lỗi xảy ra');
            },

        })
    })
</script>

<script>
    CKEDITOR.replace('editor1');
</script>
@endsection
