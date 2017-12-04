@extends('layouts.default')

@section('title')
	Available slots for {{ $eventType->name }} ({{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($duration) }} minutes)
	<br/><small>Current timezone: {{ $timezone }} (<a href="#" data-toggle="modal" data-target="#timezone-modal">change</a>)</small>
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
						<a href="{{ action('ScheduleController@book', ['user' => $user, 'eventType' => $eventType, 'datetime' => $event->toAtomString()]) }}" class="card slot">
							{{ $event->format('H:i') }} to {{ \Carbon\Carbon::instance($event)->add(\Carbon\CarbonInterval::minutes($duration))->format('H:i') }}
							@if ($timezone != $user->timezone)
								<br/><small>{{ $event->setTimezone($user->timezone)->format('H:i') }} ({{$user->timezone}})</small>
							@endif
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

<div id="timezone-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="timezoneLabel" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Select the timezone</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<form action="{{ route('schedule-timezone', ['user' => $user, 'eventType' => $eventType, 'start' => \Carbon\Carbon::instance($start)->format('Y-m-d')]) }}"  class="form-material" method="POST">
				{{ csrf_field() }}
				<div class="modal-body">
					<div class="form-group">
						<select class="form-control" name="timezone">
							@foreach ($timezones as $timezone)
								<option {{ ($user->timezone == $timezone) ? ' selected' : '' }} value="{{ $timezone }}">{{ $timezone }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success btn-rounded">Save timezone</button>
				</div>
			</form>
		</div>
	</div>
</div>
@stop