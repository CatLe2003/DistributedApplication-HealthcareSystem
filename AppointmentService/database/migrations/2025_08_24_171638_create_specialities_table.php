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
        Schema::create('specialities', function (Blueprint $table) {
            $table->id('SpecialityID');
            $table->string('SpecialityName');
            $table->text('Description')->nullable();
            $table->unsignedBigInteger('DepartmentID');
            $table->timestamps();

            $table->foreign('DepartmentID')->references('DepartmentID')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialities');
    }
};
