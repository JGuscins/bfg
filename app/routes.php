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

// GET QUESTION
Route::get('get-question', function() {
    $friends = Profile::where('uid', Session::get('uid'))->first();
    $friends = json_decode($friends->friends);

    dd($friends);

});

// QUESTION
Route::group(['prefix' => 'ajax'], function() {
    Route::get('profile', function() {
        // PROFILE PICTURE
        $query = [ 
            'method' => 'fql.query',
            'query' => "SELECT uid, pic_big, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND pic",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Picture::where('id', $item['uid'])->first();

            if(!$user) {
                $p = new Picture;
            } else {
                $p = Picture::where('id', $item['uid'])->first();
            }

            $p->id = $item['uid'];
            $p->url = $item['pic_big'];
            $p->save();
        }

        // RESPOND TO AJAX
        return Response::json('true');
    });

    Route::get('work', function() {
        // WORK
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, work, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND work",
        ];


        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Employment::where('id', $item['uid'])->first();

            if(!$user) {
                $e = new Employment;
            } else {
                $e = Employment::where('id', $item['uid'])->first();;
            }

            $e->id = $item['uid'];

            if(isset($item['work'][0])) {
                $e->employer_1 = $item['work'][0]['employer']['name'];
            }

            if(isset($item['work'][1])) {
                $e->employer_2 = $item['work'][1]['employer']['name'];
            }

            if(isset($item['work'][2])) {
                $e->employer_3 = $item['work'][2]['employer']['name'];
            }

            $e->save();
        }

        // RESPOND TO AJAX
        return Response::json('true');
    }); 

    Route::get('education', function() {
        // EDUCATION
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, education, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND education",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Education::where('id', $item['uid'])->first();

            if(!$user) {
                $e = new Education;
            } else {
                $e =  Education::where('id', $item['uid'])->first();;
            }

            $e->id = $item['uid'];

            if(isset($item['education'][0])) {
                $e->school_1_name = $item['education'][0]['school']['name'];
                $e->school_1_id = $item['education'][0]['school']['id'];
                $e->school_1_type = $item['education'][0]['type'];
            }

            if(isset($item['education'][1])) {
                $e->school_2_name = $item['education'][1]['school']['name'];
                $e->school_2_id = $item['education'][1]['school']['id'];
                $e->school_2_type = $item['education'][1]['type'];
            }

            if(isset($item['education'][2])) {
                $e->school_3_name = $item['education'][2]['school']['name'];
                $e->school_3_id = $item['education'][2]['school']['id'];
                $e->school_3_type = $item['education'][2]['type'];
            }

            $e->save();    
        }

        // RESPOND TO AJAX
        return Response::json('true');
    });

    Route::get('birthday', function() {
        // BIRTHDAY
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, birthday_date, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND birthday_date",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Birthdate::where('id', $item['uid'])->first();

            if(!$user) {
                $p = new Birthdate;
            } else {
                $p = Birthdate::where('id', $item['uid'])->first();
            }

            $bday = explode('/', $item['birthday_date']);
            $bday = $bday[0].'/'.$bday[1];

            $p->id = $item['uid'];
            $p->birthdate = $bday;
            $p->save();
        }

        // RESPOND TO AJAX
        return Response::json('true');
    });

    Route::get('books', function() {
        // BOOKS
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, books, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND books",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Book::where('id', $item['uid'])->first();

            if(!$user) {
                $b = new Book;
            } else {
                $b = Book::where('id', $item['uid'])->first();
            }

            $b->id = $item['uid'];
            $b->book = $item['books'];
            $b->save();
        }

        // RESPOND TO AJAX
        return Response::json('true');
    });

    Route::get('music', function() {
        // MUSIC
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, music, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND music",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Music::where('id', $item['uid'])->first();

            if(!$user) {
                $m = new Music;
            } else {
                $m = Music::where('id', $item['uid'])->first();
            }

            $m->id = $item['uid'];
            $m->music = $item['music'];
            $m->save();
        }


        // RESPOND TO AJAX
        return Response::json('true');
    });

    Route::get('movies', function() {
        // MOVIES
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, movies, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND movies",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Movie::where('id', $item['uid'])->first();

            if(!$user) {
                $m = new Movie;
            } else {
                $m = Movie::where('id', $item['uid'])->first();
            }

            $m->id = $item['uid'];
            $m->movies = $item['movies'];
            $m->save();
        }

        // RESPOND TO AJAX
        return Response::json('true');
    });

    Route::get('interests', function() {
        // INTERESTS
        $query = [
            'method' => 'fql.query',
            'query' => "SELECT uid, interests, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = ".Session::get('uid')." ORDER BY rand()) AND interests",
        ];

        // FACEBOOK DATA
        $facebook = new Facebook(Config::get('facebook'));
        $data     = $facebook->api($query);

        // STORE DATA
        foreach($data as $item) {
            $user = Interest::where('id', $item['uid'])->first();

            if(!$user) {
                $i = new Interest;
            } else {
                $i = Interest::where('id', $item['uid'])->first();
            }

            $i->id = $item['uid'];
            $i->interests = $item['interests'];
            $i->save();
        }

        // RESPOND TO AJAX
        return Response::json('true');
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