<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

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

Route::get('/', [TodoListController::class, 'index']);

// When the route "saveItemRoute" is hit, we will call the controller "TodoListController" and call the method "saveItem"
Route::post('/saveItemRoute', [TodoListController::class, 'saveItem'])->name('saveItem');