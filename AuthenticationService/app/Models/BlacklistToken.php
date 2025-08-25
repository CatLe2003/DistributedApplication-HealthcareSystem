<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistToken extends Model
{
    protected $table = 'blacklist_tokens';
    protected $fillable = ['token', 'expired_at'];
}
