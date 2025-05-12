<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileScanController;
use App\Http\Middleware\VerifyScanApiKey;
use App\Http\Controllers\CodeScanController;

Route::get('/scan-code', [CodeScanController::class, 'scan'])    ->middleware(VerifyScanApiKey::class);

Route::get('/scan-files', [FileScanController::class, 'scanFiles']);

Route::get('/user', fn(Request $request) => $request->user())->middleware('auth:sanctum');
