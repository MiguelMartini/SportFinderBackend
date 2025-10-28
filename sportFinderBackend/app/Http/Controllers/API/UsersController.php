<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::get();

        return response()->json([
            'status' => 'Sucesso',
            'Usuários'=> count($user),
            'message' => $user
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'name'=> 'required',
            'email' => 'required|unique:users,email',
            'password'=> 'required',
            'password_confirmation'=> 'required',
            'perfil'=> 'sometimes',
            'document'=> 'nullable'
        ], [
            'email.unique'=> 'Este endereço de E-mail já foi cadastrado',
        ]);

        if($validated->fails()){
            return response()->json([
                'status' => 'Falha',
                'message'=> $validated->errors()
            ],400);
        }

        $data['perfil'] = $data['perfil'] ?? 'usuario';
        $data = $validated->validated();


        User::create($data);

        return response()->json([
            'status'=> 'Sucesso',
            'message'=> 'Usuário criado com sucesso!'
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
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
