<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeAdmissionFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_admission_fees', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('grade_id');
            $table->float('amount');
            $table->date('applied_from');

            $table->timestamps();

            $table->foreign('grade_id')->references('id')->on('grades');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_admission_fees');
    }
}
