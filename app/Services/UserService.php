<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        if (!isset($data['uuid'])) {
            $data['uuid'] = (string)Str::uuid();
        }

        // Type casting for create which returns Model
        /** @var User $user */
        $user = $this->userRepository->create($data);
        return $user;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}