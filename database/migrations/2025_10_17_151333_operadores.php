<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        schema::create('operadores', function (blueprint $table){
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('entidad_id');
            $table->unsignedBigInteger('cargo_id');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            $table->foreign('entidad_id')
                  ->references('id')->on('entidades')
                  ->onDelete('restrict'); 

            $table->foreign('cargo_id')
                  ->references('id')->on('cargos')
                  ->onDelete('restrict');         
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operadores');
    }
};
