<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     title="Patient",
 *     description="Patient model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Acxell"),
 * )
 */
class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';
    protected $fillable = ['name'];
}
