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
        Schema::create('work_histories', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->foreignId('Resume_Id')->constrained('resumes')->cascadeOnDelete();
            $table->string('Company');
            $table->string('Position');
            $table->text('Role');
            $table->string('StartDate');
            $table->string('EndDate')->nullable();
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
        Schema::dropIfExists('work_histories');
    }
};
