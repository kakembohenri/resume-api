<?php

namespace App\CustomHelpers;

trait DefaultPrimaryKeyAndTimestamps
{

    // Override getKeyName method to set  primary key to 'Id'
    public function getKeyName()
    {
        return 'Id';
    }

    // Override timestamp functions
    public function setCreatedAt($value)
    {
        return false;
    }

    public function setUpdatedAt($value)
    {
        return false;
    }
}
