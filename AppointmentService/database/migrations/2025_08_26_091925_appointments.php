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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('AppointmentID');

            // Chỉ lưu ID tham chiếu, không FK
            $table->unsignedBigInteger('PatientID');
            $table->unsignedBigInteger('DoctorID');
            $table->unsignedBigInteger('TransactionID')->nullable();
            $table->unsignedBigInteger('TimeSlotID');
            $table->unsignedBigInteger('RoomID');
            $table->unsignedBigInteger('DepartmentID');
            $table->unsignedBigInteger('WeekdayID')->nullable();

            // Appointment details
            $table->date('AppointmentDate');
            $table->string('Status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
