<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/add-project', [ProjectController::class, 'showAddProjectForm'])->name('add-project.form');
Route::post('/add-project', [ProjectController::class, 'handleAddProjectForm'])->name('add-project.submit');
Route::post('/validate-password', [ProjectController::class, 'validatePassword'])->name('validate-password');
