@extends('layouts.account')

@section('title')
	User settings
@endsection

@section('breadcrumb')
	Settings
@endsection

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h3>Timezone</h3>
				<form action="/settings/timezone" class="form-material" method="POST">
					{{ csrf_field() }}
					<div class="form-group">
						<select class="form-control" name="timezone">
						@foreach ($timezones as $timezone)
							<option {{ (Auth::user()->timezone == $timezone) ? ' selected' : '' }} value="{{ $timezone }}">{{ $timezone }}</option>
						@endforeach
						</select>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-rounded">Save timezone</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h3>Custom Slug</h3>
				<form action="/settings/slug" class="form-material" method="POST">
					{{ csrf_field() }}
					<div class="form-group">
						<input type="text" class="form-control" name="slug" value="{{ old('slug', $user->slug) }}"/>
						<span class="help-block text-muted"><small>Will be part of your custom url: <code>https://&lt;slug&gt;.{{ config('app.domain') }}</code>. This must only contains letters and numbers.</small></span>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-success btn-rounded">Save slug</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<h3>Avaibility slots</h3>
				<form action="/settings/avaibility" class="form-material" method="POST">
					
					{{ csrf_field() }}
					
					
					@foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
						<div class="form-group m-t-40 row">
							<label class="col-2 col-form-label">{{ $day }}</label>
							<div class="col-10">
								<a href="#" class="btn waves-effect waves-light btn-small btn-rounded btn-outline-info">
									<i class="mdi mdi-plus"></i> Add a time range
								</a>
							</div>
						</div>
					@endforeach
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-2 input-group clockpicker" data-autoclose="true">
		<input type="text" class="form-control" value="">
	</div>
	<div class="col-2 input-group clockpicker" data-autoclose="true">
		<input type="text" class="form-control" value="">
	</div>
</div>
@stop