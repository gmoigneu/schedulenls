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
				<p>{{ $eventType->name }} ({{ $eventType->duration }} minutes)
				 - <a href="{{ $eventType->link }}">Event link</a>
				(<a href="{{ route('eventtype.edit', ['eventtype' => $eventType]) }}">edit</a> - <a href="{{ route('eventtype.destroy', ['eventtype' => $eventType]) }}">delete</a>)</p>
			</li>
		@endforeach
		<li>
			<p><a href="{{ route('eventtype.create') }}">Create a new event type</a></p>
		</li>
	</ul>
@endif

@stop