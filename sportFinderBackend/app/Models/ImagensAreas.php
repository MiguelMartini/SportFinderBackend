<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagensAreas extends Model
{
    protected $fillable = [
        'id_area',
        'thumbnail'
    ];

    public function areaEsportiva()
    {
        return $this->belongsTo(ImagensAreas::class, 'id_area');
    }
}
