<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;
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
    return view('welcome');
});
Route::get('/index', function ($coms) {
    return view('index')->with('coms');
});
Route::get('/edit', function ($com) {
    return view('edit')->with('com');
});
Route::get('/add', function () {
    return view('add');
});
Route::get('/index', [CompaniesController::class, 'index']);
Route::post('/add', [CompaniesController::class, 'create']);
Route::post('/edit/{id}', [CompaniesController::class, 'edit']);
Route::post('/find/{id}', [CompaniesController::class, 'find']);
Route::delete('/destroy/{id}', [CompaniesController::class, 'destroy']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
