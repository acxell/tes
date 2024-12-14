<?php

use App\Http\Controllers\Api\AppointmentController as ApiAppointmentController;
use App\Http\Controllers\Api\DiagnoseController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Info(
 *     title="Klinik Service API",
 *     version="1.0.0",
 *     description="API untuk layanan klinik",
 *     @OA\Contact(
 *         email="acxell@gmail.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Server utama API"
 * )
 */

// Define API routes here
Route::group(['prefix' => 'v1'], function () {
    Route::post('patient', [PatientController::class, 'store']);
    Route::post('diagnose', [DiagnoseController::class, 'store']);
    Route::post('service', [ServiceController::class, 'store']);
    Route::post('appointment', [ApiAppointmentController::class, 'store']);
    Route::get('appointment/{id}', [ApiAppointmentController::class, 'show']);
    Route::patch('appointment/{id}', [ApiAppointmentController::class, 'updateStatus']);
});
