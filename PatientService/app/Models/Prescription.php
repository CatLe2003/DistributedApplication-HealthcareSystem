<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $table = 'prescription';
    protected $fillable = [
        'visit_id',
        'status',
        'date',
        'notes'
    ];

     public function details()
    {
        return $this->hasMany(PrescriptionDetails::class, 'prescription_id');
    }
}
