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
        Schema::create('_ticketcomments', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id');
            $table->string('comments');
            $table->string('ticket_reason');
            $table->string('assign_person');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_ticketcomments');
    }
};
