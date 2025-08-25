<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $primaryKey = 'DepartmentID';

    protected $fillable = [
        'DepartmentName',
        'Description',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'DepartmentID', 'id');
    }
}
