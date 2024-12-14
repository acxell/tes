<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Klinik Service API",
 *     description="Klinik Service API",
 *     @OA\Contact(
 *         email="acxell@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Primary API Server"
 * )
 */

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
