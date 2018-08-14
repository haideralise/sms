<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_attendances', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('section_id');
            $table->unsignedInteger('attendance_status_id');

            $table->date('date');

            $table->string('comments', 255)->nullable();

            $table->timestamps();

            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('attendance_status_id')->references('id')->on('attendance_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_attendances');
    }
}
