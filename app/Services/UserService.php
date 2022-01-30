<?php

namespace App\Services;
use App\Models\User;
use App\Services\BaseService;

class UserService extends BaseService
{

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function subRetry(User $userAccount, int $sub)
    {
        if ($userAccount->login_retry > 0 && $userAccount->status != 'locked') {
            $userAccount->login_retry = ($userAccount->login_retry - $sub);
            $userAccount->save();
            return true;
        } else {
            $userAccount->status = 'locked';
            $userAccount->save();
            return false;
        }
    }

    public function resetRetry(User $user)
    {
        $user->login_retry = 5;
        return $user->save();
    }

}
