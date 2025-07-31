<?php

use App\Http\Controllers\ShareLinkController;
use App\Http\Controllers\UploadChunkController;
use App\Http\Controllers\FilePreviewController;
use App\Http\Controllers\FileAccessController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route untuk upload chunk dan merge (Dropzone.js)
    Route::post('/upload/chunk', [UploadChunkController::class, 'chunk'])->name('upload.chunk');
    Route::post('/upload/merge', [UploadChunkController::class, 'merge'])->name('upload.merge');

    // Route untuk generate share link
    Route::post('/share/generate', [ShareLinkController::class, 'generate'])->name('share.generate');

    // Route untuk file preview
    Route::get('/file-preview-text/{file}', [FilePreviewController::class, 'textPreview'])->name('file.preview.text');
});

// Route untuk mengakses share link
Route::get('/share/{token}', [ShareLinkController::class, 'access'])->name('share.access');

// Route untuk akses file dengan CORS
Route::get('/file/{fileId}', [FileAccessController::class, 'serve'])->name('file.serve');
Route::options('/file/{fileId}', [FileAccessController::class, 'serve'])->name('file.serve.options');

// Route fallback untuk storage path - serve dengan CORS
Route::get('/storage/uploads/{filename}', [FileAccessController::class, 'serveByPath'])->name('storage.fallback');
Route::options('/storage/uploads/{filename}', [FileAccessController::class, 'serveByPath'])->name('storage.fallback.options');

Route::get('/test/page', function () {
    dd(phpinfo());
});
