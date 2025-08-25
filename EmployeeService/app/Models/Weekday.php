<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weekday extends Model
{
    protected $primaryKey = 'WeekdayID';

    protected $fillable = [
        'WeekdayName',
    ];
}