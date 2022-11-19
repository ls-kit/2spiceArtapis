@if (count($uploads)>0)
    <ul class="list-group">
        @foreach ($uploads as $item)
            <a href="{{route('singleVideo', $item->id)}}" class="list-group-item">{{$item->name}}</a>
        @endforeach
    </ul>
@else
    <div class="text-center" style="background:white">
        <p class="py-3" style="box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px; padding:10px 0">
            sorry,nothing found "{{$keyword}}"</p>
    </div>
@endif
