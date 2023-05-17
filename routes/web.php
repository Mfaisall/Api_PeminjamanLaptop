<?php

use App\Http\Controllers\PeminjamanLaptopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/laptopall', [PeminjamanLaptopController::class,'index']);
//menambahkan data 
Route::post('/laptop/store', [PeminjamanLaptopController::class, 'store']);
//generate token
Route::get('/generate-token', [PeminjamanLaptopController::class, 'createToken']);
//menampilkan data per id 
Route::get('/laptop/{id}', [PeminjamanLaptopController::class, 'show']);
//update data
Route::patch('/laptop/update/{id}', [PeminjamanLaptopController::class, 'update']);
//delete data
Route::delete('/laptop/delete/{id}', [PeminjamanLaptopController::class, 'destroy']);
// untuk menampilkan datta hapus sementara
Route::get('/laptop/show/trash', [PeminjamanLaptopController::class, 'trash']);
// untuk mengembalikan data yang terhapus 
Route::get('/laptop/trash/restore/{id}', [PeminjamanLaptopController::class, 'restore']);
// untuk delete data permanent
Route::get('/laptop/trash/delete/permanen/{id}', [PeminjamanLaptopController::class, 'permanenDelete']);