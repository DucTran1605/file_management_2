<?php

use App\Http\Controllers\File\FileDeleteController;
use App\Http\Controllers\File\FileList;
use App\Http\Controllers\File\FileListController;
use App\Http\Controllers\File\FileUpload;
use App\Http\Controllers\File\FileUploadController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('layouts.home.main_page');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route for File
    Route::post('/fileUpload', [FileUploadController::class, 'uploadFile'])->name('file.upload');
    Route::get('/showAllFile', [FileListController::class, 'listAllFile'])->name('file.show');
    Route::delete('/deleteSoftFile/{id}', [FileDeleteController::class, 'deleteSoftFile'])->name('file.delete');
    Route::get('/file/trash', [FileListController::class, 'showTrashedFile'])->name('file.trashed');
    Route::get('/file/{id}/restore', [FileDeleteController::class, 'restoreFile'])->name('files.restore');
});

require __DIR__.'/auth.php';
