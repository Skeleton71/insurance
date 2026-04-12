<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\OwnerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/cars');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:5|confirmed',
        'role' => 'required|in:admin,editor,visitor',
    ]);

    $user = App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => $validated['role'],
    ]);

    Auth::login($user);

    return redirect('/cars');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Illuminate\Http\Request $request) {
    $request->validate(['email' => 'required|email|exists:users']);
    return back()->with('status', 'If that email address is in our database, we will send you a password reset link.');
})->name('password.email');

Route::get('/', function () {
    return redirect('/cars');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect('/cars');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

    Route::put('/profile', function (Illuminate\Http\Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update($request->only(['name', 'email']));

        return back()->with('status', 'Profile updated!');
    })->name('profile.update');

    Route::delete('/profile', function (Illuminate\Http\Request $request) {
        $password = $request->validate(['password' => 'required|current_password'])['password'];

        $user = Auth::user();
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    })->name('profile.destroy');
});

Route::resource('owners', OwnerController::class);
Route::resource('cars', CarController::class);