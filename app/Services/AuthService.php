<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): ?User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'perfil' => $data['perfil'],
        ]);
    }

    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return [
                'message' => 'Credenciais inválidas.',
                'success' => false,
            ];
        }

        // Revoga todos os tokens já existentes para garantir que exista apenas uma sessão por usuário
        if ($user->tokens()->exists()) {
            $user->tokens()->delete();
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'success' => true,
        ];
    }
}
