<?php

use App\Http\Controllers\QuickFsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard', ['summary' => []]);
})->name('dashboard');

Route::get(
    '/summary',
    [
        QuickFsController::class,
        'summary'
    ])
    ->name('summary')
    ->middleware(
        [
            'auth:sanctum',
            'verified'
        ]
    );
