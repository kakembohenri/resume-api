<?php

use App\CustomHelpers\AuditTrail;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->string('Email')->unique();
            $table->text('Password');
            $table->foreignId('Status_Id')->constrained('statuses')->cascadeOnDelete();
            $table->foreignId('Role_Id')->constrained('roles')->cascadeOnDelete();
            AuditTrail::NullCreatedBy($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
