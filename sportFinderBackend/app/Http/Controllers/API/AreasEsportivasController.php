<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AreasEsportivas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AreasEsportivasController extends Controller
{
    public function indexAll()
    {
        $areas = AreasEsportivas::with(['imagens', 'endereco'])->get();

        return response()->json([
            'status' => 'Sucesso',
            'message' => $areas
        ], 200);
    }
    public function index()
    {
         $user = Auth::user();
        $areas = AreasEsportivas::with(['imagens', 'endereco'])
            ->where('id_administrador', $user->id)
            ->get();

        return response()->json([
            'status' => 'Sucesso',
            'message' => $areas
        ], 200);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if ((int)$user->id !== (int) $request->id_administrador) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Sem permissão para esta operação.'
            ], 203);
        }

        $validator = Validator::make($request->all(), [
            'id_administrador' => 'required|numeric',
            'titulo' => 'required|string',
            'descricao' => 'sometimes|nullable|string|max:500',
            'nota' => 'sometimes|nullable|numeric',

            'rua' => 'required|string',
            'numero' => 'sometimes|numeric',
            'bairro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string|max:2',
            'cep' => 'required|string|max:20',
            'complemento' => 'sometimes|nullable|string',
            'lon' => 'numeric',
            'lat' => 'numeric',

            'thumbnail' => 'nullable|image|max:2048',
        ], [
            '*.required' => 'Campo obrigatório',
            'descricao.max' => 'Máximo de 500 caracteres',
            'estado.max' => 'Máximo 2 caracteres',
            'cep.max' => 'Máximo 20 caracteres'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 400);
        }

         $area = AreasEsportivas::create([
            'id_administrador' => $request->id_administrador,
            'titulo' => $request->titulo,
            'descricao' => $request->descricao,
            'nota' => $request->nota
        ]);

        $area->endereco()->create([
            'rua' => $request->rua,
            'numero' => $request->numero,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
            'cep' => $request->cep,
            'complemento' => $request->complemento,
            'lon' => $request->has('lon') ? (float) $request->lon : null,
            'lat' => $request->has('lat') ? (float) $request->lat : null,
        ]);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('imagens', 'public');
            $area->imagens()->create(['thumbnail' => 'storage/imagens/' . $path]);
        }
        $imagemPath = null;

        // if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            //     $file = $request->file('thumbnail');
            //     $fileName = time().'_'.$file->getClientOriginalName();

            //     $file->move(public_path('storage/imagens'), $fileName);

            //     $imagemPath = "storage/imagens/".$fileName;

            //     $area->imagens()->create([
            //     'thumbnail' => $imagemPath

            // ]);
            // $path = $request->file('thumbnail')->store('imagens', 'public');
            // $area->imagens()->create(['thumbnail' => 'storage/imagens/' . $path]);
        // }

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Área esportiva criada com sucesso',
            'area' => $area->load(['endereco', 'imagens'])
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = Auth::user(); 
        $area = AreasEsportivas::with(['endereco', 'imagens'])->find($id);

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if (!$area) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Área Esportiva não encontrada'
            ], 404);
        }

        // if ((int)$user->id !== (int) $area->id_administrador) {
        //     return response()->json([
        //         'status' => 'Falha',
        //         'message' => 'Sem permissão para esta operação.'
        //     ], 203);
        // }

        return response()->json([
            'status' => 'Sucesso',
            'message' => $area
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $area = AreasEsportivas::with('endereco')->find($id);

        if (!$area) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Área Esportiva não encontrada'
            ], 404);
        }

        // Validação
        $validator = Validator::make($request->all(), [
            'titulo' => 'sometimes|string|max:255',
            'descricao' => 'sometimes|nullable|string|max:500',
            'nota' => 'sometimes|nullable|numeric|between:0,5',

            // Endereço
            'rua' => 'sometimes|string',
            'numero' => 'sometimes|numeric',
            'bairro' => 'sometimes|string',
            'cidade' => 'sometimes|string',
            'estado' => 'sometimes|string|max:2',
            'cep' => 'sometimes|string|max:20',
            'complemento' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'Falha',
                'message' => $validator->errors()
            ], 400);
        }

        // Atualizar a área esportiva
        $area->update($request->only(['titulo', 'descricao', 'nota']));

        // Atualizar endereço
        if ($area->endereco) {
            $area->endereco->update($request->only([
                'rua', 'numero', 'bairro', 'cidade', 'estado', 'cep', 'complemento'
            ]));
        }

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Área esportiva atualizada com sucesso',
            'area' => $area->load('endereco')
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $areas = AreasEsportivas::find($id);

        if (!$areas) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Área esportiva não encontrada'
            ], 404);
        }

        $areas->delete();
        
        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Área Esportiva deletada com sucesso!',
            'Deleted' => $areas->titulo
        ], 200);
    }
}
