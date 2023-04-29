<?php

namespace App\Repositories;

use App\Models\Question;

class QuestionRepository {
    public function create($question, $type, $correctAnswer): Question {
        return Question::create(['question' => $question, 'type' => $type, 'correct_answer' => $correctAnswer]);
    }
    public function findQuestion($questionId): Question {
        return Question::find($questionId);
    }
}
