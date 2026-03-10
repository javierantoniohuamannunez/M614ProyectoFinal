<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumneController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\GrupController;

Route::get('/', function () {
    return view('welcome');
})->name('home');



// ALUMNES 
Route::get('/alumnes/create', [AlumneController::class, 'create'])->name('alumnes.create');
Route::get('/alumnes/{alumne}', [AlumneController::class, 'show'])->name('alumnes.show');
Route::get('/alumnes/{alumne}/edit', [AlumneController::class, 'edit'])->name('alumnes.edit');
Route::get('/alumnes', [AlumneController::class, 'index'])->name('alumnes.index');

// PROFESSORS
Route::get('/professors/create', [ProfessorController::class, 'create'])->name('professors.create');
Route::get('/professors/{professor}', [ProfessorController::class, 'show'])->name('professors.show');
Route::get('/professors/{professor}/edit', [ProfessorController::class, 'edit'])->name('professors.edit');
Route::get('/professors', [ProfessorController::class, 'index'])->name('professors.index');

// MÒDULS
Route::get('/moduls/create', [ModulController::class, 'create'])->name('moduls.create');
Route::get('/moduls/{modul}', [ModulController::class, 'show'])->name('moduls.show');
Route::get('/moduls/{modul}/edit', [ModulController::class, 'edit'])->name('moduls.edit');
Route::get('/moduls', [ModulController::class, 'index'])->name('moduls.index');

// GRUPS
Route::get('/grups/create', [GrupController::class, 'create'])->name('grups.create');
Route::get('/grups/{grup}', [GrupController::class, 'show'])->name('grups.show');
Route::get('/grups/{grup}/edit', [GrupController::class, 'edit'])->name('grups.edit');
Route::get('/grups', [GrupController::class, 'index'])->name('grups.index');

// RUTAS PROTEGIDAS
Route::middleware(['auth'])->group(function () {
    // Solo rutas POST, PUT, DELETE (las GET ya están arriba como públicas)
    Route::post('/alumnes', [AlumneController::class, 'store'])->name('alumnes.store');
    Route::put('/alumnes/{alumne}', [AlumneController::class, 'update'])->name('alumnes.update');
    Route::delete('/alumnes/{alumne}', [AlumneController::class, 'destroy'])->name('alumnes.destroy');
    
    Route::post('/professors', [ProfessorController::class, 'store'])->name('professors.store');
    Route::put('/professors/{professor}', [ProfessorController::class, 'update'])->name('professors.update');
    Route::delete('/professors/{professor}', [ProfessorController::class, 'destroy'])->name('professors.destroy');
    
    Route::post('/moduls', [ModulController::class, 'store'])->name('moduls.store');
    Route::put('/moduls/{modul}', [ModulController::class, 'update'])->name('moduls.update');
    Route::delete('/moduls/{modul}', [ModulController::class, 'destroy'])->name('moduls.destroy');
    
    Route::post('/grups', [GrupController::class, 'store'])->name('grups.store');
    Route::put('/grups/{grup}', [GrupController::class, 'update'])->name('grups.update');
    Route::delete('/grups/{grup}', [GrupController::class, 'destroy'])->name('grups.destroy');
});

require __DIR__.'/auth.php';