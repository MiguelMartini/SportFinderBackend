<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    private function getCoordinatesFromCity($city)
    {
        $url = "https://nominatim.openstreetmap.org/search?city="
            . urlencode($city)
            . "&country=Brazil&format=json&limit=1";

        $response = Http::withHeaders([
            'User-Agent' => 'SeuApp/1.0'
        ])->get($url);

        $data = $response->json();

        if (!$response->ok() || empty($data)) {
            return null;
        }

        return [
            'lat' => $data[0]['lat'],
            'lon' => $data[0]['lon']
        ];
    }
    public function show(string $id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if ((int)$user->id !== (int) $id) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Sem permissão para esta operação.',
            ], 203);
        }

        return response()->json([
            'status' => 'Sucesso',
            'message' => $user->only(["id", "name", "email", "phone", "role", "instagram", "documento", "city", "lon", "lat"])
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
            'email' => 'sometimes|email',
            'password' => 'required|confirmed',
            'phone'  => 'sometimes|string',
            'role' => 'sometimes',
            'city' => 'sometimes|string',
            'documento' => 'required_if:role,admin',
            'instagram' => 'sometimes|string'
        ], [
            'email.email' => 'O campo email deve ser um email válido.',
            'password.confirmed' => 'As senhas não coincidem',
            'documento.required_if' => 'O documento é obrigatório para administradores.'
        ]);

        if ($validated->fails()) {
            return response()->json([
                "status" => "Falha",
                'message' => $validated->errors()
            ], 400);
        }

        $data = $validated->validate();

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não encntrado'
            ], 404);
        }

        if (isset($data['city'])) {
            $coords = $this->getCoordinatesFromCity($data['city']);

            if (!$coords) {
                return response()->json([
                    'status' => 'Falha',
                    'message' => 'Cidade não encontrada no Nominatim.'
                ], 400);
            }

            $data['lat'] = $coords['lat'];
            $data['lon'] = $coords['lon'];
        }

        $user->update($data);
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