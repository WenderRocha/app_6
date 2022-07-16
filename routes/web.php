<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PermissionController;

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
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/components/buttons', function () {
    return Inertia::render('Components/Buttons');
})->middleware(['auth', 'verified'])->name('components.buttons');


/*
|--------------------------------------------------------------------------
|  Permission Controller
|--------------------------------------------------------------------------
*/
Route::group([

    'middleware' => ['auth', 'verified'],
    'prefix' => 'app',

], function () {

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/{id}', [PermissionController::class, 'show'])->name('permissions.show');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::put('/permission/{id}', [PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/permission/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    Route::delete('/permission', [PermissionController::class, 'destroyAll'])->name('permissions.destroyAll');
});

require __DIR__ . '/auth.php';