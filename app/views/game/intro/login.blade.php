@extends('game.layout.index')

@section('content')
	<div class="start">
	    <div class="logo"></div>
	    <div class="profile-images">
	    	@foreach($users as $key => $item)
	    		@if($key == 0)
	    			<div id="first"><img src="{{ str_replace('?type=large', '?width=500&height=500&redirect=false', $item->photo) }}"></div>
	    		@endif

	    		@if($key == 1)
	    			<div id="second"><img src="{{ str_replace('?type=large', '?width=500&height=500&redirect=false', $item->photo) }}"></div>
	    		@endif

	    		@if($key == 2)
	    			<div id="third"><img src="{{ str_replace('?type=large', '?width=500&height=500&redirect=false', $item->photo) }}"></div>
	    		@endif

	    		@if($key == 3)
	    			<div id="fourth"><img src="{{ str_replace('?type=large', '?width=500&height=500&redirect=false', $item->photo) }}"></div>
	    		@endif
	    	@endforeach
	    </div>
		<div class="links">
			<a href="#" onclick="window.location.href='/login/fb/';"><img src="{{ URL::to('img/lets-play-bttn.png') }}"></a>
			<a id="invite" href="#"><img src="{{ URL::to('img/invite-friends-bttn.png') }}"></a>
		</div>
	</div>
@stop