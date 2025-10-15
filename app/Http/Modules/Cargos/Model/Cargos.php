<?php

namespace App\Http\Modules\Cargos\Model;

use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
    protected $table = "cargos";

    protected $fillable = [
        'nombre'
    ];
}
