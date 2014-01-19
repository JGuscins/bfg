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
							$level = round($coint/100);

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
	    		<img id="question-image" src="img/placeholder-dude.jpg">
	    		</div>
	    	</div>
	    	<div class="col">
	    	<div class="heading">Question:</div>
	    	<h1 id="question"></h1>
	    	</div>
	    </div>
	    <div class="answers">
	    	<a id="q1" data-uid="" href="#"><span class="first-name"></span><br>
	    	<span class="last-name"></span> <span><img class="profile-image" src="img/placeholder-dude.jpg"></span></a>
	    	<a id="q2" data-uid="" href="#"><span class="first-name"></span><br>
	    	<span class="last-name"></span> <span><img class="profile-image" src="img/placeholder-dude.jpg"></span></a>
	    	<a id="q3" data-uid="" href="#"><span class="first-name"></span><br>
	    	<span class="last-name"></span> <span><img class="profile-image" src="img/placeholder-dude.jpg"></span></a>
	    	<a id="q4" data-uid="" href="#"><span class="first-name"></span><br>
	    	<span class="last-name"></span> <span><img class="profile-image" src="img/placeholder-dude.jpg"></span></a>
	    </div>
	    <div class="footer">
		    <div class="game-progress">
		    	<div class="step">1/10</div>
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

@stop