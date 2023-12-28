@extends('layouts.app')

@section('content')
<style>
body {
    background-color: #2b2b2b;
    color: #b3b3b3;
}
h1 {
    padding: 0 0 0 30px;
}
h1, h2 {
    color: #e6e6e6;
}

ul {
    list-style-type: none;
    padding: 0;
}

.events {
    margin: 0 20px 0 20px;
    margin-bottom: 1em;
    padding: 1em;
    border: 1px solid #444;
    border-radius: 5px;
}

p {
    margin: 0.5em 0;
}
</style>
    <h1>Jouw inschrijvingen</h1>
    <ul>
        @foreach($deelnemend as $event)
            <li class="events">
                <h2>{{ $event->name }}</h2>
                <p>Vanaf: {{ $event->start_time }}</p>
                <p>Tot: {{ $event->end_time }}</p>
                <p>Locatie: {{ $event->location }}</p>
                <p>Leeftijdsgroep: {{ $event->leeftijdsgroep }}</p>
            </li>
        @endforeach
    </ul>
@endsection