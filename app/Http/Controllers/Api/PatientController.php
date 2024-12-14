<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Models\Patient;

/**
 * @OA\Tag(name="Patients", description="Patient Management")
 */
class PatientController extends Controller
{
    /**
     * @OA\Post(
     *     path="/patient",
     *     summary="Create a new patient",
     *     tags={"Patients"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Patient created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Patient")
     *     )
     * )
     */
    public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->validated());
        return response()->json(['data' => $patient], 201);
    }
}
