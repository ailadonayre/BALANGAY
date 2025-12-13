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
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('indigenous_tribe')->nullable();
            $table->string('seller_type')->default('individual');
            $table->string('shop_name')->nullable();
            $table->text('shop_description')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('verification_status')->default('approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn([
                'indigenous_tribe',
                'seller_type',
                'shop_name',
                'shop_description',
                'profile_picture',
                'banner_image',
                'address',
                'city',
                'province',
                'postal_code',
                'verification_status'
            ]);
        });
    }
};
