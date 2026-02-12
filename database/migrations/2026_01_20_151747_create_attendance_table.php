<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {  // Changed from 'attendance' to 'attendances'
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('term');
            $table->string('session');
            $table->integer('days_present')->default(0);
            $table->integer('days_absent')->default(0);
            $table->integer('total_days')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');  // Changed here too
    }
};