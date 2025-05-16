<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());

        if (!$user) {
            return response()->json(['message' => 'CEP inválido ou erro ao buscar endereço.'], 422);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user'  => new UserResource($user),
            'token' => $token,
        ]);
    }
}

