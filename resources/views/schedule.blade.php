@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

@if ($previous)
	<a href="{{ $previous }}">Previous</a>
@endif
<a href="{{ $next }}">Next</a>

<p>Event duration: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($duration) }} minutes</p>

@foreach ($availableEvents as $day => $events)
	<div>
		<h2>{{ $day }}</h2>
		<ul>
			@if (count($events))
				@foreach ($events as $event)
					<li>
						<a href="{{ action('ScheduleController@book', ['user' => $user, 'eventType' => $eventType, 'datetime' => \Carbon\Carbon::instance($event->start)->toAtomString()]) }}">
							{{ $event->start->format('H:i') }} to {{ $event->start->add(\Carbon\CarbonInterval::minutes($duration))->format('H:i') }}
						</a>
					</li>
				@endforeach
			@else
				<li>No slot available</li>
			@endif
		</ul>
	</div>
@endforeach

@stop