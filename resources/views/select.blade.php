@extends('layouts.account')

@section('content')

<form action="/select" method="POST">
	{{ csrf_field() }}
	<select name="calendar">
	@foreach ($calendars as $calendar)
	    <option value="{{ $calendar->id }}">{{ $calendar->summary }}</option>
	@endforeach
	</select>

	<input type="submit" name="submit" value="Select calendar">
</form>
@stop