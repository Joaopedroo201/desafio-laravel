<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Events\PasswordResetRequested;

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

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciais inválidas.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user'  => new \App\Http\Resources\UserResource($user),
            'token' => $token,
        ]);
    }

    public function forgot(ForgotPasswordRequest $request)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        $token = Str::random(60);

        // aqui você pode salvar o token numa tabela (opcional para o desafio)
        event(new PasswordResetRequested($user, $token));

        return response()->json(['message' => 'E-mail de recuperação enviado.']);
    }
}

