<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['quiz_id', 'question_id', 'answer_id', 'bool_answer'];

    public function quiz(): BelongsTo {
        return $this->belongsTo(Quiz::class);
    }
    public function question(): BelongsTo {
        return $this->belongsTo(Question::class);
    }
}
