@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<p>You are booking a meeting with {{ $user->email }}.</p>

<p>Meeting details:</p>
<ul>
    <li>Duration: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($eventType->duration) }} minutes.</p>
    <li>Start: {{ $start->toDayDateTimeString() }}</li>
    <li>End: {{ $end->toDayDateTimeString() }}</li>
</ul>

<form method="POST" action="{{ route('create') }}">
    {{ csrf_field() }}
    <input type="hidden" name="user" value="{{ $user->slug }}" />
    <input type="hidden" name="eventType" value="{{ $eventType->slug }}" />
    <input type="hidden" name="start" value="{{ $start->toAtomString() }}" />
    <label for="name">Name:</label><input type="text" name="name" value="{{ old('name', '') }}"/>
    <label for="name">Email:</label><input type="text" name="email"  value="{{ old('email', '') }}"/>
    <label for="name">Organization:</label><input type="text" name="organization" value="{{ old('organization', '') }}"/>
    <input type="submit">
</form>

@stop