<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    protected $fillable = [
        'visit_id',
        'test_id',
        'employee_id',
        'order_date',
        'status',
        'result',
        'detailsURL',
    ];
}
