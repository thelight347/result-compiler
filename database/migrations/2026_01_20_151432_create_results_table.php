<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');
            $table->string('term');
            $table->string('session');
            
            // Changed: Multiple CA scores instead of single test_score
            $table->decimal('ca1_score', 5, 2)->default(0);  // First CA (10 marks)
            $table->decimal('ca2_score', 5, 2)->default(0);  // Second CA (10 marks)
            $table->decimal('ca3_score', 5, 2)->default(0);  // Third CA (10 marks)
            $table->decimal('exam_score', 5, 2)->default(0); // Exam (70 marks)
            $table->decimal('total_score', 5, 2)->default(0); // Total (100 marks)
            
            $table->string('grade')->nullable();
            $table->text('remark')->nullable();
            $table->boolean('is_released')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->timestamp('released_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};