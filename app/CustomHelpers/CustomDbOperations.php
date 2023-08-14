<?php

namespace App\CustomHelpers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CustomDbOperations
{
    protected $model;

    protected $UserId;

    public function __construct($model, $UserId)
    {
        $this->model = $model;
        $this->UserId = $UserId;
    }

    // Handle soft deletes
    public static function SoftDelete($model, $UserId)
    {
        $model->update([
            'Deleted_By' => $UserId,
            'DeletedAt' => date('Y:m:d H:i:s', time())
        ]);
    }
}
