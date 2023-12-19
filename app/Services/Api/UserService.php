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
     * Get authenticated user
     * @return User
     */
    private function getAuthenticatedUser(): User
    {
        return auth()->user();
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
