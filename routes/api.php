<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/


// REQUIREMENT 1 - API ROUTE FOR ICE AND FIRE BOOKS API
Route::get('external-books',[ApiController::class, 'getExternalBook']);

// REQUIREMENT 2 - API ROUTES CRUD
Route::resource('v1/books', ApiController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
 