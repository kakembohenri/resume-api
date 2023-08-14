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
        Schema::create('resumes', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->foreignId('User_Id')->constrained('users')->cascadeOnDelete();
            $table->text('AvatarPath');
            $table->string('FirstName');
            $table->string('MiddleName')->nullable();
            $table->string('LastName');
            $table->string('Headline');
            $table->string('DateOfBirth');
            $table->string('Nationality');
            $table->string('Gender');
            $table->text('Bio');
            $table->string('CountryOfResidence');
            $table->string('City');
            $table->string('PostalCode')->nullable();
            $table->string('RefererCode')->unique();
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
        Schema::dropIfExists('resumes');
    }
};
