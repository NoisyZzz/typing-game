<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;

class GameController extends Controller
{
    public function index() {
        $scores = Score::with('user')->orderBy('wpm', 'desc')->get();
        return response()->json($scores);
    }

    
    public function store(Request $request) {
        $request->validate([
            'wpm' => 'required|integer',
            'time' => 'required|integer',
        ]);

        $score = new Score();
        $score->user_id = auth()->user()->id;  
        $score->wpm = $request->wpm;
        $score->time = $request->time;
        $score->save();

        return response()->json(['message' => 'Puntuación guardada con éxito']);
    }
    public function saveScore(Request $request) {
        $request->validate([
            'score' => 'required|integer',
            'level' => 'required|integer'  
        ]);
    
        $score = Score::where('user_id', auth()->user()->id)
                      ->where('level', $request->level)
                      ->first();
    
        if ($score) {
            if ($request->score < $score->time) {  
                $score->wpm = $request->score;  
                $score->save();
            }
        } else {
            $score = new Score();
            $score->user_id = auth()->user()->id;
            $score->wpm = $request->score;
            $score->level = $request->level;  
            $score->time = 60;  // Aquí se guarda el tiempo como 60
            $score->save();
        }
    
        return response()->json(['message' => 'Puntuación guardada con éxito']);
    }
    public function normalMode()
    {
        return view('game');
    }

    public function randomMode()
    {
        return view('random-mode');
    }

    public function storeScore(Request $request)
    {
     $request->validate([
        'score' => 'required|integer',
        'level' => 'required|integer'
        ]);

        // Verifica si el usuario está autenticado
        if (auth()->check()) {
        $score = new Score();
        $score->user_id = auth()->user()->id;
        $score->wpm = $request->score; // Guarda la velocidad en palabras por minuto
        $score->level = $request->level;
        $score->time = $request->time ?? 60; // Asegúrate de pasar el tiempo, o usa un valor predeterminado
        $score->save();

            return response()->json(['message' => 'Puntuación guardada con éxito']);
        } else {
            return response()->json(['message' => 'Usuario no autenticado'], 403);
        }
    }
    public function levels()
    {
        return view('levels');
    }
    public function showScores()
    {
        $scores = Score::with('user')->orderBy('wpm', 'desc')->get();
        return view('index', compact('scores')); // Asegúrate de que 'index' se refiere a la vista correcta
    }

}
