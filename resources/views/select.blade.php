@extends('layouts.account')

@section('title')
	Select your Calendar
@endsection

@section('breadcrumb')
	Calendars
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="/select" class="form-material" method="POST">
					{{ csrf_field() }}
					<div class="form-group">
						<select name="calendar" class="form-control">
						@foreach ($calendars as $calendar)
							<option {{ ($currentCalendar == $calendar->id) ? ' selected' : '' }} value="{{ $calendar->id }}">{{ $calendar->summary }}</option>
						@endforeach
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-rounded">Select calendar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop