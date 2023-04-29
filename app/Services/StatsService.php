<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Session;
use App\Repositories\QuizRepository;

class StatsService
{
    public function __construct(private QuizRepository $quizRepository)
    {
    }

    public function index()
    {
        $quizes = $this->quizRepository->fetchSortedForScore();
        $data = $quizes->map(fn ($item) => $item->only(['first_name', 'score', 'email', 'elapsed_time']));
        return $data;
    }
    public function indexDetailed()
    {
        $quizes = $this->quizRepository->fetchSortedForScore();
        $data = $quizes->map(fn ($item) => $item->only(['first_name', 'last_name', 'score', 'email', 'elapsed_time', 'finished_at']));
        return $data;
    }
}
