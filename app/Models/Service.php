<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Service",
 *     type="object",
 *     title="Service",
 *     description="Service model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Layanan Periksa"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-14T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-14T10:00:00Z")
 * )
 */
class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable = ['name'];
}
