@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<div class="content-center">

@if (count($eventTypes))
	<p class="my-4">Choose the type of event you want:</p>
	<ul class="list-reset">
	@foreach ($eventTypes as $eventType)
		<li>
			<a class="flex justify-center border block hover:bg-indigo hover:border-indigo my-2 p-4 text-indigo no-underline hover:text-white" href="{{ route('schedule', ['user' => $user, 'eventType' => $eventType, 'start' => null]) }}">
				{{ $eventType->name }} ({{ \Carbon\CarbonInterval::minutes($eventType->duration) }})
			</a>
		</li>
	@endforeach
	</ul>
@else
	<p>This user has not yet configured his account.</p>
@endif

@stop