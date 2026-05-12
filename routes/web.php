<?php

use App\Http\Controllers\ConceptController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    // Domains CRUD
    Route::resource('domains', DomainController::class);

    // Concepts imbriqués dans un domaine (create, store, index)
    Route::get('domains/{domain}/concepts', [ConceptController::class, 'index'])->name('concepts.index');
    Route::get('domains/{domain}/concepts/create', [ConceptController::class, 'create'])->name('concepts.create');
    Route::post('domains/{domain}/concepts', [ConceptController::class, 'store'])->name('concepts.store');

    // Concepts indépendants (show, edit, update, destroy)
    Route::get('concepts/{concept}', [ConceptController::class, 'show'])->name('concepts.show');
    Route::get('concepts/{concept}/edit', [ConceptController::class, 'edit'])->name('concepts.edit');
    Route::put('concepts/{concept}', [ConceptController::class, 'update'])->name('concepts.update');
    Route::delete('concepts/{concept}', [ConceptController::class, 'destroy'])->name('concepts.destroy');

    // Génération IA (spec 04)
    Route::post('concepts/{concept}/generate', [QuestionController::class, 'store'])->name('questions.generate');
    Route::delete('generated-questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
});

require __DIR__.'/auth.php';
