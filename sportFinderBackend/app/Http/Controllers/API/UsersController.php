<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        $user = User::get();

        return response()->json([
            'status' => 'Sucesso',
            'Usuários'=> count($user),
            'message' => $user
        ], 200);
    }
    public function create()
    {
        //
    }
    public function show(string $id)
    {
        //
    }
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $validated = Validator::make($request->all(), [
            'name'=> 'sometimes',
            'email' => 'sometimes',
            'password'=> 'required',
            'password_confirmation'=> 'required',
            'perfil'=> 'sometimes',
            'document'=> 'nullable'
        ]);

        if($validated->fails()){
            return response()->json([
                "status" => "Falha",
                'message' => $validated->errors()
            ], 400);
        }

        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encntrado'
            ], 404);
        }

        $user->update($validated->validated());
        return response()->json([
            'status'=> 'Sucesso',
            'message'=> 'Usuário editado com sucesso'
        ], 201);
    }
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encontrado'
            ], 404);
        }

        $user->delete();
        return response()->json([
            'status'=> 'Sucesso',
            'message'=> 'Usuário deletado com sucesso!'
        ], 200);
    }
}
