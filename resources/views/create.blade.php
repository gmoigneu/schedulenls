@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<h2>Your event has been created !</h2>

<p>You will be meeting {{ $event->user->email }} on:</p>

<ul>
    <li>Start: {{ \Carbon\Carbon::parse($event->start)->toDayDateTimeString() }}</li>
    <li>End: {{ \Carbon\Carbon::parse($event->end)->toDayDateTimeString() }}</li>
    <li>Duration: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($event->eventType->duration) }} minutes.</p>
</ul>

<p>An invite has been dispatched to your mailbox</p>

@stop