<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/css/app.css">
    @stack('styles')

    <title>{{ $title }}</title>
</head>

<body>
    @if (session('status'))
    <div>
        {{ session('status') }}
    </div>
    @endif
    {{ $slot }}
    <script src="/js/app.js"></script>
    @stack('scripts')
</body>

</html>