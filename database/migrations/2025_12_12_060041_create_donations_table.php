<?php
// database/migrations/2025_12_13_000003_create_donations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('donations')) {
            Schema::create('donations', function (Blueprint $table) {
                $table->id();
                // Nullable foreign key to admins table with ON DELETE SET NULL
                $table->foreignId('admin_id')
                      ->nullable()
                      ->constrained('admins')
                      ->onDelete('set null');

                $table->string('title');
                $table->text('description');
                $table->decimal('target_amount', 10, 2)->nullable();
                $table->decimal('current_amount', 10, 2)->default(0);
                $table->string('tribe')->nullable();
                $table->string('image')->nullable();

                // status (active, completed, paused)
                $table->string('status')->default('active');

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};