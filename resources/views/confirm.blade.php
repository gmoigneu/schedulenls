@extends('layouts.default')

@section('title')
Your event has been created !
@endsection

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
                <p>You will be meeting with {{ $event->user->email }} on:</p>

                <ul>
                    <li>Start: {{ \Carbon\Carbon::parse($event->start)->toDayDateTimeString() }}</li>
                    <li>End: {{ \Carbon\Carbon::parse($event->end)->toDayDateTimeString() }}</li>
                    <li>Duration: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($event->eventType->duration) }} minutes.</li>
                    <li>Summary: {{ $event->summary }}</li>
                </ul>

                <p>An invite has been dispatched to your mailbox.</p>
            </div>
        </div>
    </div>
</div>
@stop