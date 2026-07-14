<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SectorController;

Route::resource('sectors', SectorController::class);
// Tambahkan 2 rute ini untuk simulasi IoT
Route::post('/sectors/{sector}/siram', [SectorController::class, 'siram']);
Route::post('/sectors/{sector}/set-kelembaban', [SectorController::class, 'setKelembaban']);

Route::get('/', function () { return redirect('/sectors'); });