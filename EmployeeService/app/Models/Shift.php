<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $primaryKey = 'ShiftID';

    protected $fillable = [
        'ShiftName',
        'StartTime',
        'EndTime',
    ];
}