<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableAddCampusAmount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->unsignedInteger('campus_id')->after('id')->nullable();

            $table->unsignedInteger('section_id')->after('id')->nullable();

            $table->foreign('campus_id')->references('id')->on('campuses')->onDelete('set null');

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['campus_id']);

            $table->dropForeign(['section_id']);

            $table->dropColumn('campus_id');

            $table->dropColumn('section_id');
        });
    }
}
