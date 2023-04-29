<?php

namespace App\Services;

use App\Models\Question;
use App\Repositories\AnswerRepository;
use App\Repositories\QuestionRepository;

class QuestionService
{
    public function __construct(private QuestionRepository $questionRepository, private AnswerRepository $answerRepository)
    {
    }

    public function index()
    {
        return Question::all()->load('answers');
    }

    public function create($question, $type, $correctAnswer, $answers = null)
    {
        $question = $this->questionRepository->create($question, $type, $correctAnswer);

        if ($question->type === 'answers') {
            collect($answers)->each(fn ($answer) => $this->answerRepository->create($question->id, $answer));
        }

        $question->load('answers');

        return $question;
    }
}
