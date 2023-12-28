@extends('layouts.app')

@section('content')
	<style>
		body {
			background-color: #222;
		}
		.container form {
			background-color: #333;
			border-radius: 5px;
			padding: 20px;
		}

		.container form h2 {
			color: #ddd;
		}

		.container form .form-control {
			background-color: #444;
			color: #fff;
			border: none;
		}

		.container form .form-control:focus {
			background-color: #444;
			color: #fff;
			border: none;
			outline: none;
			box-shadow: none;
		}

		.container form label {
			color: #ddd;
			font-size: 1.2em;
		}

		.container form input[type="submit"] {
			background-color: #444;
			color: #fff;
			border: none;
			cursor: pointer;
		}

		.container form input[type="submit"]:hover {
			background-color: #555;
		}
	</style>
	<div class="container">
		<form action="{{ route('events.store') }}" method="POST">
			@csrf
			<div class="form-group">
				<label for="name">Event Naam:</label>
				<input type="text" class="form-control" id="name" name="name" required>
			</div>
			<div class="form-group">
				<label for="description">Beschrijving:</label>
				<textarea class="form-control" id="description" name="description"></textarea>
			</div>
			<div class="form-group">
				<label for="start_time">Start tijd:</label>
				<input type="datetime-local" class="form-control" id="start_time" name="start_time" required>
			</div>
			<div class="form-group">
				<label for="end_time">Eind tijd:</label>
				<input type="datetime-local" class="form-control" id="end_time" name="end_time" required>
			</div>
			<div class="form-group">
				<label for="location">Locatie:</label>
				<input type="text" class="form-control" id="location" name="location" required>
			</div>
			<div class="form-group">
				<label for="leeftijdsgroep">Leeftijdsgroep:</label>
				<input type="text" class="form-control" id="leeftijdsgroep" name="leeftijdsgroep" required>
			</div>
			<div class="form-group">
				<label for="hoofdAnimatoren">Hoofdanimatoren:</label>
				<input type="text" class="form-control" id="hoofdAnimatoren" name="hoofdAnimatoren">
			</div>
			<div class="form-group">
				<label for="maxAnimatoren">Maximum Animatoren:</label>
				<input type="number" class="form-control" id="maxAnimatoren" name="maxAnimatoren" required>
			</div>
			<div class="form-group">
				<label for="typeActiviteit">Type Activiteit:</label>
				<select class="form-control" id="typeActiviteit" name="typeActiviteit" required>
				<option value="0">Speelplein</option>
				<option value="1">Grabbelpas</option>
				<option value="2">Ca Va</option>
				<option value="3">Iedereen!</option>
			</select>
			</div>
			<button type="submit" class="btn btn-primary">Create Event</button>
		</form>
		@if (session('status'))
			<div class="alert alert-success">
			{{ session('status') }}
			</div>
		@endif
	</div>
@endsection