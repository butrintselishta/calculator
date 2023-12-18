<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\FlareClient\Http\Exceptions\NotFound;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService
{
    /**
     * Find user by email
     * @param string $email
     * @return JsonResponse
     */
    public function getByEmail(string $email): User|JsonResponse
    {
        $user = User::where('email', $email)->first();
        if(!$user) {
            return response()->error('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }
}
