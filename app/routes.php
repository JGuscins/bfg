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
Route::group(['prefix' => 'ajax'], function() {
    Route::get('profile', function() {
        // PROFILE PICTURE
        $query = [ 
            'method' => 'fql.query',
            'query' => "SELECT uid, pic_big, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND pic",
        ];

        // FACEBOOK
        $facebook = new Facebook(Config::get('facebook'));
        $data = $facebook->api($query);
        dd($data);
    });

    Route::get('work', function() {
        // WORK
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, work, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND work",
        ];
    }); 

    Route::get('education', function() {
        // EDUCATION
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, education, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND education",
        ];
    });

    Route::get('birthday', function() {
        // BIRTHDAY
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, birthday_date, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND birthday_date",
        ];
    });

    Route::get('books', function() {
        // BOOKS
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, books, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND books",
        ];
    });

    Route::get('music', function() {
        // MUSIC
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, music, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND music",
        ];
    });

    Route::get('movies', function() {
        // MOVIES
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, movies, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND movies",
        ];
    });

    Route::get('interests', function() {
        // INTERESTS
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, interests, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND interests",
        ];
    });
});
 
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
    $uid = $facebook->getUser();
 
    if($uid == 0) {
        return Redirect::to('/')
                ->with('message', 'There was an error');
    }
 
    $me = $facebook->api('/me');
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