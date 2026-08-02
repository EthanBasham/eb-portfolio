<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Models\Page;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/about', function () {
    return view('pages.show', ['page' => Page::where('slug', 'about')->firstOrFail()]);
})->name('about');

Route::get('/resume', function () {
    return view('pages.show', ['page' => Page::where('slug', 'resume')->firstOrFail()]);
})->name('resume');

Route::middleware(['auth', 'can:manage-pages'])->group(function () {
    Route::get('/pages/{page:slug}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('/pages/{page:slug}', [PageController::class, 'update'])->name('pages.update');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
