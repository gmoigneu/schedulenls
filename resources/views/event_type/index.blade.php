@extends('layouts.account')

@section('content')

<h2>Event types</h2>
@if (!count($eventTypes))
	<p>No event types.</p>
@else
	<ul>
		@foreach ($eventTypes as $eventType)
			<li>
				<p>{{ $eventType->name }} ({{ $eventType->duration }} minutes)
				 - <a href="{{ $eventType->link }}">Event link</a>
				(<a href="{{ route('eventtype.edit', ['eventtype' => $eventType]) }}">edit</a> - 

				<form action="{{ route('eventtype.destroy', ['eventtype' => $eventType->slug]) }}" method="POST">
				    {{ method_field('DELETE') }}
				    {{ csrf_field() }}
				    <button>delete</button>
				</form>
			</li>
		@endforeach
		<li>
			<p><a href="{{ route('eventtype.create') }}">Create a new event type</a></p>
		</li>
	</ul>
@endif

@stop