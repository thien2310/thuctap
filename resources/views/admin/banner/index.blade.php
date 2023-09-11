@extends('layouts.main')

@section('content')

@section('name')

Banner

@endsection


<div class="row">
    <div class="col-12">
        <div class="card customize-card customize-card-2">
            <div class="card-header card-header-page-title">
                <h3>Quản lý banner</h3>
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
                                        <a href="{{ route('banner.create') }}" class="btn btn-info">
                                            <i class="fa fa-plus"></i>
                                            Tạo mới
                                        </a>
                                    </div>

                                </div>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">stt</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Intro</th>
                                            <th scope="col">Status</th>
                                            <th>created_at</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    @foreach($banner as $key)
                                    <tbody>
                                        <tr id="sid{{$key -> id}}">
                                            <td> {{ $key -> id}} </td>
                                            <td>{{ $key -> name}}</td>
                                            <td>{!! $key -> intro !!}</td>
                                            <th>
                                                @if($key->status == 0)
                                                <button type="button" class="btn btn-danger">Chưa kích hoạt</button>
                                                @elseif($key->status == 1)
                                                <button type="button" class="btn btn-primary">Kích hoạt</button>
                                                @endif

                                            </th>
                                            <td>{{ $key->created_at }}</td>
                                            <td width=270>
                                                <a class="col-md-3 btn btn-primary " href="{{ route('banner.edit',['id' => $key->id]) }}">Sửa</a>
                                                <button class="col-md-3 btn btn-danger deletelBanner" data-id="{{ $key->id }}" data-url="{{ route('banner.delete',['id' => $key->id])}}" href="">Xóa</button>
                                            </td>

                                        </tr>

                                    </tbody>
                                    @endforeach
                                </table>
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
