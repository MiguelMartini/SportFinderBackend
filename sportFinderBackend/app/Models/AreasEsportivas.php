<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreasEsportivas extends Model
{
    protected $fillable = [
        'id_administrador',
        'titulo',
        'descricao',
        'cidade',
        'cep',
        'nota'
    ];
        
}
