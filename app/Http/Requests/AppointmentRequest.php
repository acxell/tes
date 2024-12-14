<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="AppointmentRequest",
 *     type="object",
 *     title="Appointment Request",
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="diagnose_id", type="integer", example=1),
 *     @OA\Property(property="status", type="integer", example=0)
 * )
 */
class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'diagnose_id' => 'required|exists:diagnoses,id',
            'status' => 'nullable|in:0,1',
        ];
    }
}
