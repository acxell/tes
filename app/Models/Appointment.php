<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Appointment",
 *     type="object",
 *     title="Appointment",
 *     description="Appointment model schema",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="diagnose_id", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=0),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-14T10:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-12-14T10:00:00Z")
 * )
 */
class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $fillable = ['patient_id', 'diagnose_id', 'status'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function diagnose()
    {
        return $this->belongsTo(Diagnose::class);
    }

    public function checkupProgress()
    {
        return $this->hasMany(CheckupProgress::class);
    }
}
