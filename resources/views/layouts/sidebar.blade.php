@section('sidebar')
    <div class="py-4">
        @foreach ($tags as $tag)
            <form name="tags" method="get" action="{{ route('artist.index') }}">
                <li style="list-style: none;">
                    <input type="hidden" name="tag" value="{{ $tag->id }}">
                    <a href="javascript:tags[{{ $index }}].submit()">{{ $tag->title }}</a>
                </li>
            </form>
            @php $index++ @endphp
        @endforeach
    </div>
@endsection
