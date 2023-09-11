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
                                        <button class="btn btn-success refresh-button mr-1 reload"> <i class="fas fa-sync"></i></button>
                                        <a href="{{route('categories.create')}}" class="btn btn-info">
                                            <i class="fa fa-plus"></i>
                                            Tạo mới
                                        </a>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <select class="form-select ml-5 selectStatusCategory" data-url2="{{ route('categories.changestatus') }}" aria-label="Default select example">
                                            <option selected>Chọn trạng thái</option>
                                            @foreach($statuses as $value)
                                            <option value="{{$value['id']}}">{{ $value['name'] }}</option>
                                            @endforeach
                                        </select>
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
                                    <tbody class="body">

                                    </tbody>

                                    @foreach($category as $value)
                                    <tbody class="body1">
                                        <tr id="sid{{ $value->id }}">
                                            <th scope="row">{{ $value->id }}</th>

                                            <td>{{ $value->name }}</td>
                                            <th>
                                                @if($value->status == 0)
                                                <button type="button" class="btn btn-danger">Chưa kích hoạt</button>
                                                @elseif($value->status == 1)
                                                <button type="button" class="btn btn-primary">Kích hoạt</button>
                                                @endif

                                            </th>
                                            <td>{{ $value->created_at }}</td>
                                            <td>{{ $value->sort_order }}</td>
                                            <td>
                                                <a class="col-md-3 btn btn-primary " href="{{route('categories.showedit',['id'=> $value->id])}}">Sửa</a>
                                                <button class="col-md-3 btn btn-danger deletel" data-id="{{ $value->id }}" data-url="{{route('categories.delete',['id'=> $value->id])}}" href="">Xóa</button>
                                            </td>
                                        </tr>

                                    </tbody>
                                    @endforeach

                                </table>
                                <div class="container">
                                    <div class="d-flex justify-content-end mb-4 mr-4">
                                        {{ $category->links() }}
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
    $(document).on('click', '.reload', function(){
        location.reload()
    });
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

            // console.log(idItem);
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
                        $('#result').show(300);

                    }

                });
            } else {
                $('#memlist').html('');
                $('#result').hide(600);
            }

        })
    })


    $(document).on('change', '.selectStatusCategory', function() {
        var changeItem = $(this).val();
        var url2 = $(this).attr('data-url2')
        if (changeItem == 1 || changeItem == 0) {
            $.ajax({
                type: 'GET',
                url: url2,
                data: {
                    'changeItem': changeItem
                },
                // dataType: 'json',
                success: function(data) {
                    // console.log(data)
                    $('.body').html(data)
                    $('.body1').hide()
                }

            });
        } else {
            $('.body1').show()
            $('.body').html('')
        }
    })
</script>

@endsection
