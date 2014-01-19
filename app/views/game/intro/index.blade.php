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
							$coins = Auth::user()->coins;
							$level = round($coins/100);

							echo $level;
						?>
					</span>
				</div>
				<div class="progress-br">
					<div style="-webkit-animation: mymove 25s infinite linear;" class="progress-br-color"></div>
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
	    			@else
	    				<img id="question-image" src="img/placeholder-dude.jpg">
	    			@endif
	    		</div>
	    	</div>
	    	<div class="col">
	    	<div class="heading">Question:</div>
	    	<h1 id="question">
	    		{{ $question['title'] }} {{ $question['question'] }}?
	    	</h1>
	    	</div>
	    </div>
	    <div class="answers">
	    	@foreach($q['answers'] as $key => $item)
	    		<?php 
	    			$name = explode(' ', $item['name']);
	    			$first_name = $name[0];
	    			$last_name = $name[1];
	    		?>
				<a id="q{{ $key }}" data-uid="" href="#"><span class="first-name">{{ $first_name }}</span><br>
	    		<span class="last-name">{{ $last_name }}</span> <span><img class="profile-image" src="{{ str_replace('?type=large', '?width=500&height=500', $item['pictrue']) }}"></span></a>
	    	@endforeach
	    </div>
	    <div class="footer">
		    <div class="game-progress">
		    	<div class="step">{{ Session::get('level', 1) }}/10</div>
		    	<div class="bites">
		    		<span></span>
		    		<span></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    		<span class=""></span>
		    	</div>
		    </div>
		    <div class="menu"></div>
	    </div>
	</div>	
</div>
{{ var_dump($question) }}
@stop