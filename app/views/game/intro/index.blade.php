@extends('game.layout.index')

@section('content')
<div class="quiz">
    <div class="header">
	    <div class="stats">
	    	<div class="time">
	    		<div class="frame">
	    		</div>
	    		<div class="progress-br">
					<div style="-webkit-animation: mymove 25s infinite linear;" class="progress-br-color"></div>
	    		</div>
	    	</div>
			<div class="coins">
				<div class="frame">
					<span>
						<?php
							$points = Auth::user()->points;
							$level = $points/100;
							$level = round($level);

							if($points > 100) {
								$real = $points-100;
							} else {
								$real = $points;
							}

							$level = $level+1;

							echo $level;
						?>
					</span>
				</div>
				<div class="progress-br">
					<div style="width: {{ $real }}px;" class="progress-br-color"></div>
				</div>
			</div>
	    	<div class="money">
	    		<div class="count">{{ Auth::user()->coins }}</div>
	    		<a class="add-more" href="#"></a>
	    	
	    	</div>
	    	<div class="diamonds">
	    	<div class="count">{{ Auth::user()->points }}</div>
	    	</div> 
	    </div>
	    <div class="options">
	    	<a id="50-50" class="fifty-fifty" href="#"><span>1</span></a>
	    	<a id="stop-time" class="stop-time" href="#"><span>1</span></a>
	    	<a id="change-question" class="change-q" href="#"><span>1</span></a>
	    	<a id="show-answer" class="show-ans" href="#"><span>3</span></a>
	    </div>
    </div>
    <div class="body">  
	    <div class="question">
	    	<div class="visual">
	    		<div class="border">
	    			@if($question['type'] == "Music" || $question['type'] == "Movie" || $question['type'] == "Book")
	    				<img id="question-image" src="{{ $question['image'] }}">
	    			@elseif($question['type'] == "Picture")
	    				<img id="question-image" src="{{ $question['question'] }}">
	    			@else
	    				<img id="question-image" src="http://www.sylvain-lader.fr/wp-content/uploads/2012/07/placeholder.jpg">
	    			@endif
	    		</div>
	    	</div>
	    	<div class="col">
	    	<div class="heading">Question:</div>
	    	<h1 id="question">
	    		@if($question['type'] != "Picture")
	    			{{ $question['title'] }} {{ $question['question'] }}?
	    		@else
	    			{{ $question['title'] }}
	    		@endif
	    	</h1>
	    	</div>
	    </div>
	    <div class="answers">
	    	@foreach($question['answers'] as $key => $item)
	    		<?php 
	    			$name = explode(' ', $item['name']);
	    			$first_name = $name[0];
	    			$last_name = $name[1];
	    		?>
				<a id="q{{ $key+1 }}" data-id="{{ $key+1 }}" data-uid="{{ $item['uid'] }}" href="#">{{ $first_name }}<br>
	    		{{ $last_name }} <span><img class="profile-image" src="{{ str_replace('?type=large', '?width=500&height=500', $item['picture']) }}"></span></a>
	    	@endforeach
	    </div> 
	    <div class="footer">
		    <div class="game-progress">
		    	<div class="step"><span>{{ Session::get('step', 1) }}</span>/10</div>
		    	<div class="bites">
		    		<span id="a1" class=""></span>
		    		<span id="a2" class=""></span>
		    		<span id="a3" class=""></span>
		    		<span id="a4" class=""></span>
		    		<span id="a5" class=""></span>
		    		<span id="a6" class=""></span>
		    		<span id="a7" class=""></span>
		    		<span id="a8" class=""></span>
		    		<span id="a9" class=""></span>
		    		<span id="a10" class=""></span>
		    	</div>
		    </div>
		    <div class="menu"></div>
	    </div>
	</div>	
</div>
@stop