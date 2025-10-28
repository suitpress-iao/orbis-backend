<?php

namespace App\Http\Modules\Operadores\Model;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\User\Models\User;
use App\Http\Modules\Entidades\Model\Entidades;
use App\Http\Modules\Cargos\Model\Cargos;

class Operadores extends Model
{
    protected $table = 'operadores';
    protected $fillable = [
        'user_id',
        'nombre',
        'apellido',
        'tipo_documento',
        'documento',
        'telefono',
        'email_recuperacion',
        'cargo_id',
    ];

    protected $appends = ['nombre_completo', 'tipo_documento_documento'];

    /**
     * Relación inversa con User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con Entidades
     */
    public function entidad()
    {
        return $this->belongsTo(Entidades::class, 'entidad_id'); //pertenece
    }

    /**
     * Relación con Cargo
     */
    public function cargo()
    {
        return $this->belongsTo(Cargos::class);
    }

    /**
     * Accessor para nombre completo
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    /**
     * Accessor para tipo documento y documento
     */
    public function getTipoDocumentoDocumentoAttribute(): string
    {
        return "{$this->tipo_documento} {$this->documento}";
    }

}
