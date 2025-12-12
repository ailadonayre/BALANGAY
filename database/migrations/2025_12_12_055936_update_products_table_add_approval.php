<?php
// database/migrations/2025_12_13_000001_update_products_table_add_approval.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {

            // approval_status (pending, approved, rejected)
            if (!Schema::hasColumn('products', 'approval_status')) {
                $table->string('approval_status')->default('pending')->after('stock');
                $table->check("approval_status IN ('pending', 'approved', 'rejected')");
            }

            // rejection_reason
            if (!Schema::hasColumn('products', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('approval_status');
            }

            // featured
            if (!Schema::hasColumn('products', 'featured')) {
                $table->boolean('featured')->default(false)->after('rejection_reason');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'approval_status',
                'rejection_reason',
                'featured'
            ]);
        });
    }
};