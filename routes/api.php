<?php

declare(strict_types=1);

use App\Http\Controllers\CodeScanController;
use App\Http\Controllers\FileScanController;
use App\Http\Middleware\VerifyScanApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/scan-code', [CodeScanController::class, 'scan'])->middleware(VerifyScanApiKey::class);

Route::get('/scan-files', [FileScanController::class, 'scanFiles']);

Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');
