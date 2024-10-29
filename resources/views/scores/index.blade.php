@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Puntuaciones</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>WPM</th>
                <th>Tiempo</th>
                <th>Nivel</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scores as $score)
            <tr>
                <td>{{ $score->user->name }}</td>
                <td>{{ $score->wpm }}</td>
                <td>{{ $score->time }}</td>
                <td>{{ $score->level }}</td>
                <td>{{ $score->created_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection