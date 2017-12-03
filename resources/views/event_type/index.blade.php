@extends('layouts.account')

@section('title')
	Your event types
@endsection

@section('breadcrumb')
	Types
@endsection

@section('content')

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				@if (!count($eventTypes))
					<p>No event types.</p>
				@else
					<div class="table-responsive">
						<table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list" data-page-size="10">
							<thead>
								<tr>
									<th>Name</th>
									<th>Duration</th>
									<th>Link</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($eventTypes as $eventType)
									<tr>
										<td>
											{{ $eventType->name }}
										</td>
										<td>{{ $eventType->duration }} minutes</td>
										<td><a href="{{ $eventType->link }}">Event link</a></td>
										<td>
											<a href="{{ route('eventtype.edit', ['eventtype' => $eventType]) }}"  class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Edit"><i class="ti-pencil" aria-hidden="true"></i></a>
											<form action="{{ route('eventtype.destroy', ['eventtype' => $eventType->slug]) }}" method="POST">
												{{ method_field('DELETE') }}
												{{ csrf_field() }}
												<button type="submit" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete"><i class="ti-close" aria-hidden="true"></i></button>
											</form>
										</td>
									</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4">
										<a href="{{ route('eventtype.create') }}" class="btn btn-info btn-rounded">Create a new Event Type</a>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>

@stop