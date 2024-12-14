<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Jobs\ProcessCheckupProgress;
use App\Models\Appointment;
use Illuminate\Http\Request;

/**
 * @OA\Tag(name="Appointment", description="Appointment Management")
 */
class AppointmentController extends Controller
{
    /**
     * @OA\Post(
     *     path="/appointment",
     *     summary="Create an appointment",
     *     description="Create a new appointment",
     *     operationId="createAppointment",
     *     tags={"Appointments"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"patient_id", "diagnose_id"},
     *             @OA\Property(property="patient_id", type="integer", example=1),
     *             @OA\Property(property="diagnose_id", type="integer", example=1),
     *             @OA\Property(property="status", type="integer", example=0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appointment created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(AppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());
        ProcessCheckupProgress::dispatch($appointment)->onQueue('checkup-progress');
        return response()->json(['data' => $appointment], 201);
    }

    /**
     * @OA\Get(
     *     path="/appointment/{id}",
     *     summary="Get appointment details",
     *     description="Retrieve ID",
     *     operationId="getAppointment",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment details retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Appointment not found"
     *     )
     * )
     */
    public function show($id)
    {
        $appointment = Appointment::with(['patient', 'diagnose', 'checkupProgress.service'])->findOrFail($id);
        return response()->json(['data' => $appointment]);
    }

    /**
     * @OA\Patch(
     *     path="/appointment/{id}",
     *     summary="Update appointment status",
     *     description="Update Appointment Status",
     *     operationId="updateAppointmentStatus",
     *     tags={"Appointments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appointment status updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function updateStatus($id)
    {
        $appointment = Appointment::with('checkupProgress')->findOrFail($id);
        $allCompleted = $appointment->checkupProgress->every(fn($progress) => $progress->status == 1);

        if ($allCompleted) {
            $appointment->update(['status' => 1]);
        }

        return response()->json(['data' => $appointment]);
    }
}
