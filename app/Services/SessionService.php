<?php

namespace App\Services;


use App\Repositories\SessionRepository;

class SessionService {
    public function __construct(private SessionRepository $sessionRepository)
    {
    }

    public function create() {
        return $this->sessionRepository->create();
    }
}
