<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('reservation_table', function (Blueprint $table) {
            // Foreign Keys
            $table->foreignId('reservation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('table_id')->constrained()->cascadeOnDelete();
            $table->primary(['reservation_id', 'table_id']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservation_table_pivot');
    }
};
