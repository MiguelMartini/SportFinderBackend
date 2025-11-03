<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();

        if(!$user){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Usuário não autenticado'
            ], 401);
        }

        if(!in_array($user->role, $roles)){
            return response()->json([
                'status' => 'Falha',
                'message' => 'Você não esta permitido para acessar esta operação'
            ],403);
        }

        if(empty($user->documento)){
            return response()->json([
                'status' => 'Falha',
                'message' => 'É necessário possuir um documento (CPF/CNPJ) para realizar esta operação'
            ],403);
        }
        
        return $next($request);
    }
}
