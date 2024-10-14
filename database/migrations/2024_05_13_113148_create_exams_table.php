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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name', length: 100);
            $table->string('time', length: 100);
            $table->string('exam_passkey', length: 250);
            $table->string('mark_per_que', length: 10)->default(1);
            $table->string('passing_criteria', length: 10);
            $table->integer('retake')->default(0);
            $table->integer('view_result')->default(0);
            $table->integer('is_active')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
