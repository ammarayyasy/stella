<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);

Route::get('/about', function () {
    $categories = Category::all();
    return view('about', ['categories' => $categories]);
});

Route::get('/product/{category:slug}', [ProductController::class, 'index']);
Route::get('/contact',[ContactController::class, 'index']);