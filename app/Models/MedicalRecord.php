<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = [
        'appointment_id', 'diagnosis', 'prescription', 'notes', 'attachment'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}