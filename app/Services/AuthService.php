<?php

namespace App\Services;


use App\Repositories\AccountRepository;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthService {
    public function __construct(private AccountRepository $accountRepository)
    {
    }

    public function login($data) {
        $account = $this->accountRepository->findByEmail($data['email']);

        if (!$account || !Hash::check($data['password'], $account->password)) {
            throw new NotFoundHttpException();
        }

        return ['token' => $account->createToken('name'), 'name' => $account['name']];
    }
}
