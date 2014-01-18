@extends('game.layout.index')

@section('content')
<<<<<<< HEAD
	{{ Form::open(array('url' => 'foo/bar', 'method' => 'PUT')); }}
=======
		{{ Form::open(array('url' => '/testpost', 'method' => 'POST')); }}
		<label>Jautājums</label>
		{{ Form::text('firstpost'); }}
		{{ Form::submit('Aiziet'); }}
		{{ Form::close(); }}
>>>>>>> 0fed61e0a957999c6c47c6761c48d004d8cd286f
@stop