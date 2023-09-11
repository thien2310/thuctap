@extends('layouts.main')

@section('content')

@section('name')

Sản phẩm

@endsection


<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3>Quản lý Sản phẩm</h3>
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
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <button class="btn btn-primary ">Search</button>
                                        <button class="btn btn-success refresh-button mr-1"> <i class="fas fa-sync"></i></button>
                                        <a href="{{ route('product.create') }}" class="btn btn-info">
                                            <i class="fa fa-plus"></i>
                                            Tạo mới
                                        </a>
                                    </div>

                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">STT</th>
                                            <th scope="col">Hình ảnh</th>
                                            <th scope="col">Tên</th>
                                            <th scope="col">Đơn giá chưa giảm</th>
                                            <th scope="col">Đơn giá bán</th>
                                            <th scope="col">Danh mục</th>

                                            <th scope="col">Trạng thái</th>
                                            <th scope="col">Tình trạng</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    @foreach($products as $key)
                                    <tbody>
                                        <tr id="sid{{$key -> id}}">
                                            <td width="5%"> {{ $key -> id}} </td>
                                            <td width=""><img src="{{ $key->image ? $key->image->path : 'null' }}" width="150px" alt=""></td>
                                            <td width="20%">{{ $key -> name}}</td>
                                            <td width="5%">{{ $key -> base_price}}</td>
                                            <td width="5%">{{ $key ->price}}</td>
                                            <td width="15%%">{{ $key->category->name}}</td>

                                            <td width="15%">
                                                @if($key->status == 0)
                                                <button type="button" class="btn btn-danger">Chưa kích hoạt</button>
                                                @elseif($key->status == 1)
                                                <button type="button" class="btn btn-primary">Kích hoạt</button>
                                                @endif
                                            </td>

                                            <td width="15%">
                                                @if($key->state == 0)
                                                <a type=" button" class="btn btn-danger">Hết hàng</a>
                                                @elseif($key->state == 1)
                                                <a type="button" class="btn btn-primary">Còn sản phẩm</a>
                                                @endif
                                            </td>

                                            <td width="20%">
                                                <a class="col-md-3 btn btn-primary " href="{{ route('product.edit',['id' => $key->id]) }}">Sửa</a>
                                                <button class="col-md-3 btn btn-danger deletelBanner" data-id="{{ $key->id }}" data-url="{{ route('banner.delete',['id' => $key->id])}}" href="">Xóa</button>
                                            </td>

                                        </tr>

                                    </tbody>
                                    @endforeach
                                </table>

                                <div class="container">
                                    <div class="d-flex justify-content-end mb-4 mr-4">
                                        {{ $products->links() }}
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
    $('.deletelBanner').on('click', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        if (confirm('Bạn có thực sự muốn xóa')) {
            $.ajax({
                method: 'GET',
                url: $(this).attr('data-url'),

                success: function(res) {
                    if (res.code == 0) {
                        toastr.warning(res.message);
                    };
                    if (res.code == 1) {

                        toastr.success(res.message);
                        $('#sid' + id).remove();



                    }
                }
            })
        }


    });
</script>

@endsection
