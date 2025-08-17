<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalVisit extends Model
{
    protected $table = 'medicalvisit';
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'visit_date',
        'diagnosis',
        'symptoms',
        'notes',
    ];
}
