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
            $table->string('amount');
            $table->string('duration');
            $table->string('person');
            $table->text('description');
            $table->text('included');
            $table->text('excluded');
            $table->text('highlights');
            $table->string('location');
            $table->string('thumbnail');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->enum('status', ['start', 'done']);
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
