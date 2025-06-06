<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_available')->default(true);
            $table->integer('capacity');
            $table->enum('location', ['indoor', 'outdoor'])->default('indoor');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tables');
    }
};
