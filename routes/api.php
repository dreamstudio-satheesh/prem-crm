<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ScanController;



Route::post('/scan', [ScanController::class, 'store']);
Route::get('/scan/last', [ScanController::class, 'getLastScan']);

Route::apiResource('companies', CompanyApiController::class);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
