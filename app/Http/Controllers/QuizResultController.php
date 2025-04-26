<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizResultController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            "unit" => "required|string",
            "score" => "required|integer|min:0",
            "total_questions" => "required|integer|min:1",
            "missed_words" => "nullable|array",
        ]);

        $result = $request->user()->quizResults()->create($data);

        return response()->json($result, 201);
    }

    public function index(Request $request)
    {
        return response()->json(
            $request->user()->quizResults()->latest()->get()
        );
    }
}
