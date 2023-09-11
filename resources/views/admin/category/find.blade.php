@extends('layouts.main')

@section('content')

@section('name')

Category

@endsection

<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3>Quản lý danh mục</h3>
            </div>
        </div>
        <div class="card-body card-body-customize px-2">
        </div>
        <div class="class">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dataTables_wrapper dt-bootstrap4 no-footer">
                                <div class="row search-column mb-3">
                                    <div class="col-md-3 mb-3">
                                        <input class="form-control" data-url1="{{ route('categories.search') }}" id="search" type="search" placeholder="Search" aria-label="Search" name="search">
                                        <div class="" id="result" style=" position: absolute;z-index: 114;width: 262px;">
                                            <ul class="list-group" id="memlist">
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-primary ">Search</button>
                                        <a class="btn btn-success refresh-button mr-1" href="{{route('categories.index')}}"> <i class="fas fa-sync"></i></a>
                                        <a href="{{route('categories.create')}}" class="btn btn-info">
                                            <i class="fa fa-plus"></i>
                                            Tạo mới
                                        </a>
                                    </div>

                                </div>
                                <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên danh mục</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian tạo</th>
                                        <th>Thứ tự</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr id="sid{{ $itemCategories->id }}">
                                        <th scope="row">{{ $itemCategories->id }}</th>

                                        <td>{{ $itemCategories->name }}</td>
                                        <th>
                                            @if($itemCategories->status == 0)
                                            <button type="button" class="btn btn-danger">Chưa kích hoạt</button>
                                            @elseif($itemCategories->status == 1)
                                            <button type="button" class="btn btn-primary">Kích hoạt</button>
                                            @endif

                                        </th>
                                        <td>{{ $itemCategories->created_at }}</td>
                                        <td>{{ $itemCategories->sort_order }}</td>
                                        <td>
                                            <a class="col-md-3 btn btn-primary " href="{{route('categories.showedit',['id'=> $itemCategories->id])}}">Sửa</a>
                                            <button class="col-md-3 btn btn-danger deletel" data-id="{{ $itemCategories->id }}" data-url="{{route('categories.delete',['id'=> $itemCategories->id])}}" href="">Xóa</button>
                                        </td>
                                    </tr>

                                </tbody>

                                </table>
                                <div class="container">
                                    <div class="d-flex justify-content-end mb-4 mr-4">
                                        <a class="btn btn-primary ml-4" href="{{ route('categories.index') }}">Quay lại </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection

@section('scrip')

<script>
    $(document).on('click', '.deletel', function() {
        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        // alert(id);

        // alert(url);
        if (confirm('Bạn có thực muốn xóa không')) {
            $.ajax({
                type: "GET",
                url: url,

                success: function(data) {
                    if (data.code == 2) {
                        $("#sid" + id).remove();
                        toastr.success(data.message);

                    }
                }

            })
        }
    });


    $(document).ready(function() {

        $('#search').keyup(function() {
            var search = $('#search').val();
            var url1 = $(this).attr('data-url1');
            // alert(url1);

            if (search != '') {
                $.ajax({
                    type: 'GET',
                    url: url1,
                    data: {
                        'search': $('#search').val()
                    },
                    // dataType: 'json',
                    success: function(data) {
                        // console.log(data);

                        $('#memlist').html(data);
                        $('#result').show();

                    }

                });
            } else {
                $('#memlist').html('');
                $('#result').hide();
            }

        })
    })
</script>

@endsection
