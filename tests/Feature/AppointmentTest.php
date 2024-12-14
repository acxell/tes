<?php

namespace Tests\Feature;

use App\Jobs\ProcessCheckupProgress;
use App\Models\Appointment;
use App\Models\Diagnose;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    use WithoutMiddleware;

    public function test_complete_appointment_workflow()
    {
        Queue::fake();

        $patients = [
            ['name' => 'Budi'],
            ['name' => 'Indah'],
            ['name' => 'Siska'],
        ];
        foreach ($patients as $patientData) {
            $this->postJson('/api/v1/patient', $patientData)
                ->assertStatus(201)
                ->assertJsonPath('data.name', $patientData['name']);
        }
        $patients = Patient::all();
        $this->assertCount(3, $patients);

        $services = [
            ['name' => 'Obat'],
            ['name' => 'Rawat Inap'],
            ['name' => 'ICU'],
        ];
        foreach ($services as $serviceData) {
            $this->postJson('/api/v1/service', $serviceData)
                ->assertStatus(201)
                ->assertJsonPath('data.name', $serviceData['name']);
        }
        $services = Service::all();
        $this->assertCount(3, $services);

        $diagnoses = [
            ['name' => 'Ringan', 'service' => [Service::where('name', 'Obat')->first()->id]],
            ['name' => 'Berat', 'service' => [
                Service::where('name', 'Obat')->first()->id,
                Service::where('name', 'Rawat Inap')->first()->id,
            ]],
            ['name' => 'Kritis', 'service' => [
                Service::where('name', 'Obat')->first()->id,
                Service::where('name', 'Rawat Inap')->first()->id,
                Service::where('name', 'ICU')->first()->id,
            ]],
        ];
        foreach ($diagnoses as $diagnoseData) {
            $this->postJson('/api/v1/diagnose', $diagnoseData)
                ->assertStatus(201)
                ->assertJsonPath('data.name', $diagnoseData['name']);
        }
        $diagnoses = Diagnose::all();
        $this->assertCount(3, $diagnoses);

        $appointments = [
            [
                'patient_id' => $patients[0]->id,
                'diagnose_id' => Diagnose::where('name', 'Ringan')->first()->id,
                'status' => 0,
            ],
            [
                'patient_id' => $patients[1]->id,
                'diagnose_id' => Diagnose::where('name', 'Berat')->first()->id,
                'status' => 0,
            ],
            [
                'patient_id' => $patients[2]->id,
                'diagnose_id' => Diagnose::where('name', 'Kritis')->first()->id,
                'status' => 0,
            ],
        ];
        foreach ($appointments as $appointmentData) {
            $this->postJson('/api/v1/appointment', $appointmentData)
                ->assertStatus(201)
                ->assertJsonPath('data.status', $appointmentData['status']);
        }
        $appointments = Appointment::all();
        $this->assertCount(3, $appointments);

        Queue::assertPushed(ProcessCheckupProgress::class, 3);

        foreach ($appointments as $appointment) {
            $checkupProgresses = $appointment->checkupProgress;

            foreach ($checkupProgresses as $progress) {
                $this->patchJson("/api/v1/checkup-progress/{$progress->id}", ['status' => 1])
                    ->assertStatus(200);

                $progress->update(['status' => 1]);
            }

            $allServicesCompleted = $appointment->checkupProgress->every(function ($progress) {
                return $progress->status == 1;
            });

            if ($allServicesCompleted) {
                $this->patchJson("/api/v1/appointment/{$appointment->id}", ['status' => 1])
                    ->assertStatus(200);
            }
        }

        foreach ($appointments as $appointment) {
            $this->assertEquals(1, $appointment->refresh()->status);
        }
    }
}
