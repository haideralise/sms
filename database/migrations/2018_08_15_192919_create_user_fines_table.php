<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_fines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fined_to');
            $table->unsignedInteger('fined_by');
            $table->text('reason');
            $table->date('fined_at');
            $table->timestamps();

            $table->foreign('fined_to')->references('id')->on('users');
            $table->foreign('fined_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_fines');
    }
}
