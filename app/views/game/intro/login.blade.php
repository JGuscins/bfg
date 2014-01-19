@extends('game.layout.index')

@section('content')
	<div class="start">
	    <div class="logo"></div>
	    <div class="profile-images">
	    	<div id="first"><img src="{{ URL::to('img/placeholder-dude.jpg') }}"></div>
	    	<div id="second"><img src="{{ URL::to('img/placeholder-dude.jpg') }}"></div>
	    	<div id="third"><img src="{{ URL::to('img/placeholder-dude.jpg') }}"></div>
	    	<div id="fourth"><img src="{{ URL::to('img/placeholder-dude.jpg') }}"></div>
	    </div>
		<div class="links">
			<a href="#" onclick="window.location.href='/login/fb/';"><img src="{{ URL::to('img/lets-play-bttn.png') }}"></a>
			<a href="#"><img src="{{ URL::to('img/invite-friends-bttn.png') }}"></a>
		</div>
	</div>
@stop