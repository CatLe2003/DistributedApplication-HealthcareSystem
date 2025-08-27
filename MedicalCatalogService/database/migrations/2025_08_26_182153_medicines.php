<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id('MedicineID');
            $table->string('MedicineName');
            $table->text('Ingredient')->nullable();
            $table->unsignedBigInteger('FormID');
            $table->unsignedBigInteger('UnitID');
            $table->string('Packaging')->nullable();
            $table->text('DosageInstruction')->nullable();
            $table->text('Indication')->nullable();
            $table->text('Contraindication')->nullable();
            $table->text('SideEffect')->nullable();
            $table->text('Storage')->nullable();
            $table->unsignedBigInteger('ManufacturerID');
            $table->decimal('Price', 12, 2)->nullable();
            $table->integer('InStock')->default(0);
            $table->boolean('Status')->default(true);
            $table->timestamps();

            // Foreign keys
            $table->foreign('FormID')->references('FormID')->on('forms')->onDelete('cascade');
            $table->foreign('UnitID')->references('UnitID')->on('units')->onDelete('cascade');
            $table->foreign('ManufacturerID')->references('ManufacturerID')->on('manufacturers')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('medicines');
    }
};
