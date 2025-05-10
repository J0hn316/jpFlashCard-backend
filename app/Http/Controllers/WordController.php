<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    /**
     * List all words.
     * GET /api/words
     */
    public function all(Request $request)
    {
        $perPage = $request->integer("per_page", 15);
        $search = trim($request->string("search"));

        $query = Word::query()->when($search !== '', fn($q) => $q->where('english', 'like', "{$search}%"));

        return $query->paginate($perPage)->appends($request->only(["per_page", "search"]));
    }

    /**
     * List words by unit with optional pagination and search.
     *
     * GET /api/words/{unit}?per_page=15&search=...
     */
    public function index(Request $request, $unit)
    {
        // 1) grab pagination & raw search term
        $perPage = $request->integer('per_page', 15);
        $search = trim($request->input('search', ''));

        // 2) build the base query (filter by unit)
        $query = Word::where('unit', $unit);

        // 3) if search isn’t empty, do a starts-with match on English
        if ($search !== '') {

            // $query->where('english', 'like', "{$search}%");
            // If you ever need to force a case-insensitive match
            // regardless of your DB’s collation, you can do:
            //
            $query->whereRaw(
                'LOWER(english) LIKE ?',
                [strtolower($search) . '%']
            );
        }
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
