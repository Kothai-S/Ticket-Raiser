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
        Schema::create('ticket_raises', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('category_id');
            $table->string('reason');
            $table->string('image');
            $table->string('link');
            $table->string('current_date');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_raises');
    }
};


