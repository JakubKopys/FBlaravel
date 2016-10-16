<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FB') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
    <div id="app">
        <div id="msg_container" class="alert alert-danger" style="display: none"></div>
        @include('layouts/nav')

        <div class="container">
            @yield('content')
        </div>
    </div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    <script src="/js/jquery.infinitescroll.min.js"></script>
    <script src="/js/scroll.js"></script>
</body>
</html>
