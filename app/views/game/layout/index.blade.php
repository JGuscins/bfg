<!DOCTYPE html>
<html>
  <head>
    <title><?php _('BFG') ;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ URL::to('packages/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('packages/css/game.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="fb-root"></div>
    <div class="container">
      @yield('content')
    </div>

    <button id="pay">Buy Product</button>
    
    <script type="text/javascript">
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '556335464450181',
          status     : true,
          cookie     : true,
          xfbml      : true
        });   

        function buy() {
          // var obj = {
          //   method: 'pay',
          //   action: 'purchaseitem',
          //   product: 'http://bfg.mobbi.lv/test.html',
          //   request_id: 1137,
          //   quantity: 1
          // };

          var obj = {
            method: 'apprequests',
            message: 'My Great Request',
            data: '{"user_invited":me}'
          };

          FB.ui(obj, function(data) {
            console.log(JSON.stringify(data));
          });

        }
        document.getElementById('pay').onclick = function() {buy()};
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
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="{{ URL::to('packages/js/bootstrap.min.js') }}"></script>
  </body>
</html>