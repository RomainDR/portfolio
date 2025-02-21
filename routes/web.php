<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route pour afficher la page "add-project"
Route::get('/add-project', [ProjectController::class, 'showAddProjectForm'])->name('add-project.form');

// Route pour valider le mot de passe
Route::post('/validate-password', [ProjectController::class, 'validatePassword'])->name('validate-password');

// Route pour soumettre le formulaire de projet
Route::post('/add-project', [ProjectController::class, 'handleAddProjectForm'])->name('add-project.submit');
