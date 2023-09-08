<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');

Route::get('password/change', [App\Http\Controllers\PasswordController::class, 'showChangeForm'])->name('pwd.change');
Route::post('password/update', [App\Http\Controllers\PasswordController::class, 'change'])->name('pwd.update');
