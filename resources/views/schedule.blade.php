@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<div class="content-center">
<h2>Event: {{ $eventType->name }} ({{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($duration) }} minutes)</h2>
</div>

@foreach ($availableEvents as $day => $events)
	<div>
		
		@if (count($events))
		<h3 class="mt-4 mb-2 ">{{ \Carbon\Carbon::parse($day)->format('l jS \\of F Y') }}</h3>
			<ul class="list-reset ">
			@foreach ($events as $event)
				<li class="">
					<a class="flex justify-center border block hover:bg-indigo hover:border-indigo my-2 p-4 text-indigo no-underline hover:text-white" href="{{ action('ScheduleController@book', ['user' => $user, 'eventType' => $eventType, 'datetime' => \Carbon\Carbon::instance($event->start)->toAtomString()]) }}">
						{{ $event->start->format('H:i') }} to {{ $event->start->add(\Carbon\CarbonInterval::minutes($duration))->format('H:i') }}
					</a>
				</li>
			@endforeach
		@else
			<h3 class="mt-4 mb-2 text-grey">{{ \Carbon\Carbon::parse($day)->format('l jS \\of F Y') }}</h3>
		@endif
		</ul>
	</div>
@endforeach

<div>
	@if ($previous)
		<a class="btn-round" href="{{ $previous }}">Previous week</a>
	@endif
	<a class="btn-round" href="{{ $next }}">Next week</a>
</div>
@stop