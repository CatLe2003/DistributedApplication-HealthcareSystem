<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('User', function (Blueprint $table) {
            $table->id('userid'); // primary key
            $table->string('password_hash', 255);
            $table->string('role', 50);
            $table->string('login_key', 50)->unique();
            $table->boolean('is_active')->default(true);
            $table->bigInteger('referend_id')->default(-1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('User');
    }
};
