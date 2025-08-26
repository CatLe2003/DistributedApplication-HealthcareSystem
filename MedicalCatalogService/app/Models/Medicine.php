<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $primaryKey = 'MedicineID';
    protected $table = 'medicines';

    protected $fillable = [
        'MedicineName',
        'Ingredient',
        'FormID',
        'UnitID',
        'Packaging',
        'DosageInstruction',
        'Indication',
        'Contraindication',
        'SideEffect',
        'Storage',
        'ManufacturerID',
        'Price',
        'InStock',
        'Status',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class, 'FormID', 'FormID');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'UnitID', 'UnitID');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'ManufacturerID', 'ManufacturerID');
    }
}
