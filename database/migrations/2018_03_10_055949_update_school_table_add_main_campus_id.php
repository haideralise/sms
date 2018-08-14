<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSchoolTableAddMainCampusId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {

            $table->unsignedInteger('main_campus_id')->after('id')->nullable();

            $table->foreign('main_campus_id')->references('id')->on('campuses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function (Blueprint $table) {

            $table->dropForeign(['main_campus_id']);

            $table->dropColumn('main_campus_id');
        });
    }
}
