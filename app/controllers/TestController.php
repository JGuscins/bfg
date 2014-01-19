<?php

class TestController extends BaseController {
 
	public function index()
	{
		$test = Book::::select(DB::raw('WHERE `id` IN (SELECT `id` FROM `profiles` WHERE `employer_1` NOT LIKE '.addslashes($q['question']).' AND `friends` LIKES "%%,\"id\":\"'.Session::get('uid').'\"}%%")'));
		dd($test);
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if (!empty($shit))
			App::abort(404);
	}
}