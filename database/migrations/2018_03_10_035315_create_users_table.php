<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('guardian_id')->nullable();
            $table->unsignedInteger('created_by')->nullable();

            $table->string('first_name', 100);
            $table->string('middle_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('phone_number', 100)->unique()->nullable();
            $table->string('national_id', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('username', 100)->unique()->nullable();
            $table->string('password')->nullable();

            $table->float('agree_amount', 7, 2)->default(0.0);
            $table->date('dob')->nullable();
            $table->smallInteger('gender')->default(0)->comment = '0:m 1:f';
            $table->string('profile_picture', 255)->nullable();

            $table->smallInteger('type')->default(0)->comment = '0:student 1:teacher 2:staff 3:parent';

            $table->string('address', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('country', 255)->nullable();

            $table->timestamps();

            $table->foreign('guardian_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
