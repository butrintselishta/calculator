<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserService
{
    /**
     * Get authenticated user
     * @return Model
     */
    public function getAuthenticatedUser(): Model
    {
        $user = User::with('calculations')->find(auth()->id());
        if(!$user) {
            return response()->error('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * Find user by email
     * @param string $email
     * @return User|JsonResponse
     */
    public function getByEmail(string $email): User|JsonResponse
    {
        $user = User::where('email', $email)->first();
        if(!$user) {
            return response()->error('User not found', Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * Store calculations to track the user
     * @param string $expression
     * @param int $result
     * @return void
     */
    public function trackUsersCalculation(string $expression, int|string $result): void
    {
        $user = $this->getAuthenticatedUser();
        $user->calculations()->create([
            'expression' => $expression,
            'result' => $result,
        ]);
    }
}
