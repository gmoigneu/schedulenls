@extends('layouts.default')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('eventtype.update', ['eventtype' => $eventType]) }}">
	{!! method_field('patch') !!}
    {{ csrf_field() }}
    <input type="hidden" name="eventType" value="{{ $eventType->slug }}"/>
    <label for="name">Name:</label><input type="text" name="name" value="{{ old('name', $eventType->name) }}"/>
    <label for="slug">Slug:</label><input type="text" name="slug" value="{{ old('slug', $eventType->slug) }}"/>
    <label for="duration">Duration:</label><input type="text" name="duration"  value="{{ old('duration', $eventType->duration) }}"/>
    <label for="padding">Padding:</label><input type="text" name="padding" value="{{ old('padding', $eventType->padding) }}"/>
    <input type="submit">
</form>

@stop