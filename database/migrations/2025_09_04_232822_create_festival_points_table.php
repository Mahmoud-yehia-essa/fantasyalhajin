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
       Schema::create('festival_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('festival_id')->constrained('festivals')->onDelete('cascade');
            $table->enum('age_name', ['الحقايق','اللقايا','الجذاع','الثنايا','زمول','الحيل']);
            $table->integer('points')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('festival_points');
    }
};
