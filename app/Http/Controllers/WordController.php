<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    // GET  /api/words/{unit}
    public function index($unit)
    {
        $words = Word::where('unit', $unit)->get();
        return response()->json($words);
    }

    // POST /api/words
    public function store(Request $request)
    {
        $data = $request->validate([
            'unit' => 'required|string',
            'japanese' => 'required|string',
            'romaji' => 'required|string',
            'english' => 'required|string',
        ]);

        $word = Word::create($data);

        return response()->json($word, 201);
    }

    // Put /api/words/{word}
    public function update(Request $request, Word $word)
    {
        $data = $request->validate([
            'unit'     => 'sometimes|required|string',
            'japanese' => 'sometimes|required|string',
            'romaji'   => 'sometimes|required|string',
            'english'  => 'sometimes|required|string',
        ]);

        $word->update($data);

        return response()->json($word);
    }

    // Delete /api/words/{words}
    public function destroy(Word $word)
    {
        $word->delete();

        return response()->json(null, 204);
    }
}
