<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $primaryKey = 'EmployeeID'; 

    protected $fillable = [
        'SpecialityID',
        'LicenseNumber',
        'RoomID',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'EmployeeID');
    }

    public function speciality()
    {
        return $this->belongsTo(Speciality::class, 'SpecialityID');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID');
    }
}