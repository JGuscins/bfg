@extends('game.layout.index')

@section('content')
		{{ Form::open(array('url' => '/testpost', 'method' => 'POST')); }}
		<label>Jautājums</label>
		{{ Form::text('firstpost'); }}
		{{ Form::submit('Aiziet'); }}
		{{ Form::close(); }}
@stop