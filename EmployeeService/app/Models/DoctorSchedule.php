<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $primaryKey = 'ScheduleID';

    protected $fillable = [
        'DoctorID',
        'WeekdayID',
        'ShiftID',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'DoctorID');
    }

    public function weekday()
    {
        return $this->belongsTo(Weekday::class, 'WeekdayID');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'ShiftID');
    }
}