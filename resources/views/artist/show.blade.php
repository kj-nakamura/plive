@extends('layouts.app')

@include('layouts.header')

@section('content')
    <p>詳細ページ</p>
    <div class="row">
        <div class="col-md-3 border">
            <p>{{ $artist->name }}</p>
            <p>{{ $artist->content }}</p>
            <p><a href="{{ $artist->url }}">アーティストページへ</a></p>
            <img class="logo" src="/storage/{{ $artist->image }}" alt="logo" width="150px" height="150px">
        </div>
        <div class="border">
	        @foreach($artist->lives as $live)
	        	<p>{{ $live->title }}</p>
	        @endforeach
	    </div>
    </div>
@endsection

@include('layouts.footer')
