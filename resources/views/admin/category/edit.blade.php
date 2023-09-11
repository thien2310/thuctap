@extends('layouts.main')

@section('content')

@section('name')

Category

@endsection


<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3>Sửa Danh mục</h3>
            </div>

            <div class="card-body card-body-customize px-2">
                <div class="class">
                    <form action="{{ route('categories.update', ['id' => $categories->id]) }}" method="post" id="formEditCategory">
                        @csrf

                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">

                                    <div class="col-md-6">
                                        <label for="">Lựa chọn danh mục</label>
                                        <select class="form-select" name="parent_id">
                                            <option value="0">Danh mục cha</option>
                                            @foreach($category as $key)
                                            <option {{ $categories->parent_id == $key['id'] ? 'selected' : false }} value="{{$key['id']}}">{{$key['name']}}</option>
                                            @endforeach
                                        </select>

                                        <span class="text-danger error-text category-parent_id-error"></span>
                                        <br>
                                    </div>



                                    <div class="col-md-6">
                                        <label for="">Chọn trạng thái</label>
                                        <select class="form-select" name="status">
                                            @foreach($statuses as $value)
                                            <option {{ $categories->status == $value['id'] ? 'selected' : '' }} value="{{$value['id']}}"> {{ $value['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="col-md-12">
                                        <label for="">Tên danh mục</label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $categories->name}}">
                                        <span class="text-danger error-text category-name-error"></span>
                                        <br>
                                    </div>


                                    <div class="col-md-12">
                                        <label for="">Chi tiết danh mục</label>
                                        <textarea name="editor1" id="editor1" rows="10" cols="80">
                                        </textarea>
                                    </div>




                                </div>

                                <br>

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
                                <button class="btn btn-danger btn-cons" type="submit">
                                    <i class="fa fa-turn-left"></i> Quay lại</button>

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
    $('#formEditCategory').on('submit', function(e) {
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

        })
    })
</script>

<script>
     CKEDITOR.replace('editor1');
</script>

@endsection
