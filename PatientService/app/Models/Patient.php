<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patient';
    protected $fillable = [
        'full_name',
        'email',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
        'citizen_id',
        'nationality',
        'ethnicity',
        'occupation',
        'allergy',
    ];
}
