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
        Schema::create('skills', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->foreignId('Resume_Id')->constrained('resumes')->cascadeOnDelete();
            $table->string('Name');
            $table->text('Description');
            $table->string('Level');
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
        Schema::dropIfExists('skills');
    }
};
