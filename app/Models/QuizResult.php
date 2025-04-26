<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit',
        'score',
        'total_questions',
        'missed_words',
    ];

    protected $casts = [
        'missed_words' => 'array',  // Eloquent will auto-convert JSON ↔ array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
