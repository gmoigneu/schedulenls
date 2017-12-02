@extends('layouts.default')

@section('title')
	Event types
@endsection

@section('breadcrumb')
	Types
@endsection

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<div class="row">
	@if (count($eventTypes))
		@foreach ($eventTypes as $eventType)
			<div class="col-lg-4 col-md-6 col-xlg-2 col-xs-12">
				<a href="{{ route('schedule', ['user' => $user, 'eventType' => $eventType, 'start' => null]) }}" class="ribbon-wrapper card">
					<div class="ribbon ribbon-success">{{ \Carbon\CarbonInterval::minutes($eventType->duration) }}</div>
					<p class="ribbon-content">{{ $eventType->name }}</p>
				</a>
			</div>
		@endforeach
	@else
		<p>This user has not yet configured his account.</p>
	@endif
	
</div>
@stop