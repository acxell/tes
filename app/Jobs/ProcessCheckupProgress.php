<?php

namespace App\Jobs;

use App\Models\Appointment;
use App\Models\CheckupProgress;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;

class ProcessCheckupProgress implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $appointment;

    /**
     * Create a new job instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $services = json_decode($this->appointment->diagnose->service, true);

        foreach ($services as $serviceId) {
            CheckupProgress::create([
                'appointment_id' => $this->appointment->id,
                'service_id' => $serviceId,
                'status' => 0,
            ]);
        }
    }
}

