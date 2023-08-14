<?php

namespace App\Models;

use App\CustomHelpers\DefaultPrimaryKeyAndTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory, DefaultPrimaryKeyAndTimestamps;

    public $timestamps = false;

    const DELETED_AT = 'DeletedAt';

    protected $fillable = [
        'User_Id',
        'AvatarPath',
        'FirstName',
        'MiddleName',
        'LastName',
        'Headline',
        'DateOfBirth',
        'Nationality',
        'Gender',
        'Bio',
        'CountryOfResidence',
        'City',
        'PostalCode',
        'RefererCode',
        'CreatedAt',
        'Created_By',
        'ModifiedAt',
        'Modified_By',
        'Deleted_By',
        'DeletedAt',
    ];

    /** RELATIONSHIPS
     * 
     */

    //  Has many education
    public function education()
    {
        return $this->hasMany(EducationHistory::class, 'Resume_Id', 'Id');
    }

    // Has many wok history
    public function work_history()
    {
        return $this->hasMany(WorkHistory::class, 'Resume_Id', 'Id');
    }

    // Has many languages
    public function languages()
    {
        return $this->hasMany(Language::class, 'Resume_Id', 'Id');
    }

    // has many skills
    public function skills()
    {
        return $this->hasMany(Skills::class, 'Resume_Id', 'Id');
    }

    // has many contacts
    public function contacts()
    {
        return $this->hasOne(Contact::class, 'Resume_Id', 'Id');
    }

    // belongs to user
    public function user()
    {
        return $this->belongsTo(User::class, 'User_Id', 'Id');
    }
}
