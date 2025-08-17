<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    protected $table = 'followup';
    protected $fillable = [
        'visit_id',
        'date',
        'notes'
    ];
}
