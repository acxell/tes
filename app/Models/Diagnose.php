<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Diagnose",
 *     type="object",
 *     title="Diagnose",
 *     description="Diagnose model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Flu"),
 *     @OA\Property(property="service", type="array", @OA\Items(type="integer", example=1)),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-14T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-14T10:00:00Z")
 * )
 */
class Diagnose extends Model
{
    use HasFactory;

    protected $table = 'diagnoses';
    protected $fillable = ['name', 'service'];

    protected $casts = [
        'service' => 'array',
    ];
}
