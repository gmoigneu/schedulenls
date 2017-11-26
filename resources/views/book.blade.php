@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<h2>Meeting details</h2>
<ul class="list-reset m-4">
    <li><span class="font-semibold">Duration</span>: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($eventType->duration) }} minutes.</p>
    <li><span class="font-semibold">Start</span>: {{ $start->toDayDateTimeString() }}</li>
    <li><span class="font-semibold">End:</span> {{ $end->toDayDateTimeString() }}</li>
</ul>

<p class="my-4">Please fill the following form to validate:</p>

<form method="POST" action="{{ route('create') }}">
    {{ csrf_field() }}
    <input type="hidden" name="user" value="{{ $user->slug }}" />
    <input type="hidden" name="eventType" value="{{ $eventType->slug }}" />
    <input type="hidden" name="start" value="{{ $start->toAtomString() }}" />
    <input type="text" class="border block p-2 mt-2 w-full" placeholder="Name" name="name" value="{{ old('name', '') }}"/>
    <input type="text" class="border block p-2 mt-2 w-full" placeholder="Email" name="email"  value="{{ old('email', '') }}"/>
    <input type="text" class="border block p-2 mt-2 w-full" placeholder="Organization" name="organization" value="{{ old('organization', '') }}"/>
    <input class="btn-round" type="submit" value="Book this meeting">
</form>

@stop