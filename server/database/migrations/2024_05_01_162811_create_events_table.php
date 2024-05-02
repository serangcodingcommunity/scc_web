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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('narasumber_id');
            $table->string('title')->unique();
            $table->string('slug');
            $table->text('keterangan');
            $table->string('image');
            $table->decimal('price');
            $table->integer('quota');
            $table->string('status');
            $table->date('publish_date');
            $table->date('event_date');
            $table->tinyInteger('published');
            $table->string('lokasi');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('narasumber_id')->references('id')->on('narasumbers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
