<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    @vite('resources/css/app.css')

    @yield('style')

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

    @yield('content')

    @yield('scripts')

</body>
</html>