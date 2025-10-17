<?php

namespace App\Http\Modules\Operadores\Model;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\User\Models\User;
use App\Http\Modules\Entidades\Model\Entidades;
use App\Http\Modules\Cargos\Model\Cargos;

class Operadores extends Model
{
    protected $table = 'operadores';
    protected $fillable = ['user_id', 'entidad_id', 'cargo_id'];

    public function user()
    {
        return $this->belongsTo(\App\Http\Modules\User\Models\User::class, 'user_id');
    }

      public function entidad()
    {
        return $this->belongsTo(\App\Http\Modules\Entidades\Model\Entidades::class, 'entidad_id'); //pertenece
    }

    public function cargo()
    {
        return $this->belongsTo(\App\Http\Modules\Cargos\Model\Cargos::class, 'cargo_id');
    }

}
