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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id('EmployeeID'); 
            $table->unsignedBigInteger('SpecialityID');
            $table->string('LicenseNumber');
            $table->unsignedBigInteger('RoomID');
            $table->timestamps();

            $table->foreign('EmployeeID')->references('EmployeeID')->on('employees')->onDelete('cascade');
            $table->foreign('SpecialityID')->references('SpecialityID')->on('specialities');
            $table->foreign('RoomID')->references('RoomID')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
