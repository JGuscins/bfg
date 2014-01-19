<?php

class TestController extends BaseController {
 
	public function index()
	{
		function search_image($url) {
		    $crl = curl_init();

		    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
		    curl_setopt($crl, CURLOPT_URL, $url);
		    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

		    $ret = curl_exec($crl);
		    curl_close($crl);

		    $data = json_decode($ret);

			foreach ($data->responseData->results as $key => $result) {
				$if($key == 0) {
					return array('url' => $result->url);
				}
			}
		}

		$image = search_image('http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=korn');
		dd($image);
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if (!empty($shit))
			App::abort(404);
	}
}