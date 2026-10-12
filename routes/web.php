<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicalCaseController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('cases.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $counts = [
            'total' => \App\Models\MedicalCase::count(),
            'planning' => \App\Models\MedicalCase::where('status', 'Planning')->count(),
            'in_review' => \App\Models\MedicalCase::where('status', 'In Review')->count(),
            'approved' => \App\Models\MedicalCase::where('status', 'Approved')->count(),
            'completed' => \App\Models\MedicalCase::where('status', 'Completed')->count(),
        ];

        return view('dashboard', compact('counts'));
    })->name('dashboard');

    Route::resource('cases', MedicalCaseController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])
    ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');
});

require __DIR__.'/auth.php';
