@extends('layouts.default')

@section('content')

<h1>Schedule from {{ $start->format('Y-m-d') }} to {{ $end->format('Y-m-d') }}</h1>
<p>Event duration: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($duration) }} minutes</p>

@foreach ($availableEvents as $day => $events)
	<div>
		<h2>{{ $day }}</h2>
		<ul>
			@if (count($events))
				@foreach ($events as $event)
					<li>{{ $event->start->format('H:i') }} to {{ $event->start->add($duration)->format('H:i') }}</li>
				@endforeach
			@endif
		</ul>
	</div>
@endforeach

@stop