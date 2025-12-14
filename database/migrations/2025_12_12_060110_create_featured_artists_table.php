<?php
// database/migrations/2025_12_13_000004_create_featured_artists_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('featured_artists')) {
            Schema::create('featured_artists', function (Blueprint $table) {
                $table->id();

                // Nullable foreign key to admins table with ON DELETE SET NULL
                $table->foreignId('admin_id')
                      ->nullable()
                      ->constrained('admins')
                      ->onDelete('set null');

                // Nullable foreign key to sellers table with ON DELETE CASCADE
                $table->foreignId('seller_id')
                      ->nullable()
                      ->constrained('sellers')
                      ->onDelete('cascade');

                $table->string('name');
                $table->string('tribe');
                $table->string('craft');
                $table->string('image')->nullable();
                $table->text('description')->nullable();
                $table->integer('display_order')->default(0);
                $table->boolean('active')->default(true);

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_artists');
    }
};