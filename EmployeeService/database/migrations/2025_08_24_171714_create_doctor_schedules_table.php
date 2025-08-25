<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctor_schedules', function (Blueprint $table) {
            $table->id('ScheduleID');
            $table->unsignedBigInteger('DoctorID');
            $table->unsignedBigInteger('WeekdayID');
            $table->unsignedBigInteger('ShiftID');
            $table->timestamps();

            $table->foreign('DoctorID')->references('EmployeeID')->on('doctors')->onDelete('cascade');
            $table->foreign('WeekdayID')->references('WeekdayID')->on('weekdays');
            $table->foreign('ShiftID')->references('ShiftID')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedules');
    }
};
