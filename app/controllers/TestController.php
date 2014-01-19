<?php

class TestController extends BaseController {

	public function index()
	{
		$json = get_url_contents('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=korn');

		$data = json_decode($json);

		foreach ($data->responseData->results as $result) {
		    $results[] = array('url' => $result->url, 'alt' => $result->title);
		}

		dd($result);
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if (!empty($shit))
			App::abort(404);
	}
}