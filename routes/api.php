<?php

use App\Http\Controllers\Api\CuacaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Endpoint publik untuk data cuaca.
| Tidak perlu auth — data cuaca bersifat umum untuk semua petani.
|
*/

Route::get('/cuaca/{kota}', [CuacaController::class, 'index'])
    ->name('api.cuaca.index');
