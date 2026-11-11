<?php

use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FoodController::class, 'index'])->name('foods.index');
Route::get('/foods/create', [FoodController::class, 'create'])->name('foods.create');
Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
Route::put('/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
