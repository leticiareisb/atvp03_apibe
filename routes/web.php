<?php

use App\Http\Controllers\UserController;

//Rota PUT
Route::put('/users/{id}', [UserController::class, 'update']);

//Rota DELETE
Route::delete('/users/{id}', [UserController::class, 'destroy']);

