@extends('layouts.account')

@section('title')
Create a new Event Type
@endsection

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
        <h3 class="text-warning"><i class="fa fa-exclamation-triangle"></i> Warning</h3>
        {{ session('error') }}
    </div>
@endif

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
                <form method="POST" class="form-material" action="{{ route('eventtype.store') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name', '') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug:</label>
                        <input class="form-control" type="text" name="slug" value="{{ old('slug', '') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration:</label>
                        <input class="form-control" type="text" name="duration"  value="{{ old('duration', '') }}"/>
                    </div>
                    <div class="form-group">
                        <label for="padding">Padding:</label>
                        <input class="form-control" type="text" name="padding" value="{{ old('padding', '') }}"/>
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