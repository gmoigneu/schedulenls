@extends('layouts.account')

@section('title')
Edit "{{ $eventType->name }}"
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
                <form method="POST" class="form-material" action="{{ route('eventtype.update', ['eventtype' => $eventType]) }}">
                    {!! method_field('patch') !!}
                    {{ csrf_field() }}
                    <input type="hidden" name="eventType" value="{{ $eventType->id }}"/>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $eventType->name) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug:</label>
                        <input type="text" class="form-control" name="slug" value="{{ old('slug', $eventType->slug) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input type="text" class="form-control" name="duration"  value="{{ old('duration', $eventType->duration) }}"/>
                    </div>
                    <div class="form-group">
                        <label for="padding">Padding:</label>
                        <input type="text" class="form-control" name="padding" value="{{ old('padding', $eventType->padding) }}"/>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-rounded">Save Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop