<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_submissions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('grade_admission_fee_id');
            $table->unsignedInteger('payment_status_id');
            $table->date('submitted_at')->nullable();

            $table->timestamps();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('grade_admission_fee_id')->references('id')->on('grade_admission_fees');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admission_submissions');
    }
}
