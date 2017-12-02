@extends('layouts.default')

@section('title')
	Available slots for {{ $eventType->name }} ({{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($duration) }} minutes)
@endsection

@section('content')

<div id="schedule">
	@if (session('error'))
		<div class="alert alert-warning">
			{{ session('error') }}
		</div>
	@endif

	@foreach ($availableEvents as $day => $events)
		@if (count($events))
			<h3 class="mt-4 mb-2 ">{{ \Carbon\Carbon::parse($day)->format('l jS \\of F Y') }}</h3>
			<div class="row">
				@foreach ($events as $event)
					<div class="col-lg-4 col-md-6 col-xlg-2 col-xs-12">
						<a href="{{ action('ScheduleController@book', ['user' => $user, 'eventType' => $eventType, 'datetime' => \Carbon\Carbon::instance($event->start)->toAtomString()]) }}" class="card slot">
							{{ $event->start->format('H:i') }} to {{ $event->start->add(\Carbon\CarbonInterval::minutes($duration))->format('H:i') }}
						</a>
					</div>
				@endforeach
			</div>
		@else
			<h3 class="mt-4 mb-2 unavailable">{{ \Carbon\Carbon::parse($day)->format('l jS \\of F Y') }}</h3>
		@endif
		</ul>
	@endforeach

	<div class="d-sm-flex">
		<div class="mr-auto p-2">
			@if ($previous)
				<a class="d-block btn btn-info btn-rounded" href="{{ $previous }}">Previous week</a>
			@endif
		</div>
		<div class="p-2"><a class="d-block btn btn-info btn-rounded" href="{{ $next }}">Next week</a></div>
	</div>
</div>
@stop