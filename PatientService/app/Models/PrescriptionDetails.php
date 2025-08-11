<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionDetails extends Model
{
    protected $table = 'prescriptiondetails';
    protected $fillable = [
        'prescription_id', 
        'medicine_id', 
        'dosage', 
        'duration'
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class, 'prescription_id');
    }
}
