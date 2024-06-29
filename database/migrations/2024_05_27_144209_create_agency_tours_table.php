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
        Schema::create('agency_tours', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('location');
            $table->string('charge');
            $table->string('max_people');
            $table->string('duration');
            $table->enum('status', ['created', 'running', 'completed']);
            $table->text('description');
            $table->text('included');
            $table->text('excluded');
            $table->text('highlights');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('thumbnail');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_tours');
    }
};
