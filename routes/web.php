<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('levels');
});

// Ruta para mostrar la tabla de puntuaciones
Route::get('/index', [GameController::class, 'index']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'levels'])->name('levels');
Route::post('/save-score', [GameController::class, 'saveScore'])->name('save.score')->middleware('auth');
Route::get('/random-mode', function () {
    return view('random-mode');
})->name('random.mode');

Route::get('/game', [GameController::class, 'normalMode'])->name('game');

// Ruta para el modo aleatorio
Route::get('/random-mode', [GameController::class, 'randomMode'])->name('random-mode');
Route::get('/levels',[GameController::class,'levels'])->name('levels');
Route::get('/scores', [GameController::class, 'showScores'])->name('scores.index')->middleware('auth');
Route::post('/save-score', [GameController::class, 'storeScore'])->name('save.score');