<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Repositories\QuizRepository;
// use Carbon\Carbon;
use Exception;
use Illuminate\Support\Carbon;

class QuizService
{
    public function __construct(private QuizRepository $quizRepository)
    {
    }

    public function create($type, $session, $firstName, $lastName, $email)
    {
        $questions = Question::where('type', $type)->get()->pluck('id');
        if ($questions->count() < Quiz::QUESTION_COUNT) {
            throw new Exception('QUESTION_COUNT');
        }
        $questions = $questions->random(Quiz::QUESTION_COUNT);
        $quiz = $this->quizRepository->create($session->id, $firstName, $lastName, $email);
        $questions->each(fn ($item) => $this->quizRepository->createQuestion($quiz->id, $item));
        $quiz->load('questions');
        if ($type === 'boolean') {
            $quiz->questions->each(fn ($question) => $question->answers = collect([['id' => 1, 'answer' => 'yes'], ['id' => 0, 'answer' => 'no']]));
        } else {
            $quiz->questions->load('answers');
        }
        $quiz->questions = $quiz->questions->each(function ($question) {
            unset($question->correct_answer);
        });

        return $quiz;
    }

    public function finish($quizId, $session)
    {
        $quiz = $this->quizRepository->find($quizId);
        if ($session->id !== $quiz->session_id) {
            abort(403);
        }
        if ($quiz->is_finished) {
            abort(422);
        }

        $quiz->elapsed_time = $quiz['created_at']->diffInSeconds(Carbon::now());
        $quiz->is_finished = true;
        $quiz->finished_at = Carbon::now();
        $quiz->update();
        $answered = $quiz->quizQuestions->filter(fn ($question) => !is_null($question->was_correct))->count();
        $correct = $quiz->quizQuestions->filter(fn ($question) => $question->was_correct)->count();
        return ['answered' => $answered, 'correct' => $correct];
    }

    public function answerQuestion($questionId, $quizId, $answer, $session)
    {
        $quizQuestion = QuizQuestion::where(['quiz_id' => $quizId, 'question_id' => $questionId])->first();
        $quiz = $quizQuestion->quiz;
        if ($session->id !== $quiz->session_id) {
            abort(403);
        }
        if (isset($quizQuestion->bool_answer) || $quizQuestion->answer_id) {
            abort(404);
        }

        if ($quizQuestion->question->type === 'boolean') {
            $quizQuestion->bool_answer = $answer;
        } else {
            $quizQuestion->answer_id = $answer;
        }

        $wasCorrect = $quizQuestion->question->correct_answer === $answer;
        $quizQuestion->was_correct = $wasCorrect;
        $quizQuestion->update();
        $answered = $quiz->quizQuestions->filter(fn ($question) => !is_null($question->was_correct))->count();
        $correct = $quiz->quizQuestions->filter(fn ($question) => $question->was_correct)->count();
        $isQuizFinished = $answered === Quiz::QUESTION_COUNT;
        if ($isQuizFinished) {
            $quiz->is_finished = true;
            $quiz->elapsed_time = $quiz['created_at']->diffInSeconds(Carbon::now());
            $quiz->finished_at = Carbon::now();
        }
        if ($wasCorrect) $quiz->score = ++$quiz->score;
        $quiz->update();

        return ['answered' => $answered, 'correct' => $correct, 'isQuizFinished' => $isQuizFinished, 'correctAnswer' => $quizQuestion->question->correct_answer];
    }
}
