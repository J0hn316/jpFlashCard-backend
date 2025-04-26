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
}
