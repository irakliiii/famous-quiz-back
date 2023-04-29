<?php

namespace App\Repositories;

use App\Models\Session;
use Illuminate\Support\Str;

class SessionRepository {
    public function create(): Session {
        return Session::create(['token' => (string) Str::orderedUuid()]);
    }
    public function find($token) {
        return Session::where('token', $token)->first();
    }
}
