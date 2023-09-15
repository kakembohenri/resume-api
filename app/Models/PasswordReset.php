<?php

namespace App\Models;

use App\CustomHelpers\DefaultPrimaryKeyAndTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory, DefaultPrimaryKeyAndTimestamps;

    public $timestamps = false;

    protected $fillable = [
        'Email',
        'Token',
        'ExpiresIn',
        'created_at',
        'updated_at'
    ];
}
