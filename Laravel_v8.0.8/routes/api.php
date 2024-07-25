<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AusController;

Route::get('/api', [AusController::class, 'index']);
Route::put('/api/emp/{id}', [AusController::class, 'update']);
Route::get('/', [AusController::class, 'tab']);        
Route::post('/new', [AusController::class, 'store']);
Route::get('/add', [AusController::class, 'add']);
Route::get('/lol', function() {return response()->json('we are getting POST response');});
Route::post('/api/assassin', [AusController::class, 'values']);
Route::post('/api/insert', [AusController::class, 'insert']); 
Route::delete('/api/del/{id}', [AusController::class, 'delete']); 