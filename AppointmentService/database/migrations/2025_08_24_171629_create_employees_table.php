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
        Schema::create('employees', function (Blueprint $table) {
            $table->id('EmployeeID');
            $table->string('FullName');
            $table->string('Gender', 10);
            $table->date('DOB');
            $table->string('PhoneNumber');
            $table->string('Email')->unique();
            $table->unsignedBigInteger('DepartmentID');
            $table->string('AvatarURL')->nullable();
            $table->string('Role');
            $table->string('Status');
            $table->timestamps();

            $table->foreign('DepartmentID')->references('DepartmentID')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
