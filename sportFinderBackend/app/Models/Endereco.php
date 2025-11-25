<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $fillable = [
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'complemento',
        'area_esportiva_id',
        'lat',
        'lon'
    ];
    public function areaEsportiva()
    {
        return $this->belongsTo(AreasEsportivas::class, 'area_esportiva_id');
    }

}
