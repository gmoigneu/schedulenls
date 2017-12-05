@extends('layouts.default')

@section('title')
	Confirm your meeting
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
                <h2>Meeting details</h2>
                <ul class="list-reset m-4">
                    <li><span class="font-semibold">Duration</span>: {{ \App\Helpers\DateIntervalHelper::dateIntervalToMinutes($eventType->duration) }} minutes.</p>
                    <li><span class="font-semibold">Start</span>: {{ $start->toDayDateTimeString() }}</li>
                    <li><span class="font-semibold">End:</span> {{ $end->toDayDateTimeString() }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
                <p class="my-4">Please fill the following form to validate:</p>

                <form method="POST" class="form-material" action="{{ route('create', ['user' => $user]) }}">
                    {{ csrf_field() }}
                    
                    <input type="hidden" name="user" value="{{ $user->slug }}" />
                    <input type="hidden" name="eventType" value="{{ $eventType->slug }}" />
                    <input type="hidden" name="start" value="{{ $start->toAtomString() }}" />
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Name" name="name" value="{{ old('name', '') }}"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Email" name="email"  value="{{ old('email', '') }}"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Organization" name="organization" value="{{ old('organization', '') }}"/>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Meeting Summary" name="summary" value="{{ old('summary', '') }}"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded">Book this meeting</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop