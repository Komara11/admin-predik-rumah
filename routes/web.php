<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatasetController;
use App\Http\Controllers\SettingsController;

Route::redirect('/', '/login');

// ── Auth Routes ──────────────────────────────────────────────────────
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('login.submit');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// ── Protected Admin Routes ───────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/guide', [DashboardController::class, 'guide'])->name('admin.guide');

    Route::get('/dataset', [DatasetController::class, 'index'])->name('admin.dataset');
    Route::post('/dataset/upload', [DatasetController::class, 'upload'])->name('admin.dataset.upload');
    Route::delete('/dataset/{property}', [DatasetController::class, 'destroy'])->name('admin.dataset.destroy');

    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/retrain', [SettingsController::class, 'retrain'])->name('admin.settings.retrain');
});
