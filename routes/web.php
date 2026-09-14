<?php

use App\Http\Controllers\RepairRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - ระบบแจ้งซ่อมอุปกรณ์ IT
|--------------------------------------------------------------------------
*/

Route::get('/', [RepairRequestController::class, 'index'])->name('repairs.index');
Route::get('/repairs/create', [RepairRequestController::class, 'create'])->name('repairs.create');
Route::post('/repairs', [RepairRequestController::class, 'store'])->name('repairs.store');
Route::get('/repairs/{repair}/edit', [RepairRequestController::class, 'edit'])->name('repairs.edit');
Route::put('/repairs/{repair}', [RepairRequestController::class, 'update'])->name('repairs.update');
Route::delete('/repairs/{repair}', [RepairRequestController::class, 'destroy'])->name('repairs.destroy');
