<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'EmployeeID';

    protected $fillable = [
        'FullName',
        'Gender',
        'DOB',
        'PhoneNumber',
        'Email',
        'DepartmentID',
        'AvatarURL',
        'Role',
        'Status',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID');
    }
}