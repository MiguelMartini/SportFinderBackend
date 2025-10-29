<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AreasEsportivas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AreasEsportivasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = AreasEsportivas::get();

        return response()->json([
            'status' => 'Sucesso',
            'message' => $areas
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
        $validator = Validator::make($request->all(), [
            'id_administrador' => 'required|numeric',
            'titulo' => 'required|string',
            'descricao' => 'sometimes|nullable|string',
            'endereco' => 'sometimes|nullable|string',
            'cidade' => 'sometimes|nullable|string',
            'cep' => 'sometimes|nullable|string',
            'nota' => 'sometimes|nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 400);
        }

        $data['id_administrador'] = $request->id_administrador;
        $data['titulo'] = $request->titulo;
        $data['descricao'] = $request->descricao;
        $data['endereco'] = $request->endereco;
        $data['cidade'] = $request->cidade;
        $data['cep'] = $request->cep;
        $data['nota'] = $request->nota;



        AreasEsportivas::create($data);

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Area esportiva criada com sucesso'
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
