@extends('game.layout.index')

@section('content')
	<div class="start">
	    <div class="logo"></div>
	    <div class="profile-images">
	    	@foreach($users as $key => $item)
	    		@if($key == 0)
	    			<div id="first"><img src="{{ str_replace('?type=large', '?width=500&height=500', $item->photo) }}"></div>
	    		@endif

	    		@if($key == 1)
	    			<div id="second"><img src="{{ str_replace('?type=large', '?width=500&height=500', $item->photo) }}"></div>
	    		@endif

	    		@if($key == 2)
	    			<div id="third"><img src="{{ str_replace('?type=large', '?width=500&height=500', $item->photo) }}"></div>
	    		@endif

	    		@if($key == 3)
	    			<div id="fourth"><img src="{{ str_replace('?type=large', '?width=500&height=500', $item->photo) }}"></div>
	    		@endif
	    	@endforeach
	    </div>
		<div class="links" style="display: none;">
			<a href="#" onclick="window.location.href='/login/fb/';"><img src="{{ URL::to('img/lets-play-bttn.png') }}"></a>
			<a id="invite" href="#"><img src="{{ URL::to('img/invite-friends-bttn.png') }}"></a>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.links').animate({'opacity':0.1},250).slideDown(500).fadeIn(1500,function(){ $(this).animate({'opacity':1},500); });
		});
	</script>
@stop