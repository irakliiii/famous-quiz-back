<?php

namespace App\Http\Controllers;

use App\Services\QuizService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class QuizController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function create(Request $request, QuizService $quizService)
    {
        $request->validate([
            'type' => 'required|in:boolean,answers',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
        ]);

        return $quizService->create($request->type, $request->session, $request->first_name, $request->last_name, $request->email);
    }
    public function finish(Request $request, $quizId, QuizService $quizService)
    {
        return $quizService->finish($quizId, $request->session);
    }
    public function answerQuestion(Request $request, $quizId, $questionId, QuizService $quizService)
    {
        $request->validate([
            'answer' => 'required',
        ]);
        return $quizService->answerQuestion($questionId, $quizId, $request->answer, $request->session);
    }
}
