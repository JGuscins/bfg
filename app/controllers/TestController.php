<?php

class TestController extends BaseController {

	public function index()
	{
		return View::make('game.intro.test');
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if (!empty($shit))
			App::abort(404);
	}
}