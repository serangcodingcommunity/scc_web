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
        Schema::create('certificates', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->unsignedBigInteger('registrasi_event_id');
            $table->unsignedBigInteger('event_id');
            $table->timestamps();
            
            // Relationship-to-event & registrasi event
            $table->foreign('registrasi_event_id')->references('id')->on('registrasi_events');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
