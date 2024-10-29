@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tabla de Puntuaciones</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Palabras por minuto (WPM)</th>
                <th>Tiempo (segundos)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scores as $score)
                <tr>
                    <td>{{ $score->user->name }}</td>
                    <td>{{ $score->wpm }}</td>
                    <td>{{ $score->time }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection