<?php

class TestController extends BaseController {

	public function index()
	{
$link = "http://images.google.com/images?q=flying&tbm=isch";
$code = file_get_contents($link,'r');

preg_match ("imgurl=http://www.[A-Za-z0-9-]*.[A-Za-z]*[^.]*.[A-Za-z]*", $code, $img);
preg_match ("http://(.*)", $img[0], $img_pic);

$firstImage = $img_pic[0];
$firstImage = trim("$firstImage");
echo "$firstImage<br><br>";

// Display image
echo "<img src=\"$firstImage\">";
	}
	
	public function post() {
		$shit = Input::get('firstpost');
		if (!empty($shit))
			App::abort(404);
	}
}