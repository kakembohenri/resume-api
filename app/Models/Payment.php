<?php

namespace App\Models;

use App\CustomHelpers\DefaultPrimaryKeyAndTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, DefaultPrimaryKeyAndTimestamps;

    public $timestamps = false;

    protected $fillable = [
        "User_Id",
        "Amount",
        "StartTime",
        "Level",
        'CreatedAt',
    ];
}
