<!DOCTYPE html>
<html>
  <head>
    <title><?php _('BFG') ;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ URL::to('packages/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('packages/css/game.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="{{ URL::to('packages/js/bootstrap.min.js') }}"></script>
  </body>
</html>