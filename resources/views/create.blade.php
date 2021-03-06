@extends('layouts.default')

@section('title')
Your event is awaiting your validation.
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
                <p>You requested a meeting with {{ $event->user->email }} on:</p>
                <p><strong>We've just sent you an email to validate your address. Please click on the email confirmation link to confirm the meeting!</strong></p>
                <ul>
                    <li>Start: {{ \Carbon\Carbon::parse($event->start)->toDayDateTimeString() }}</li>
                    <li>End: {{ \Carbon\Carbon::parse($event->end)->toDayDateTimeString() }}</li>
                    <li>Duration: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($event->eventType->duration) }} minutes.</p>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop