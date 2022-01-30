<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function checkEmailDuplicate($email)
    {
        return User::where('email', $email)->first();
    }

    public function findEmail($email)
    {
        return $this->checkEmailDuplicate($email);
    }

}
