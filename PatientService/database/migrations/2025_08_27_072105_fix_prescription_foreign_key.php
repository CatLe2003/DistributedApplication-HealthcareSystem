<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('prescription', function (Blueprint $table) {
            $table->dropForeign(['visit_id']);
            $table->foreign('visit_id')
                  ->references('id')->on('medicalvisit')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('prescription', function (Blueprint $table) {
            $table->dropForeign(['visit_id']);
            $table->foreign('visit_id')
                  ->references('id')->on('patient')
                  ->onDelete('cascade');
        });
    }
};

