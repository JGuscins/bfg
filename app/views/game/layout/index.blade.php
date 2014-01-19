<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta property="og:type"                   content="og:product" />
		<meta property="og:title"                  content="Best Friends Game" />
		<meta property="og:image"                  content="{{ URL::to('share.jpg') }}" />
		<meta property="og:description"            content="Best Friends Game is awesome Facebook challenge & quiz game, where you can find out how good you know your friends!" />
		<meta property="og:url"                    content="http://www.bestfriendsgame.com/" />
		<meta property="product:price:amount"      content="5"/>
		<meta property="product:price:currency"    content="EUR"/>
        
        <title>Best Friends Game</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="{{ URL::to('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ URL::to('css/main.css') }}">

        <script src="{{ URL::to('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js') }}"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
    <script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '556335464450181',
          status     : true,
          cookie     : true,
          xfbml      : true
        });   

        function invite() {
          var obj = {
            method: 'apprequests',
            message: 'My Great Request',
            data: '{"user_invited":me}'
          };

          FB.ui(obj, function(data) {
            console.log(data);
          });
        }
        document.getElementById('invite').onclick = function() {
            invite();
        };
      };

      // Load the SDK Asynchronously
      (function(d){
        var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
        if (d.getElementById(id)) { return; }
        js = d.createElement('script'); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);
      }(document));
    </script>
    @yield('content')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
    <script src="{{ URL::to('js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ URL::to('js/main.js') }}"></script>
    <script src="{{ URL::to('js/game.js') }}"></script>
    </body>
</html>