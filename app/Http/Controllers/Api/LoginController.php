<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Auth;

class LoginController extends Controller
{
    private $service;
    private $repository;

    public function __construct(UserService $userService, UserRepository $userRepository)
    {
        $this->middleware('guest');
        $this->service = $userService;
        $this->repository = $userRepository;
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            $userAccount = $this->repository->findEmail($request->email);
            if ($userAccount) {
                $subRes = $this->service->subRetry($userAccount, 1);
                if (!$subRes) {
                    return response()->json(['message' => 'User account was temporarily locked.'], 401);
                }
            }
            if (Auth::attempt($credentials)) {
                $user = $this->repository->getById(auth()->user()->id);
                $this->service->resetRetry($user);
                return response()->json([
                    'access_token' => $user->createToken('appToken')->accessToken,
                ]);
                return response()->json(['access_token' => $user->createToken('appToken')->accessToken], 201);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }

    }
}
