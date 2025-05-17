<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\QuizResult;

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
        // load every result with its user
        $all = QuizResult::with('user')->latest()->get();
        return response()->json($all);
    }

    public function summary(Request $request)
    {
        $userId = $request->user()->id;

        $q = QuizResult::where("user_id", $userId);

        $total = $q->count();
        $avg = $q->avg(DB::raw("score * 1.0 / total_questions"));
        $best = $q->max(DB::raw("score * 1.0 / total_questions"));

        return response()->json([
            'total_quizzes' => $total,
            'average' => round($avg * 100, 1),
            'best' => round($best * 100, 1),
        ]);
    }
}
