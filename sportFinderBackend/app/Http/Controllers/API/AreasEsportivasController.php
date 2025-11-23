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
            'endereco' => 'required|string',
            'cidade' => 'required|string|max:80',
            'cep' => 'required|string|max:20',
            'nota' => 'sometimes|nullable|numeric',

            'thumbnail' => 'nullable|image|max:2048',
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

        $area = AreasEsportivas::create($data);

        $imagemPath = null;

        if ($request->hasFile('thumbnail') && $request->file('thumbnail')->isValid()) {
            //     $file = $request->file('thumbnail');
            //     $fileName = time().'_'.$file->getClientOriginalName();

            //     $file->move(public_path('storage/imagens'), $fileName);

            //     $imagemPath = "storage/imagens/".$fileName;

            //     $area->imagens()->create([
            //     'thumbnail' => $imagemPath

            // ]);
            $path = $request->file('thumbnail')->store('imagens', 'public');
            $area->imagens()->create(['thumbnail' => 'storage/imagens/' . $path]);
        }

        return response()->json([
            'status' => 'Sucesso',
            'message' => 'Area esportiva criada com sucesso',
            'area' => $area->load('imagens')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = Auth::user(); 
        $area = AreasEsportivas::find($id);

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if ((int)$user->id !== (int) $area->id_administrador) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Sem permissão para esta operação.'
            ], 203);
        }

        if (!$area) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Área Esportiva não encontrada'
            ], 404);
        }
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
        $validator = Validator::make($request->all(), [
            'id_administrador' => 'required',
            'titulo' => 'sometimes|string',
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

        $area = AreasEsportivas::find($id);

        if (!$area) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Área Esportiva não encontrada'
            ], 404);
        }

        $area->update($validator->validate());

        return response()->json([
            'status' => 'Suceeso',
            'message' => 'Área esportiva atualizada com sucesso',
            'Area' => $area->titulo
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
