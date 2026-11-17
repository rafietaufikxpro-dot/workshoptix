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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workshop_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('amount');
            $table->string('order_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->string('ticket_code')->nullable()->unique();
            $table->timestamps();

            $table->unique(['user_id', 'workshop_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
