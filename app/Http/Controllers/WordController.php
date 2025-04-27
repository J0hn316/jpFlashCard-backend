<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * List words by unit with optional pagination and search.
     *
     * GET /api/words/{unit}?per_page=15&search=...
     */
    public function index(Request $request, $unit)
    {
        // Number of items per page (default is 15)
        $perPage = $request->integer('per_page', 15);

        // Optional search term
        $search = $request->string('search');

        $query = Word::where('unit', $unit)->when($search, function ($q, $s) {
            $q->where('english', 'like', "%{$s}%")->orWhere('japanese', 'like', value: "%{$s}%");
        });

        // Paginate results and preserve query parameters.
        $paginated = $query->paginate($perPage)->appends($request->only(["per_page", "search"]));

        return response()->json($paginated);
    }

    /**
     * Create a new word.
     *
     * POST /api/words
     */
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

    /**
     * Update an existing word.
     *
     * PUT /api/words/{word}
     */
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

    /**
     * Delete a word.
     *
     * DELETE /api/words/{word}
     */
    public function destroy(Word $word)
    {
        $word->delete();

        return response()->json(null, 204);
    }
}
