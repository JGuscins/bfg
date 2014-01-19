<?php

class TestController extends BaseController {
 
	public function index()
	{
		$image = BaseController::search_image('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=korn');
		dd($image);
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if (!empty($shit))
			App::abort(404);
	}
}