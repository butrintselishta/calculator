<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param array $payload
     * @return JsonResponse
    */
    public function register(array $payload): JsonResponse
    {
        try {
            $user = User::create([
                'name' => $payload['name'],
                'email' => $payload['email'],
                'password' => Hash::make($payload['password'])
            ]);

            return response()->success($user);
        } catch (\Throwable $th) {
            return response()->error('Failed to register the new user');
        }
    }

    /**
     * @param array $payload
     * @return JsonResponse
    */
    public function login(array $payload): JsonResponse
    {
        try{
            if(!Auth::attempt(['email' => $payload['email'], 'password' => $payload['password']])){
                return response()->error('Invalid credentials', 401);
            }

            $user = $this->userService->getByEmail($payload['email']);

            return response()->success([
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ]);
        } catch (\Throwable $th) {
            return response()->error('Login failed');
        }
    }
}
