<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $primaryKey = 'SpecialityID';

    protected $fillable = [
        'SpecialityName',
        'Description',
        'DepartmentID',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID');
    }
}