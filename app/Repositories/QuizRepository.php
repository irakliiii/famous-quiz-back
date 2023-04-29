<?php

namespace App\Repositories;

use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuizRepository
{
    public function create($sessionId, $firstName, $lastName, $email): Quiz
    {
        return Quiz::create([
            'session_id' => $sessionId, 'first_name' => $firstName, 'last_name' => $lastName, 'email' => $email, 'questions_count' => Quiz::QUESTION_COUNT
        ]);
    }
    public function find($quizId): Quiz
    {
        return Quiz::find($quizId);
    }
    public function createQuestion($quizId, $questionId): QuizQuestion
    {
        return QuizQuestion::create(['quiz_id' => $quizId, 'question_id' => $questionId]);
    }
    public function findQuestion($questionId): QuizQuestion
    {
        return QuizQuestion::find($questionId);
    }

    public function fetchSortedForScore()
    {
        return Quiz::all()->sortBy([['score', 'desc'], ['elapsed_time', 'asc']])->flatten();
    }
}
