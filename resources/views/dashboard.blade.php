@extends('layouts.account')

@section('content')
<h1>Hello.</h1>

<p>Your calendar is {{ Auth::user()->calendars->first()->title }} (<a href="{{ route('select') }}">change</a>)</p>

<hr class="my-6"/>

<h2>Scheduled Events</h2>
@if (!count($events))
	<p>No events.</p>
@else
	<ul>
		@foreach ($events as $event)
			<li>
				{{ \Carbon\Carbon::parse($event->start) }} ({{ \Carbon\CarbonInterval::minutes($event->eventType->duration) }}) with {{ $event->name }} ({{ $event->organization }})
			</li>
		@endforeach
	</ul>
@endif

@stop