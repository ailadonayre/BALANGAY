<?php
// database/migrations/2025_12_13_000002_create_stories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('stories')) {
            Schema::create('stories', function (Blueprint $table) {
                $table->id();
                // Nullable foreign key to admins table with ON DELETE SET NULL
                $table->foreignId('admin_id')
                      ->nullable()
                      ->constrained('admins')
                      ->onDelete('set null');

                $table->string('title');
                $table->string('author_name');
                $table->text('excerpt');
                $table->text('content');
                $table->string('image')->nullable();
                $table->string('tribe')->nullable();
                $table->boolean('published')->default(false);
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('stories');
    }
};