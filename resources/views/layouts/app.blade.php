<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Zipcode</title>

    <!-- Styles -->
	<link href="/css/materialize.min.css" rel="stylesheet">
	<link href="/css/helpers.css" rel="stylesheet">
	<link href="/css/my.css" rel="stylesheet">


    <!-- Scripts -->
	<script src="/js/jquery-3.2.1.min.js"></script>
	<script src="/js/materialize.min.js"></script>
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
<body>
<header>
</header>
	@yield('content')
</body>
<script src="/js/helpers.js"></script>
	@yield('scripts')
</html>
