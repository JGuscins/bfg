@extends('game.layout.index')

@section('content')
    Hello, {{{ $user['name'] }}} 
    <br>
    <img src="{{ $user['photo']}}">
    <br>
    Your email is {{ $user['email']}}
    <br>
    <a href="logout">Logout</a>
@stop