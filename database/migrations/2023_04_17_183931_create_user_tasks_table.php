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
        Schema::create('user_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('remarks', 100)->nullable();
            $table->foreignId('status_id')->references('id')->on('task_statuses')->onDelete('cascade');
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tasks');
    }
};