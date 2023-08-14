<?php

namespace App\Models;

use App\CustomHelpers\DefaultPrimaryKeyAndTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHistory extends Model
{
    use HasFactory, DefaultPrimaryKeyAndTimestamps;

    public $timestamps = false;

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'Resume_Id',
        'Company',
        'Position',
        'Role',
        'StartDate',
        'EndDate',
        'CreatedAt',
        'Created_By',
        'ModifiedAt',
        'Modified_By',
        'Deleted_By',
        'DeletedAt',
    ];
}
