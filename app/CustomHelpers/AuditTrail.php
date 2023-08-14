<?php

namespace App\CustomHelpers;


class AuditTrail {

    protected $table;

    public function __construct($table)
    {
        $this->table = $table;
        
    }

    public static function NotNullCreatedBy($table){
        $table->timestamp("CreatedAt");
        $table->foreignId("Created_By")->constrained("users");
        $table->timestamp("ModifiedAt")->nullable();
        $table->foreignId("Modified_By")->nullable()->constrained("users");
        $table->foreignId("Deleted_By")->nullable()->constrained("users");
        $table->timestamp("DeletedAt")->nullable();
    }

    public static function NullCreatedBy($table){
        $table->timestamp("CreatedAt");
        $table->foreignId("Created_By")->nullable()->constrained("users");
        $table->timestamp("ModifiedAt")->nullable();
        $table->foreignId("Modified_By")->nullable()->constrained("users");
        $table->foreignId("Deleted_By")->nullable()->constrained("users");
        $table->timestamp("DeletedAt")->nullable();
    }
}
