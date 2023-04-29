<?php

namespace App\Repositories;

use App\Models\Answer;

class AnswerRepository {
    public function create($questionId, $answer): Answer {
        return Answer::create(['question_id' => $questionId, 'answer' => $answer]);
    }
    public function countByQuestion($questionId): int {
        return Answer::where('question_id', $questionId)->count();
    }
}
