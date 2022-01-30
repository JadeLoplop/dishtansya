<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendEmail;
use Carbon\Carbon;

class RegisterController extends Controller
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
            $checkDuplicateEmail = $this->repository->checkEmailDuplicate($request->email);
            if ($checkDuplicateEmail) {
               return response()->json(['message' => 'Email already taken.'], 400);
            }
            $data = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            $register = $this->service->store($data);

            if ($register) {
                $this->enqueue($register);
            }

            return response()->json(['message' => 'User successfully registered.'], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    public function enqueue($details)
    {
        $emailJob = (new SendEmail($details))->delay(Carbon::now()->addSeconds(10));
        dispatch($emailJob);
    }
}
