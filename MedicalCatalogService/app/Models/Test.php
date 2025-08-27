<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $primaryKey = 'TestID';
    protected $table = 'tests';

    protected $fillable = [
        'TestName',
        'Description',
        'Price',
        'DepartmentID',
    ];
}
