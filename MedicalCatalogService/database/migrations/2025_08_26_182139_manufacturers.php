<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('manufacturers', function (Blueprint $table) {
            $table->id('ManufacturerID');
            $table->string('ManufacturerName');
            $table->string('Address')->nullable();
            $table->string('Country')->nullable();
            $table->string('Email')->nullable();
            $table->string('PhoneNumber')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('manufacturers');
    }
};
