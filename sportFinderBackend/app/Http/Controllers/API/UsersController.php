<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function show(string $id)
    {
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if ((int)$user->id !== (int) $id) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Sem permissão para esta operação.'
            ], 203);
        }

        return response()->json([
            'status' => 'Sucesso',
            'message' => $user->only(["name", "email", "role", "documento"])
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        if ((int)$user->id !== (int) $id) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Sem permissão para esta operação.'
            ], 203);
        }

        $validated = Validator::make($request->all(), [
            'name' => 'sometimes',
            'email' => 'sometimes',
            'password' => 'required|confirmed',
            'role' => 'sometimes',
            'documento' => 'nullable'
        ],[
            'password.required' => 'Preencha todos os campos obrigatórios',
            'password.confirmed' => 'As senhas não coincidem'
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => "Falha",
                'message' => $validated->errors()
            ], 400);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encntrado'
            ], 404);
        }

        $user->update($validated->validated());
        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário editado com sucesso'
        ], 201);
    }

    public function destroy(string $id)
    {
        $user = Auth::user();

        if ((int)$user->id !== (int) $id) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Sem permissão para esta operação.'
            ], 203);
        }

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        $user->delete();
        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Usuário deletado com sucesso!'
        ], 200);
    }
}
