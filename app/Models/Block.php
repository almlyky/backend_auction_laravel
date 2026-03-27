<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;

    protected $fillable = [
        'blocked_by',
        'user_id',
    ];

    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }

    public function blocked()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
