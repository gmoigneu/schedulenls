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
				<form action="/settings/slug" class="form-material" method="POST">
					{{ csrf_field() }}
					<div class="form-group">
						<label for="slug">Slug</label>
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
@stop