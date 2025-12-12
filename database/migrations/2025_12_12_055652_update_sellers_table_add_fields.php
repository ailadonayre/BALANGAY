<?php
// database/migrations/2025_12_13_000000_update_sellers_table_add_fields.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // seller_type (solo, enterprise)
            if (!Schema::hasColumn('sellers', 'seller_type')) {
                $table->string('seller_type')->default('solo')->after('indigenous_tribe');
                $table->check("seller_type IN ('solo', 'enterprise')");
            }

            // shop_name
            if (!Schema::hasColumn('sellers', 'shop_name')) {
                $table->string('shop_name')->nullable()->after('seller_type');
            }

            // shop_description
            if (!Schema::hasColumn('sellers', 'shop_description')) {
                $table->text('shop_description')->nullable()->after('shop_name');
            }

            // profile_picture
            if (!Schema::hasColumn('sellers', 'profile_picture')) {
                $table->string('profile_picture')->nullable()->after('shop_description');
            }

            // banner_image
            if (!Schema::hasColumn('sellers', 'banner_image')) {
                $table->string('banner_image')->nullable()->after('profile_picture');
            }

            // verification_status (pending, approved, rejected)
            if (!Schema::hasColumn('sellers', 'verification_status')) {
                $table->string('verification_status')->default('pending')->after('banner_image');
                $table->check("verification_status IN ('pending', 'approved', 'rejected')");
            }
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'seller_type',
                'shop_name',
                'shop_description',
                'profile_picture',
                'banner_image',
                'verification_status'
            ]);
        });
    }
};