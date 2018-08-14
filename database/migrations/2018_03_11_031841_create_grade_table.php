<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('campus_id');
            $table->unsignedInteger('created_by')->nullable();

            $table->string('name', 100);
            $table->string('code', 20)->nullable();
            $table->float('fee', 7, 2)->default(0.0);
            $table->string('description', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
}
