<?php

use Illuminate\Support\Facades\Route;

Route::get('/ping', function () {
    return response()->json('pong', 200);
});

Route::middleware('auth:api')->group(function () {
    // require __DIR__ . '/operadores/operadores.php'; 
    return response()->json('u are authenticated', 200);

});

Route::get('/login', function () {
    return response()->json('token not implemented yet');
});