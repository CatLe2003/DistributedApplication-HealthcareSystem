<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    use HasFactory;

    protected $primaryKey = 'ManufacturerID';
    protected $table = 'manufacturers';

    protected $fillable = [
        'ManufacturerName',
        'Address',
        'Country',
        'Email',
        'PhoneNumber',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'ManufacturerID', 'ManufacturerID');
    }
}

