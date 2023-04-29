<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountRepository {
    public function create($data): User {
        return User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => Hash::make($data['password'])]);
    }

    public function findByEmail(string $email): User|null {
        return User::where('email', $email)->first();
    }
}
