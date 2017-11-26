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
    <nav class="flex container mx-auto items-center justify-between flex-wrap bg-white py-4">
      <div class="flex items-center flex-grow flex-no-shrink text-black mr-6">
        <span class="font-semibold text-black tracking-wide text-xl tracking-tight">{{ env('APP_NAME') }}</span>
      </div>
      <div>
        <div>
          <a href="{{ route('logout') }}" class="inline-block text-sm tracking-wide px-4 py-2 leading-none rounded text-grey-darker no-underline">Logout</a>
        </div>
      </div>
    </nav>
    <nav class="flex items-center justify-between flex-wrap bg-indigo p-4 font-regular">
      <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="container mx-auto text-sm tracking-wide lg:flex-grow">
          <a href="{{ route('dashboard') }}" class="block mr-6 lg:inline-block no-underline hover:text-white {{ (strstr($route, 'dashboard')) ? 'text-white font-semibold' : 'text-indigo-light' }}">
            Dashboard
          </a>
          <a href="{{ route('select') }}" class="block mr-6 lg:inline-block no-underline hover:text-white {{ (strstr($route, 'select')) ? 'text-white font-semibold' : 'text-indigo-light' }}">
            Calendars
          </a>
          <a href="{{ route('eventtype.index') }}" class="block lg:inline-block no-underline hover:text-white {{ (strstr($route, 'eventtype.')) ? 'text-white font-semibold' : 'text-indigo-light' }}">
            Event types
          </a>
        </div>
      </div>
    </nav>
    <div class="container mx-auto my-8">
        @include('partials.alert')
        @yield('content')
    </div>

    @include('partials.footer')
</body>
</html>