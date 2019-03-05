<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_funds', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('grade_id');
            $table->unsignedInteger('fund_type_id');

            $table->integer('month');
            $table->integer('year');
            $table->float('amount');
            $table->date('applied_from')->nullable();
            $table->boolean('is_active')->default(1);

            $table->timestamps();

            $table->foreign('grade_id')->references('id')->on('grades');
            $table->foreign('fund_type_id')->references('id')->on('fund_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_funds');
    }
}
