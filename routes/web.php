<?php

/*
Autor: Franklin Valoyes López <franklin032010@hotmail.com>
*/

use Illuminate\Support\Facades\Route;

// Menciono los controladores a usar

use App\Http\Controllers\UserController;

use App\Http\Controllers\Tipo_documentoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('api/usuarios', UserController::class);

Route::resource('api/tipo_documento', Tipo_documentoController::class);
