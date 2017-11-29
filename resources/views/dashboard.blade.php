@extends('layouts.account')

@section('title')
	Dashboard
@endsection

@section('breadcrumb')
	Dashboard
@endsection

@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				Your calendar is {{ Auth::user()->calendars->first()->title }} (<a href="{{ route('select') }}">change</a>)
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h2>Scheduled Events</h2>
				@if (!count($events))
					<p>No events.</p>
				@else
					<div class="table-responsive">
						<table class="table m-t-30 table-hover contact-list" data-page-size="10">
							<thead>
								<tr>
									<th>Date</th>
									<th>Name</th>
									<th>Type</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($events as $event)
									<tr>
										<td>
											{{ \Carbon\Carbon::parse($event->start) }}
										</td>
										<td>{{ $event->name }} ({{ $event->organization }})</td>
										<td>{{ $event->eventType->name }} ({{ \Carbon\CarbonInterval::minutes($event->eventType->duration) }} minutes</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@stop