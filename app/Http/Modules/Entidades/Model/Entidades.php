<?php

namespace App\Http\Modules\Entidades\Model;

use Illuminate\Database\Eloquent\Model;

class Entidades extends Model
{
    protected $table = "entidades";

    protected $fillable = [
        'nombre'
    ];
}
