@extends('game.layout.index')

@section('content')
	{{ Form::open(array('url' => 'foo/bar', 'method' => 'PUT')); }}
@stop