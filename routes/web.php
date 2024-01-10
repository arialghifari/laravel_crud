<?php

use App\Http\Controllers\ExpenseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    $expenses = [];

    if (auth()->check()) {
        $expenses = auth()->user()->expenses;
    }

    return view('home', ['expenses' => $expenses]);
});

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);

Route::post('/create-expense', [ExpenseController::class, 'createExpense']);
Route::get('/edit-expense/{expense}', [ExpenseController::class, 'editExpense']);
Route::put('/update-expense/{expense}', [ExpenseController::class, 'updateExpense']);
Route::delete('/delete-expense/{expense}', [ExpenseController::class, 'deleteExpense']);
