<?php

class TestController extends BaseController {

	public function index()
	{
		return View::make('game.intro.test');
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if ($shit == "whatevers")
			dd("Ir.");
	}
}