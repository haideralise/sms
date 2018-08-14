<?php

use App\Models\Attendance\AttendanceStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 100);
            $table->string('code', 10);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        foreach (AttendanceStatus::availableStatus as $key => $availableStatus) {

            \Illuminate\Support\Facades\Log::info("{$key} - {$availableStatus}");

            $status = AttendanceStatus::firstOrNew([
                'id' =>  $key
            ]);
            $status->code = substr($availableStatus, 0, 1);
            $status->title  = $availableStatus;

            $status->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_statuses');
    }
}
