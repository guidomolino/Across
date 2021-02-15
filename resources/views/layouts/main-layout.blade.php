<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/app.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bootstrap core CSS -->
    <link href = {{ asset("bootstrap/css/bootstrap.css") }} rel="stylesheet" />
    <title>across-test</title>
  </head>
  <body>
    @include('partials.header')
    <main class="container">
      @yield('form')
    </main>
    @include('partials.footer')
  </body>
</html>
