<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckupProgress extends Model
{
    use HasFactory;

    protected $table = 'checkup_progress';

    protected $fillable = ['appointment_id', 'service_id', 'status'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
