<?php

class TestController extends BaseController {

	public function index()
	{
		return View::make('game.intro.test');
	}
}