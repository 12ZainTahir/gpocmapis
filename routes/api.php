<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Middleware\checkauth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['checkauth'])->group(function () {
    Route::post('/upload', [FileController::class, 'upload'])->name('upload');
    Route::get('/download', [FileController::class, 'downloadAllFiles'])->name('download');
    
     Route::post('/uploadresultfile', [FileController::class, 'uploadresultfile'])->name('uploadresultfile');
     
  
});

    Route::get('/files', [FileController::class, 'ListFiles'])->name('files');
    Route::get('/test', [FileController::class, 'test'])->name('test');
    
    Route::get('/resultfiles', [FileController::class, 'ListResultFiles'])->name('resultfiles');
    
    Route::delete('/delete', [FileController::class, 'deleteAllFiles'])->name('delete');
    
    
    
    Route::delete('/deleteresultfile', [FileController::class, 'deleteresultfile'])->name('deleteresultfile');
    
    
    

// Route::get('/download', [FileController::class, 'downloadAllFiles']);
// Route::get('/files', [FileController::class, 'ListFiles']);
// Route::delete('/delete', [FileController::class, 'deleteAllFiles']);
// Route::middleware('checkauth')->post('/upload', [FileController::class, 'upload']);
