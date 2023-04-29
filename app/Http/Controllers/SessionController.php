<?php

namespace App\Http\Controllers;

use App\Services\SessionService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SessionController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function create(SessionService $sessionService) {
        return $sessionService->create();
    }
}
