<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\HomeController;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes pour le CRUD des projets
Route::get('/add-project', [ProjectController::class, 'showAddProjectForm'])->name('add-project.form');
Route::post('/add-project', [ProjectController::class, 'handleAddProjectForm'])->name('add-project.submit');
Route::post('/validate-password', [ProjectController::class, 'validatePassword'])->name('validate-password');

// Routes pour l'édition et la suppression
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
