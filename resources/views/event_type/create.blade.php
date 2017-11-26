@extends('layouts.account')

@section('content')

@if (session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('eventtype.store') }}">
    {{ csrf_field() }}
    <label for="name">Name:</label><input type="text" name="name" value="{{ old('name', '') }}"/>
    <label for="slug">Slug:</label><input type="text" name="slug" value="{{ old('slug', '') }}"/>
    <label for="duration">Duration:</label><input type="text" name="duration"  value="{{ old('duration', '') }}"/>
    <label for="padding">Padding:</label><input type="text" name="padding" value="{{ old('padding', '') }}"/>
    <input type="submit">
</form>

@stop