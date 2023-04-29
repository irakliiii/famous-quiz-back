<?php

namespace App\Http\Controllers;

use App\Services\StatsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class StatsController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(StatsService $statsService) {
        return $statsService->index();
    }
    public function indexDetailed(StatsService $statsService) {
        return $statsService->indexDetailed();
    }
}
