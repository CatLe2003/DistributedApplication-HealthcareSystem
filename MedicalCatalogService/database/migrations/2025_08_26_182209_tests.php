<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tests', function (Blueprint $table) {
            $table->id('TestID');
            $table->string('TestName');
            $table->text('Description')->nullable();
            $table->decimal('Price', 12, 2)->nullable();
            $table->unsignedBigInteger('DepartmentID')->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tests');
    }
};
