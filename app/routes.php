<?php
//TEST
Route::any('test', 'TestController@index');
Route::any('testpost', 'TestController@post');

// GAME
Route::any('/', ['before' => 'auth', function() {
    // RANDOM CATEGORY
    $random = rand(0,7);
    $c = ['Picture', 'Employment', 'Education', 'Birthdate', 'Book', 'Music', 'Movie', 'Interest'];
    $c_table = ['url', 'employer_1', 'school_1_name', 'birthdate', 'book', 'music', 'movies', 'interests'];
    $c_question = ['Picture:', 'Employment:', 'Education:', 'Birthdate:', 'Book:', 'Music:', 'Movie:', 'Interest:'];
    $category = $c[$random];

    // GET CORRECT ANSWER
    $question = $category::where($c_table[$random], '!=', '')->orderBy(DB::raw('RAND()'))->first();

    // GET CORRECT ANSWER UID
    $q['uid'] = $question->id;
    $q['type'] = $category;
    $q['name'] = json_decode(file_get_contents('http://graph.facebook.com/'.$q['uid'].'?fields=name'))->name;
    $q['picture'] = 'https://graph.facebook.com/'.$q['uid'].'/picture?type=large';

    if($category == "Picture") {
        // QUESTION ABOUT PROFILE PICTURE
        $q['title'] = $c_question[$random];
        $q['question'] = $question->url;

        // ANSWERS
        $q['answers'] = $category::where('url', '!=', $q['question'])->take(3)->get();
    } elseif($category == "Employment") {
        $q['title'] = $c_question[$random];

        if($question->employer_3 != '') {
            $r = rand(1,3);

            if($r == 1)
            {
                $q['question'] = $question->employer_1;
                // ANSWERS
/*                 $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get(); */
                
                $q['answer'] = $category::select(DB::raw('WHERE `id` IN (SELECT `id` FROM `profiles` WHERE `employer_1` NOT LIKE '.addslashes($q['question']).' AND `friends` LIKE "%%,\"id\":\"'.Session::get('uid').'\"}%%")'));
            }
            elseif($r == 2)
            {
                $q['question'] = $question->employer_2;
                // ANSWERS
/*                 $q['answers'] = $category::where(DB::raw('`employer_2`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get(); */
            } else {
                $q['question'] = $question->employer_3;
                // ANSWERS
/*                 $q['answers'] = $category::where(DB::raw('`employer_3`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get(); */
                
                $q['answer'] = $category::select(DB::raw('WHERE `id` IN (SELECT `id` FROM `profiles` WHERE `employer_3` NOT LIKE '.addslashes($q['question']).' AND `friends` LIKE "%%,\"id\":\"'.Session::get('uid').'\"}%%")'));
            }
        } elseif($question->employer_2 != '') {
            $r = rand(1,2);

            if($r == 1) {
                $q['question'] = $question->employer_1;
                // ANSWERS
/*                 $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get(); */
                
                $q['answer'] = $category::select(DB::raw('WHERE `id` IN (SELECT `id` FROM `profiles` WHERE `employer_1` NOT LIKE '.addslashes($q['question']).' AND `friends` LIKE "%%,\"id\":\"'.Session::get('uid').'\"}%%")'));
            } else {
                $q['question'] = $question->employer_2;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_2`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                
                $q['answer'] = $category::select(DB::raw('WHERE `id` IN (SELECT `id` FROM `profiles` WHERE `employer_1` NOT LIKE '.addslashes($q['question']).' AND `friends` LIKE "%%,\"id\":\"'.Session::get('uid').'\"}%%")'));       
            }
        } else {
            $q['question'] = $question->employer_1;
            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        }
    } elseif($category == "Education") {
        $q['title'] = $c_question[$random];

        if($question->school_3_name != '') {
            $r = rand(1,3);

            if($r == 1) {
                $q['question'] = $question->school_1_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } elseif($r == 2) {
                $q['question'] = $question->school_2_name;
                // school_2_name
                $q['answers'] = $category::where(DB::raw('`school_2_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } else {
                $q['question'] = $question->school_3_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_3_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } elseif($question->school_2_name != '') {
            $r = rand(1,2);

            if($r == 1) {
                $q['question'] = $question->school_1_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } else {
                $q['question'] = $question->school_2_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_2_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } else {
            $q['question'] = $question->school_1_name;
            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        }
    } elseif($category == "Birthdate") {
        $q['title'] = $c_question[$random];
        $q['question'] = $question->birthdate;
        // ANSWERS
        $q['answers'] = $category::where('birthdate', '!=', $q['question'])->take(3)->get();
    } elseif($category == "Book") {
        $q['title'] = $c_question[$random];

        $books = explode(', ', $question->book);
        $segments = count($books)-1;

        $r = rand(0, $segments);

        $q['question'] = $books[$r];
        $q['image'] = BaseController::search_image('book '.$books[$r]);

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`book`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    } elseif($category == "Music") {
        $q['title'] = $c_question[$random];

        $music = explode(', ', $question->music);
        $segments = count($music)-1;

        $r = rand(0, $segments);

        $q['question'] = $music[$r];
        $q['image'] = BaseController::search_image('music '.$music[$r]);

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`music`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    } elseif($category == "Movie") {
        $q['title'] = $c_question[$random];

        $movies = explode(', ', $question->movies);
        $segments = count($movies)-1;

        $r = rand(0, $segments);

        $q['question'] = $movies[$r];
        $q['image'] = BaseController::search_image('movie '.$movies[$r]);

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`movies`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    } elseif($category == "Interest") {
        $q['title'] = $c_question[$random];

        $interests = explode(', ', $question->interests);
        $segments = count($interests)-1;

        $r = rand(0, $segments);

        $q['question'] = $interests[$r];

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`interests`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    }


    // GET ANSWER
    foreach($q['answers'] as $answer) {
        $a['answers'][] = [
            'uid' => $answer['id'], 
            'name' => json_decode(file_get_contents('http://graph.facebook.com/'.$answer['id'].'?fields=name'))->name, 
            'picture' => 'https://graph.facebook.com/'.$answer['id'].'/picture?type=large',
        ];
    }

    $q['answers'] = $a['answers'];
    $q['answers'][] = ['uid' => $q['uid'], 'name' => $q['name'], 'picture' => $q['picture']];
    
    // STORE CORRECT UID
    Session::put('correct_uid', $q['uid']);
    Session::put('answers', $q['answers']);

    // LEVEL
    if(Session::get('step')) {
        $step = Session::get('step');
        if($step == 10) {
            Session::put('step', 1);

            $user = User::find(Auth::user()->id);

            if($user->quiz == 0) {
                $badge = New Badge();
                $badge->badge = "first_quiz";
                $badge = $user->badges()->save($badge);

                $user->quiz = 1;
                $user->save();

                $profile = Profile::where('uid', Session::get('uid'))->first();

                $facebook = new Facebook(Config::get('facebook'));
                $facebook->setAccessToken($profile->access_token);

                $facebook->api('/me/feed', 'post', array(
                    'message' => 'Hell yeah! Just passed my first Best Friends Game quiz and challenge! So cool... Come and try it!',
                    'name' => 'Best Friend Game',
                    'picture' => 'https://graph.facebook.com/guscins/picture?type=large',
                    'link' => 'http://apps.facebook.com/bestfriendsgameapp/',
                ));

            }

        } else {
            $step = $step+1;
            Session::put('step', $step);
        }
    } else {
        Session::put('step', 1);
    }

    return View::make('game.intro.index')
            ->with('question', $q);
}]);

Route::get('stop-timer', function() {
    $price = 1; 
    
    $user = User::find(Auth::user()->id);

    if($user->coins >= $price) {
        $coins = $user->coins;
        $user->coins = $coins-$price;
        $user->save();

        return Response::json('true');
    } else {
        return Response::json('false');
    }
});

Route::get('get-answer', function() {
    $price = 3;
    $user = User::find(Auth::user()->id);
    $q['coins'] = $user->coins;
    $q['points'] = $user->points;

    if($user->coins >= $price) {
        $coins = $user->coins;
        $user->coins = $coins-$price;
        $user->save();

        return Response::json(Session::get('correct_uid'));
    } else {
        return Response::json('false');
    }
});

Route::get('switch-question', function() {
    $price = 1;
    $user = User::find(Auth::user()->id);
    $q['coins'] = $user->coins;
    $q['points'] = $user->points;

    if($user->coins >= $price) {
        $coins = $user->coins;
        $user->coins = $coins-$price;
        $user->save();

        $q['coins'] = $q['coins']-$price;

        // RANDOM CATEGORY
        $random = rand(0,7);
        $c = ['Picture', 'Employment', 'Education', 'Birthdate', 'Book', 'Music', 'Movie', 'Interest'];
        $c_table = ['url', 'employer_1', 'school_1_name', 'birthdate', 'book', 'music', 'movies', 'interests'];
        $c_question = ['Picture:', 'Employment:', 'Education:', 'Birthdate:', 'Book:', 'Music:', 'Movie:', 'Interest:'];
        $category = $c[$random];

        // GET CORRECT ANSWER
        $question = $category::where($c_table[$random], '!=', '')->orderBy(DB::raw('RAND()'))->first();

        // GET CORRECT ANSWER UID
        $q['uid'] = $question->id;
        $q['type'] = $category;
        $q['name'] = json_decode(file_get_contents('http://graph.facebook.com/'.$q['uid'].'?fields=name'))->name;
        $q['picture'] = 'https://graph.facebook.com/'.$q['uid'].'/picture?type=large';

        if($category == "Picture") {
            // QUESTION ABOUT PROFILE PICTURE
            $q['title'] = $c_question[$random];
            $q['question'] = $question->url;

            // ANSWERS
            $q['answers'] = $category::where('url', '!=', $q['question'])->take(3)->get();
        } elseif($category == "Employment") {
            $q['title'] = $c_question[$random];

            if($question->employer_3 != '') {
                $r = rand(1,3);

                if($r == 1) {
                    $q['question'] = $question->employer_1;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                } elseif($r == 2) {
                    $q['question'] = $question->employer_2;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`employer_2`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                } else {
                    $q['question'] = $question->employer_3;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`employer_3`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                }
            } elseif($question->employer_2 != '') {
                $r = rand(1,2);

                if($r == 1) {
                    $q['question'] = $question->employer_1;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                } else {
                    $q['question'] = $question->employer_2;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`employer_2`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                }
            } else {
                $q['question'] = $question->employer_1;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } elseif($category == "Education") {
            $q['title'] = $c_question[$random];

            if($question->school_3_name != '') {
                $r = rand(1,3);

                if($r == 1) {
                    $q['question'] = $question->school_1_name;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                } elseif($r == 2) {
                    $q['question'] = $question->school_2_name;
                    // school_2_name
                    $q['answers'] = $category::where(DB::raw('`school_2_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                } else {
                    $q['question'] = $question->school_3_name;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`school_3_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                }
            } elseif($question->school_2_name != '') {
                $r = rand(1,2);

                if($r == 1) {
                    $q['question'] = $question->school_1_name;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                } else {
                    $q['question'] = $question->school_2_name;
                    // ANSWERS
                    $q['answers'] = $category::where(DB::raw('`school_2_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
                }
            } else {
                $q['question'] = $question->school_1_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } elseif($category == "Birthdate") {
            $q['title'] = $c_question[$random];
            $q['question'] = $question->birthdate;
            // ANSWERS
            $q['answers'] = $category::where('birthdate', '!=', $q['question'])->take(3)->get();
        } elseif($category == "Book") {
            $q['title'] = $c_question[$random];

            $books = explode(', ', $question->book);
            $segments = count($books)-1;

            $r = rand(0, $segments);

            $q['question'] = $books[$r];
            $q['image'] = BaseController::search_image('book '.$books[$r]);

            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`book`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        } elseif($category == "Music") {
            $q['title'] = $c_question[$random];

            $music = explode(', ', $question->music);
            $segments = count($music)-1;

            $r = rand(0, $segments);

            $q['question'] = $music[$r];
            $q['image'] = BaseController::search_image('music '.$music[$r]);

            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`music`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        } elseif($category == "Movie") {
            $q['title'] = $c_question[$random];

            $movies = explode(', ', $question->movies);
            $segments = count($movies)-1;

            $r = rand(0, $segments);

            $q['question'] = $movies[$r];
            $q['image'] = BaseController::search_image('movie '.$movie[$r]);

            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`movies`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        } elseif($category == "Interest") {
            $q['title'] = $c_question[$random];

            $interests = explode(', ', $question->interests);
            $segments = count($interests)-1;

            $r = rand(0, $segments);

            $q['question'] = $interests[$r];

            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`interests`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        }


        // GET ANSWER
        foreach($q['answers'] as $answer) {
            $a['answers'][] = [
                'uid' => $answer['id'], 
                'name' => json_decode(file_get_contents('http://graph.facebook.com/'.$answer['id'].'?fields=name'))->name, 
                'picture' => 'https://graph.facebook.com/'.$answer['id'].'/picture?type=large',
            ];
        }

        $q['answers'] = $a['answers'];
        $q['answers'][] = ['uid' => $q['uid'], 'name' => $q['name'], 'picture' => $q['picture']];
        
        // STORE CORRECT UID
        Session::put('correct_uid', $q['uid']);
        Session::put('answers', $q['answers']);

        // RESPOND
        return Response::json($q);
    } else {
        return Response::json('false');
    }
});

Route::get('50-50', function() {
    $price = 1;

    $user = User::find(Auth::user()->id);

    if($user->coins >= $price) {
        $coins = $user->coins;
        $user->coins = $coins-$price;
        $user->save();

        $answers = Session::get('answers');
        $correct = Session::get('correct_uid');

        foreach ($answers as $item) {
        	if ($correct == $item['uid'])
        		unset($item);
        	else
        		$q[] = $item;
	    }

        shuffle($q);

        return Response::json([$q[0]['uid'], $q[1]['uid']]);
    } else {
        return Response::json('false');
    }
});

// CHECK ANSWER
Route::get('check-answer', function() {
    $uid = Input::get('uid');

    if($uid == Session::get('correct_uid')) {
        $answer = Answer::where('user', Session::get('uid'))->where('friend', $uid)->first();
        $profile = Profile::where('uid', Session::get('uid'))->first();
        $user = User::where('id', $profile->user_id)->first();
        $user->increment('points');
        $user->save();

        if(!$answer) {
            $a = new Answer;
            $a->user = Session::get('uid');
            $a->friend = $uid;
            $a->correct = 1;
            $a->save();
        } else {
            $a = Answer::where('user', Session::get('uid'))->where('friend', $uid)->first();
            $a->increment('correct');
        }

        return Response::json('true');
    } else {
        $answer = Answer::where('user', Session::get('uid'))->where('friend', $uid)->first();

        if(!$answer) {
            $a = new Answer;
            $a->user = Session::get('uid');
            $a->friend = $uid;
            $a->wrong = 1;
            $a->save();
        } else {
            $a = Answer::where('user', Session::get('uid'))->where('friend', $uid)->first();
            $a->increment('wrong');
        }

        return Response::json(Session::get('correct_uid'));
    }
});

// GET QUESTION 
Route::get('get-question', function() {
    // RANDOM CATEGORY
    $random = rand(0,7);
    $c = ['Picture', 'Employment', 'Education', 'Birthdate', 'Book', 'Music', 'Movie', 'Interest'];
    $c_table = ['url', 'employer_1', 'school_1_name', 'birthdate', 'book', 'music', 'movies', 'interests'];
    $c_question = ['Picture:', 'Employment:', 'Education:', 'Birthdate:', 'Book:', 'Music:', 'Movie:', 'Interest:'];
    $category = $c[$random];

    // GET CORRECT ANSWER
    $question = $category::where($c_table[$random], '!=', '')->orderBy(DB::raw('RAND()'))->first();

    // GET CORRECT ANSWER UID
    $q['uid'] = $question->id;
    $q['type'] = $category;
    $q['name'] = json_decode(file_get_contents('http://graph.facebook.com/'.$q['uid'].'?fields=name'))->name;
    $q['picture'] = 'https://graph.facebook.com/'.$q['uid'].'/picture?type=large';

    if($category == "Picture") {
        // QUESTION ABOUT PROFILE PICTURE
        $q['title'] = $c_question[$random];
        $q['question'] = $question->url;

        // ANSWERS
        $q['answers'] = $category::where('url', '!=', $q['question'])->take(3)->get();
    } elseif($category == "Employment") {
        $q['title'] = $c_question[$random];

        if($question->employer_3 != '') {
            $r = rand(1,3);

            if($r == 1) {
                $q['question'] = $question->employer_1;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } elseif($r == 2) {
                $q['question'] = $question->employer_2;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_2`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } else {
                $q['question'] = $question->employer_3;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_3`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } elseif($question->employer_2 != '') {
            $r = rand(1,2);

            if($r == 1) {
                $q['question'] = $question->employer_1;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } else {
                $q['question'] = $question->employer_2;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`employer_2`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } else {
            $q['question'] = $question->employer_1;
            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`employer_1`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        }
    } elseif($category == "Education") {
        $q['title'] = $c_question[$random];

        if($question->school_3_name != '') {
            $r = rand(1,3);

            if($r == 1) {
                $q['question'] = $question->school_1_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } elseif($r == 2) {
                $q['question'] = $question->school_2_name;
                // school_2_name
                $q['answers'] = $category::where(DB::raw('`school_2_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } else {
                $q['question'] = $question->school_3_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_3_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } elseif($question->school_2_name != '') {
            $r = rand(1,2);

            if($r == 1) {
                $q['question'] = $question->school_1_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            } else {
                $q['question'] = $question->school_2_name;
                // ANSWERS
                $q['answers'] = $category::where(DB::raw('`school_2_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
            }
        } else {
            $q['question'] = $question->school_1_name;
            // ANSWERS
            $q['answers'] = $category::where(DB::raw('`school_1_name`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
        }
    } elseif($category == "Birthdate") {
        $q['title'] = $c_question[$random];
        $q['question'] = $question->birthdate;
        // ANSWERS
        $q['answers'] = $category::where('birthdate', '!=', $q['question'])->take(3)->get();
    } elseif($category == "Book") {
        $q['title'] = $c_question[$random];

        $books = explode(', ', $question->book);
        $segments = count($books)-1;

        $r = rand(0, $segments);

        $q['question'] = $books[$r];
        $q['image'] = BaseController::search_image('book '.$books[$r]);

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`book`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    } elseif($category == "Music") {
        $q['title'] = $c_question[$random];

        $music = explode(', ', $question->music);
        $segments = count($music)-1;

        $r = rand(0, $segments);

        $q['question'] = $music[$r];
        $q['image'] = BaseController::search_image('music '.$music[$r]);

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`music`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    } elseif($category == "Movie") {
        $q['title'] = $c_question[$random];

        $movies = explode(', ', $question->movies);
        $segments = count($movies)-1;

        $r = rand(0, $segments);

        $q['question'] = $movies[$r];
        $q['image'] = BaseController::search_image('movies '.$movies[$r]);

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`movies`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    } elseif($category == "Interest") {
        $q['title'] = $c_question[$random];

        $interests = explode(', ', $question->interests);
        $segments = count($interests)-1;

        $r = rand(0, $segments);

        $q['question'] = $interests[$r];

        // ANSWERS
        $q['answers'] = $category::where(DB::raw('`interests`'), DB::raw('NOT LIKE'), DB::raw("'%%".addslashes($q['question']).",%%'"))->orderBy(DB::raw('RAND()'))->take(3)->get();
    }


    // GET ANSWER
    foreach($q['answers'] as $answer) {
        $a['answers'][] = [
            'uid' => $answer['id'], 
            'name' => json_decode(file_get_contents('http://graph.facebook.com/'.$answer['id'].'?fields=name'))->name, 
            'picture' => 'https://graph.facebook.com/'.$answer['id'].'/picture?type=large',
        ];
    }

    $q['answers'] = $a['answers'];
    $q['answers'][] = ['uid' => $q['uid'], 'name' => $q['name'], 'picture' => $q['picture']];
    
    // STORE CORRECT UID
    Session::put('correct_uid', $q['uid']);
    Session::put('answers', $q['answers']);

    // LEVEL
    if(Session::get('step')) {
        $step = Session::get('step');
        if($step == 10) {
            Session::put('step', 1);

            $user = User::find(Auth::user()->id);

            if($user->quiz == 0) {
                $badge = New Badge();
                $badge->badge = "first_quiz";
                $badge = $user->badges()->save($badge);

                $user->quiz = 1;
                $user->save();

                $profile = Profile::where('uid', Session::get('uid'))->first();

                $facebook = new Facebook(Config::get('facebook'));
                $facebook->setAccessToken($profile->access_token);

                $facebook->api('/me/feed', 'post', array(
                    'message' => 'Hell yeah! Just passed my first Best Friends Game quiz and challenge! So cool... Come and try it!',
                    'name' => 'Best Friend Game',
                    'picture' => 'https://graph.facebook.com/guscins/picture?type=large',
                    'link' => 'http://apps.facebook.com/bestfriendsgameapp/',
                ));

            }

        } else {
            $step = $step+1;
            Session::put('step', $step);
        }
    } else {
        Session::put('step', 1);
    }

    // RESPOND
    return Response::json($q);
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

            $p = $user ? Picture::where('id', $item['uid'])->first() : new Picture;
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

            $e = $user ? Employment::where('id', $item['uid'])->first() : new Employment;
            $e->id = $item['uid'];

            if(isset($item['work'][0]))
                $e->employer_1 = $item['work'][0]['employer']['name'];

            if(isset($item['work'][1]))
                $e->employer_2 = $item['work'][1]['employer']['name'];

            if(isset($item['work'][2]))
                $e->employer_3 = $item['work'][2]['employer']['name'];

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

            $e = $user ? Education::where('id', $item['uid'])->first() : new Education;
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
        foreach ($data as $item) {
            $user = Birthdate::where('id', $item['uid'])->first();

            $bday = explode('/', $item['birthday_date']);
            $bday = $bday[0].'/'.$bday[1];

            $p = $user ? Birthdate::where('id', $item['uid'])->first() : new Birthdate;
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
        foreach ($data as $item) {
            $user = Book::where('id', $item['uid'])->first();

            $b = $user ? Book::where('id', $item['uid'])->first() : new Book;
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

            $m = $user ? Music::where('id', $item['uid'])->first() : new Music;
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
        foreach ($data as $item) {
            $user = Movie::where('id', $item['uid'])->first();

            $m = $user ? Movie::where('id', $item['uid'])->first() : new Movie;
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
        foreach ($data as $item) {
            $user = Interest::where('id', $item['uid'])->first();

            $i = $user ? Interest::where('id', $item['uid'])->first() : new Interest;
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
    $users = User::orderBy(DB::raw('RAND()'))->take(4)->get();

    return View::make('game.intro.login')
                ->with('users', $users);
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

        $badge = New Badge();
        $badge->badge = "logged_in";
        $badge = $user->badges()->save($badge);

        $facebook->api('/me/feed', 'post', array(
            'message' => 'Hell yeah! Just passed my first Best Friends Game quiz and challenge! So cool... Come and try it!',
            'name' => 'Best Friend Game',
            'picture' => 'https://graph.facebook.com/guscins/picture?type=large',
            'link' => 'http://apps.facebook.com/bestfriendsgameapp/',
        ));
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