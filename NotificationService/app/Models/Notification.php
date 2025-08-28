<?php
namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Notification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'notifications';
    protected $fillable = [
        'recipientId', 'type', 'title', 'message', 'metadata',
        'status', 'sentAt', 'createdAt', 'updatedAt'
    ];
    protected $casts = [
        'metadata' => 'array',
        'sentAt' => 'datetime',
        'createdAt' => 'datetime',
        'updatedAt' => 'datetime',
    ];
}