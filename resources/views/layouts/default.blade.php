<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_TITLE') }}</title>

    <link rel="stylesheet" href="{{ url('css/app.css') }}">
</head>
<body>
    <div class="container">
        <header>
            <h1>{{ env('APP_TITLE') }}</h1>
        </header>
        @include('partials.alert')
        @yield('content')
    </div>
</body>
</html>