<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(QuestionService $questionService)
    {
        return $questionService->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request, QuestionService $questionService)
    {
        return $questionService->create($request->question, $request->type, $request->correct_answer, $request->answers);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
