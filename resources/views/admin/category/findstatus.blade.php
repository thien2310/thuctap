@if(count($resultt) > 0)

@foreach($resultt as $value)


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

@endforeach


@endif
