<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name', 'speciality', 'phone', 'email', 'photo', 'status'
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}