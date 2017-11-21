@extends('layouts.default')

@section('content')
<h1>Hello.</h1>

<p>Your calendar is {{ Auth::user()->calendars->first()->title }}</p>

<h2>Event types</h2>
@if (!count($eventTypes))
	<p>No event types.</p>
@else
	<ul>
	@foreach ($eventTypes as $eventType)
		<li>
			<p>{{ $eventType->name }} ({{ $eventType->duration }} minutes)</p>
			<p><a href="{{ $eventType->link }}">Event link</a></p>
		</li>
	@endforeach
	</ul>
@endif

@stop