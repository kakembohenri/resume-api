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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->foreignId('Resume_Id')->constrained('resumes')->cascadeOnDelete();
            $table->string('Phone');
            $table->string('Website')->nullable();
            $table->string('Twitter')->nullable();
            $table->string('Facebook')->nullable();
            $table->string('Instagram')->nullable();
            $table->string('LinkedIn')->nullable();
            AuditTrail::NotNullCreatedBy($table);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
