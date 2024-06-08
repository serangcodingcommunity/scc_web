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
            $table->unsignedBigInteger('nid_1')->nullable();
            $table->unsignedBigInteger('nid_2')->nullable();
            $table->unsignedBigInteger('nid_3')->nullable();
            $table->unsignedBigInteger('nid_4')->nullable();
            $table->unsignedBigInteger('nid_5')->nullable();
            $table->unsignedBigInteger('nid_6')->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->unsignedBigInteger('approve_by')->nullable();
            $table->string('title')->unique();
            $table->string('slug');
            $table->text('keterangan');
            $table->text('pesan');
            $table->string('image');
            $table->decimal('price');
            $table->integer('quota');
            $table->string('status');
            $table->date('publish_date');
            $table->date('event_date');
            $table->date('approve_date');
            $table->tinyInteger('published');
            $table->tinyInteger('certified');
            $table->string('lokasi');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('approve_by')->references('id')->on('users');
            $table->foreign('partner_id')->references('id')->on('partners');
            $table->foreign('nid_1')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_2')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_3')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_4')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_5')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('nid_6')->references('id')->on('narasumbers')->noActionOnDelete()->noActionOnUpdate();
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
