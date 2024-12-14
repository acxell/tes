<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Models\Service;

/**
 * @OA\Tag(name="Services", description="Service Management")
 */
class ServiceController extends Controller
{
    /**
     * @OA\Post(
     *     path="/service",
     *     summary="Create a new service",
     *     tags={"Services"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="General Checkup"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Service created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Service")
     *     )
     * )
     */
    public function store(ServiceRequest $request)
    {
        $service = Service::create($request->validated());
        return response()->json(['data' => $service], 201);
    }
}
