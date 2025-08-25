<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $primaryKey = 'RoomID';

    protected $fillable = [
        'RoomName',
        'Floor',
    ];
}