<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnrollmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_assignments', function (Blueprint $table) {

            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->unsignedInteger('subject_id')->nullable();
            $table->unsignedInteger('section_id');

            $table->timestamps();

            $table->unique(['user_id', 'section_id', 'subject_id']);

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->foreign('section_id')->references('id')->on('sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_assignments');
    }
}
