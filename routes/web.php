<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\StudentController;

Route::get('/bai-4', [StudentController::class, 'bai4'])->name('students.bai4');