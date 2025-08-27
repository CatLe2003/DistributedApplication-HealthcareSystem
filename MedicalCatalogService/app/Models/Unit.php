<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $primaryKey = 'UnitID';
    protected $table = 'units';

    protected $fillable = [
        'UnitName',
        'Description',
    ];

    public function medicines()
    {
        return $this->hasMany(Medicine::class, 'UnitID', 'UnitID');
    }
}
