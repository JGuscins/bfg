<?php

// GAME
Route::group(['before' => 'auth'], function(){
	Route::any('/', function() {
		return View::make('game.intro.index');
	});
});

// AUTH
Route::group(['prefix' => 'authorize'], function(){
	Route::any('/', function() {
		return View::make('game.authorize.login');
	});
});