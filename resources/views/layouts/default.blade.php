<?php
    $route = \Illuminate\Support\Facades\Route::currentRouteName();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ env('APP_NAME') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="font-sans">
    <nav class="flex container mx-auto items-center justify-between flex-wrap bg-white px-2 py-4">
      <div class="flex items-center flex-grow flex-no-shrink text-black mr-6">
        <a href="{{ route('types', ['user' => $user]) }}" class="font-semibold text-black  tracking-wide text-xl tracking-tight">{{ env('APP_NAME') }}</a>
      </div>
      <div>
        <div>
          <a href="{{ route('login') }}" class="inline-block text-sm  tracking-wide px-4 py-2 leading-none rounded text-grey-darker no-underline">Login</a>
        </div>
      </div>
    </nav>
    <nav class="flex items-center justify-between flex-wrap bg-indigo p-4 font-regular">
      <div class="container mx-auto w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm leading-normal tracking-wide lg:flex-grow">
          <p class="block mr-6 lg:inline-block px-2 text-indigo-light }}">
            You're booking a meeting with {{ $user->email }}
          </p>
        </div>
      </div>
    </nav>
    <div class="container mx-auto px-2 my-8">
        @include('partials.alert')
        @yield('content')
    </div>

    @include('partials.footer')
</body>
</html>