<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public static function search_image($url) {
		$url = 'http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q='.$url;

	    $crl = curl_init();

	    curl_setopt($crl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
	    curl_setopt($crl, CURLOPT_URL, $url);
	    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, 5);

	    $ret = curl_exec($crl);
	    curl_close($crl);

	    $data = json_decode($ret);

		foreach ($data->responseData->results as $key => $result) {
			if($key == 0) {
				return $result->url;
			}
		}
	}

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}