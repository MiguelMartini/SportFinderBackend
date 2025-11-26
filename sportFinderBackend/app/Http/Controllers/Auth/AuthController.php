<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|confirmed',
            'role' => 'sometimes'
        ], [
            'name.required' => 'Campo de nome obrigatório',
            'email.unique' => 'Este endereço de E-mail já foi cadastrado',
            'email.required' => 'Campo de e-mail obrigatório',
            'password.confirmed' => 'As senhas não correspondem',
            'password.required' => 'Campo de senha é obrigatório'
        ]);

        if ($validated->fails()) {
            return response()->json([
                'status' => 'Falha',
                'message' => $validated->errors()
            ], 400);
        }

        $data = $validated->validated();
        $data['role'] = $data['role'] ?? 'usuario';

        User::create($data);

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário criado com sucesso!'
        ], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email',
            'password' => 'required|string'
        ], [
            'email.required' => 'Campo de e-mail obrigatório',
            'email.email' => 'Endereço de e-mail deve ser válido',
            'password.required' => 'Campo de senha obrigatório'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 400);
        };


        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $user->tokens()->delete();

            $response['token'] = $user->createToken('APIToken')->plainTextToken;
            $response['id'] = $user->id;
            $response['email'] = $user->email;

            return response()->json([
                'status' => 'success',
                'message' => 'Login successfully',
                'data' => $response
            ], 200);
        } else {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Credenciais inválidas'
            ], 400);
        }
    }

    public function logout()
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Logout realizado com sucesso'
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
