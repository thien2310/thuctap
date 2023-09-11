@if(count($result) > 0 )

@foreach($result as $item)
<li class="list-group-item "><a class="text-decoration-none" href="{{ route('categories.find',['id' => $item->id]) }}"> {{ $item->name }}</a></li>
@endforeach
 
@else
<li class="list-group-item"><a class="text-decoration-none" href=""> không có kết quả</a></li>
@endif
