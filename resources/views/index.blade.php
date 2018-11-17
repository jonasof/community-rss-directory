<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RSS & Podcasts Community Directory</title>

    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <noscript>
      <h1>Please enable javascript</h1>
    </noscript>
    <div id='app'>
      <appheader></appheader>
      <div class="container" style="margin-top: 20px">
        <div>
          <router-view></router-view>
        </div>
      </div>
      <appfooter></appfooter>
    </div>

    <script src="/js/app.js"></script>
  </body>
</html>
