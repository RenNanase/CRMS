<!DOCTYPE html>
<html>
<head>
    @vite('resources/css/app.css')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>