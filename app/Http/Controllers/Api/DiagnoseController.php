<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiagnoseRequest;
use App\Models\Diagnose;

/**
 * @OA\Tag(name="Diagnoses", description="Diagnose Management")
 */
class DiagnoseController extends Controller
{
    /**
     * @OA\Post(
     *     path="/diagnose",
     *     summary="Create a new diagnose",
     *     tags={"Diagnoses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "service"},
     *             @OA\Property(property="name", type="string", example="Flu"),
     *             @OA\Property(property="service", type="array", @OA\Items(type="integer", example=1))
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Diagnose created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Diagnose")
     *     )
     * )
     */
    public function store(DiagnoseRequest $request)
    {
        // Save the diagnose with the service ids as an array
        $diagnose = Diagnose::create([
            'name' => $request->name,
            'service' => $request->service, // Array of service ids
        ]);

        return response()->json(['data' => $diagnose], 201);
    }
}
