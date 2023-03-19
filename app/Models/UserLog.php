<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'token_type',
        'expires_in',
        'expires_on',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    /**
     * Get the user that owns the UserLog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
