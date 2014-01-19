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
		<span>3</span>
	</div>
	<div class="progress-br">
		    		<div style="-webkit-animation: mymove 25s infinite linear;" class="progress-br-color"></div>
	</div>
</div>
	    	<div class="money">
	    		<div class="count">25</div>
	    		<a class="add-more" href="#"></a>
	    	
	    	</div>
	    	<div class="diamonds">
	    	<div class="count">3012</div>
	    	</div>
	    </div>
	    
	    
	    
	    
	    <div class="options">
	    	<a class="fifty-fifty" href="#"><span>1</span></a>
	    	<a class="stop-time" href="#"><span>1</span></a>
	    	<a class="change-q" href="#"><span>1</span></a>
	    	<a class="show-ans" href="#"><span>3</span></a>
	    
	    
	    </div>
    </div>
    <div class="body">
	    <div class="question">
	    	<div class="visual">
	    		<div class="border">
	    		<img src="img/placeholder-dude.jpg">
	    		</div>
	    	</div>
	    	<div class="col">
	    	<div class="heading">Question:</div>
	    	<h1 class="">Who read book Harry Potter and the Order of the Phoenix?</h1>
	    	</div>
	    </div>
	    <div class="answers">
	    	<a href="#">Andrejs<br>
	    	Konstantins <span><img src="img/placeholder-dude.jpg"></span></a>
	    	<a href="#">Andrejs<br>
	    	Konstantins <span><img src="img/placeholder-dude.jpg"></span></a>
	    	<a href="#">Andrejs<br>
	    	Konstantins <span><img src="img/placeholder-dude.jpg"></span></a>
	    	<a href="#">Andrejs<br>
	    	Konstantins <span><img src="img/placeholder-dude.jpg"></span></a>
	    
	    </div>

    <div class="footer">
	    <div class="game-progress">
	    	<div class="step">2/10</div>
	    	<div class="bites">
	    		<span class="right"></span>
	    		<span class="wrong"></span>
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