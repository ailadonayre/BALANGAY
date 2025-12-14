<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (!Schema::hasColumn('sellers', 'indigenous_tribe')) {
                $table->string('indigenous_tribe')->default('Unspecified')->after('community');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            if (Schema::hasColumn('sellers', 'indigenous_tribe')) {
                $table->dropColumn('indigenous_tribe');
            }
        });
    }
};
