<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Quiz extends Model
{
    use HasFactory;

    public const QUESTION_COUNT = 10;
    
    protected $table = 'quizes';
    protected $fillable = ['session_id', 'is_finished', 'elapsed_time','first_name', 'last_name', 'email', 'score', 'questions_count', 'finished_at'];
    public function quizQuestions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class);
    }
    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class, QuizQuestion::class, 'quiz_id', 'id', 'id', 'question_id');
    }
}
