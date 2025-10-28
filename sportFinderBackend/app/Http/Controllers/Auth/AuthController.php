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
    public function register(Request $request){
        $validated = Validator::make($request->all(), [
            'name'=> 'required',
            'email' => 'required|unique:users,email',
            'password'=> 'required',
            'password_confirmation'=> 'required',
            'perfil'=> 'sometimes',
            'documento'=> 'nullable'
        ], [
            'email.unique'=> 'Este endereço de E-mail já foi cadastrado',
        ]);

        if($validated->fails()){
            return response()->json([
                'status' => 'Falha',
                'message'=> $validated->errors()
            ],400);
        }

        $data = $validated->validated();
        unset($data['password_confirmation']);
        $data['perfil'] = $data['perfil'] ?? 'usuario';

        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return response()->json([
            'status'=> 'Sucesso',
            'message'=> 'Usuário criado com sucesso!'
        ],201);
    }

    public function login (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'email',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=> 'Falha',
                'message' => $validator->errors()
            ], 400);
        };

     
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            $user = Auth::user();
            $user->tokens()->delete();

            $response['token'] = $user->createToken('APIToken')->plainTextToken;
            $response['email'] = $user->email;

            return response()->json([
                'status' => 'success',
                'message'=>'Login successfully',
                'data'=> $response
            ],200);
        }else{
            return response()->json([
                'status' => 'Falha',
                'message' => 'Credenciais inválidas'
            ], 400);
        }
    }
}
