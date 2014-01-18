<?php
Debugbar::enable();

//TEST
Route::any('test', 'TestController@index');
Route::any('testpost', 'TestController@post');

// GAME
Route::get('/', ['before' => 'auth', function() {
	$user = Auth::user();

    return View::make('game.intro.index')
    		->with('user', $user);
}]);

// QUESTION
Route::get('get-question', ['before' => 'auth', function() {

	// PROFILE PICTURE
	$q[0] = [
        'method' => 'fql.query',
        'query' => "SELECT uid, pic_big, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND pic LIMIT 4",
    ];

    // WORK
	$q[1] = [
        'method' => 'fql.query',
        'query' => "SELECT uid, work, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND work LIMIT 4",
    ];

    // EDUCATION
	$q[2] = [
        'method' => 'fql.query',
        'query' => "SELECT uid, education, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND education LIMIT 4",
    ];

    // BIRTHDAY
	$q[3] = [
        'method' => 'fql.query',
        'query' => "SELECT uid, birthday_date, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND birthday_date",
    ];


	$i = 0;
	while($i <= 9) {
		// RANDOM SELECTED TYPE OF QUESTION
		$random = rand(0,3);

		// EXECUTE QUERY
		$facebook = new Facebook(Config::get('facebook'));
		$data = $facebook->api($q[$random]);
		dd($data);

		// QUESTION ARRAY
		$q = [];

		// LOOP QUERY
		foreach($data as $key => $item) {
			if($random == 0) {
				// PROFILE PICTURE QUESTION
	    		$q['type'] = 'profile_picture';

	    		if(!empty($item['pic_big'])) {
	    			$q['items'][$key]['correct'] = 1;
	    			$q['question'] = 'Who owns this photo: <img src="https://graph.facebook.com/'.$item['uid'].'/picture?height=200" />';
	    			$q['items'][$key]['item'] = $item['pic_big'];
	    			$q['uid'] = $item['uid'];
	    		} else {
	    			$q['items'][$key]['correct'] = 0;
	    		}

	    		$q['items'][$key]['uid']  = $item['uid'];
	    		$q['items'][$key]['name'] = $item['name'];
			}

			if($random == 1) {
				// WORK QUESTION
	    		$q['type'] = 'work';

	    		if(!empty($item['work'])) {
	    			$q['items'][$key]['correct'] = 1;
	    			$q['question'] = 'Who works at: '.$item['work'][0]['employer']['name'];
	    			$q['items'][$key]['item'] = $item['work'][0]['employer']['name'];
	    			$q['uid'] = $item['uid'];
	    		} else {
	    			$q['items'][$key]['correct'] = 0;
	    		}

	    		$q['items'][$key]['uid']  = $item['uid'];
	    		$q['items'][$key]['name'] = $item['name'];
			}

			if($random == 2) {

			}
		}
	}



}]);
 
// AUTH
Route::get('login', function() {
	return View::make('game.intro.login');
});	


Route::get('login/fb', function() {
    $facebook = new Facebook(Config::get('facebook'));
    $params = [
        'redirect_uri' => url('/login/fb/callback'),
        'scope' => 'publish_stream, email, friends_about_me, friends_activities, friends_birthday, friends_education_history, friends_groups, friends_hometown, friends_interests, friends_likes, friends_location, friends_questions, friends_relationships, friends_relationship_details, friends_religion_politics, friends_subscriptions, friends_website, friends_work_history, friends_checkins, friends_events, friends_games_activity, friends_notes, friends_photos, friends_status, friends_videos',
    ];

    return Redirect::to($facebook->getLoginUrl($params));
});

Route::get('login/fb/callback', function() {
    $code = Input::get('code');

    if(strlen($code) == 0) {
    	return Redirect::to('/')
    			->with('message', 'There was an error communicating with Facebook');
    }
 
    $facebook = new Facebook(Config::get('facebook'));
    $facebook->setAccessToken("CAAH5ZBZCG8CIUBALSlFM3f50lbfzUo9KYkWmPZAEYZCOy8CmxbBsVDVTuMJ4ZCzeKv9aljvc4aR8gEvWxsOwg4GNSUM4uZAJpZC851hNZB2CSFpE0sDEUu5C3VoxcIbfgRcG3SW8ie0Ub0mMgDG9F3sWCsE3SeC0ZBAwmeSQAvyYat2tZAQyJUie7c7I0ZC7KwPvlwZD");
    $uid = $facebook->getUser();
 
    if($uid == 0) {
    	return Redirect::to('/')
    			->with('message', 'There was an error');
    }
 
    $me = $facebook->api('/me');
    dd($me);
    $friends = $facebook->api('/me/friends');
 
    $profile = Profile::whereUid($uid)->first();

    if (empty($profile)) {
        $user = new User;
        $user->name = $me['first_name'].' '.$me['last_name'];
        $user->email = $me['email'];
        $user->photo = 'https://graph.facebook.com/'.$me['username'].'/picture?type=large';
 
        $user->save();
 
        $profile = new Profile();
        $profile->uid = $uid;
        $profile->username = $me['username'];
        $profile->friends = json_encode($friends);
        $profile = $user->profiles()->save($profile);
    }
 
    $profile->access_token = $facebook->getAccessToken();
    $facebook->setExtendedAccessToken();
    $profile->access_token_secret = $facebook->getAccessToken();
    $profile->save();
 
    $user = $profile->user;
 
    Session::put('uid', $uid);

    Auth::login($user);
 
    return Redirect::to('/')
    		->with('message', 'Logged in with Facebook');
});

Route::get('logout', function() {
    Auth::logout();
    return Redirect::to('/');
});