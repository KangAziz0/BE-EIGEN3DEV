<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BorrowBooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MemberController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/members', MemberController::class);
Route::apiResource('/books', BookController::class);
Route::get('/books-without-borrowed',[BookController::class,'BookWithoutBorrowed']);
// Route::apiResource('/borrowing', BorrowBooksController::class);
Route::get('/borrowed-books-count', [BorrowBooksController::class, 'getBorrowedBooksCount']);
Route::post('/borrow',[BorrowBooksController::class,'borrow']);
Route::post('/return',[BorrowBooksController::class,'returnBook']);
