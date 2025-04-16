<?php

use Ashraful\Bookium\App\Controllers\BookController;
use Ashraful\Bookium\App\Middlewares\AuthMiddleware;
use Ashraful\Bookium\Classes\Core\Response;
use Ashraful\Bookium\Classes\Core\Route;

Route::set_namespace('bookium');

Route::get('/books', BookController::class, AuthMiddleware::class);
Route::post('/books/(?P<id>[\d]+)', function ($request) {
    return Response::json($request->all(), Response::CREATED);
});
// Route::get('/books', [BookController::class, 'index']);