<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreasEsportivas extends Model
{
    protected $fillable = [
        'id_administrador',
        'titulo',
        'descricao',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_administrador');
    }

    public function endereco()
    {
        return $this->hasOne(Endereco::class, 'area_esportiva_id');
    }
}
