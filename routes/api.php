<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'books'], function () {
        // Get all books
        Route::get('/', [\App\Http\Controllers\BookController::class, 'index']);

        // Borrow and return a book
        Route::post('/{book:code}/borrow', [\App\Http\Controllers\BorrowABookController::class, 'store']);
        Route::post('/{book:code}/return', [\App\Http\Controllers\BorrowABookController::class, 'update']);
    });

    Route::group(['prefix' => 'members'], function () {
        // Get all users
        Route::get('/', [\App\Http\Controllers\MemberController::class, 'index']);
    });
});
