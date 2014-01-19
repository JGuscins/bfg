@extends('game.layout.index')

@section('content')
	<div class="start">
	    <div class="logo"></div>
	    <div class="profile-images">
	    	@foreach($users as $key => $item)
	    		<div id="@if($key == 0) first @elseif($key == 1) second @elseif($key == 2) third @else fourth @endif"><img src="{{ $item->photo }}"></div>
	    	@endforeach
	    </div>
		<div class="links">
			<a href="#" onclick="window.location.href='/login/fb/';"><img src="{{ URL::to('img/lets-play-bttn.png') }}"></a>
			<a id="invite" href="#"><img src="{{ URL::to('img/invite-friends-bttn.png') }}"></a>
		</div>
	</div>
@stop