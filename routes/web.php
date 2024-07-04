<?php

use App\Http\Controllers\File\FileDeleteController;
use App\Http\Controllers\File\FileDetailController;
use App\Http\Controllers\File\FileDownloadController;
use App\Http\Controllers\File\FileListController;
use App\Http\Controllers\File\FileMovingController;
use App\Http\Controllers\File\FileSearchController;
use App\Http\Controllers\File\FileShareController;
use App\Http\Controllers\File\FileUploadController;
use App\Http\Controllers\ProfileController;
use App\Models\File;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route for File
    Route::post('/file/{parent_id?}', [FileUploadController::class, 'uploadFile'])->name('file.upload');
    Route::get('/showAllFile', [FileListController::class, 'listAllFile'])->name('file.show');
    Route::delete('/file/{id}/deleteSoft', [FileDeleteController::class, 'deleteSoftFile'])->name('file.delete');
    Route::get('/file/trash', [FileListController::class, 'showTrashedFile'])->name('file.trashed');
    Route::get('/file/{id}/restore', [FileDeleteController::class, 'restoreFile'])->name('files.restore');
    Route::delete('/file/{id}/force_delete', [FileDeleteController::class, 'forceDeleteFile'])->name('file.forceDelete');
    Route::get('/file/{id}/detail', [FileDetailController::class, 'showFileDetail'])->name('file.detail');
    Route::put('/fileEdit/{id}', [FileDetailController::class, 'changeFileName'])->name('file.edit');
    Route::post('/file/{id}/cut', [FileMovingController::class, 'fileCut'])->name('file.cut');
    Route::post('/filePaste/{parent_id?}', [FileMovingController::class, 'filePaste'])->name('file.paste');
    Route::get('/fileSearch/{parent_id?}', [FileSearchController::class, 'fileSearch'])->name('file.search');
    Route::get('/fileTrashSearch/{parent_id?}', [FileSearchController::class, 'fileTrashSearch'])->name('fileTrash.search');
    Route::get('/file/download/{id}', [FileDownloadController::class, 'downloadFolder'])->name('file.download');
    Route::get('/fileShare/{url}', [FileShareController::class, 'shareFile'])->name('file.share');

    //Route for Folder
    Route::post('/folder/{parent_id?}', [FileUploadController::class, 'createFolder'])->name('folder.create');
    Route::get('/folder/{id}', [FileListController::class, 'listSpecificFolder'])->name('folder.show');
    Route::get('/folderTrash/{id}', [FileListController::class, 'listSpecificTrashFolder'])->name('folderTrash.show');
});

require __DIR__ . '/auth.php';

Route::get('/test', function () {
    activity()->log('test');

    return Activity::all();
})->name('test');
