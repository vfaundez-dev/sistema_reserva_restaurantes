<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    
    public function up(): void {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('number_of_peoples');
            $table->string('special_request')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed'])->default('confirmed');
            $table->text('notes');
            $table->timestamps();
            // Foreign Keys
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void {
        Schema::dropIfExists('reservations');
    }
};
