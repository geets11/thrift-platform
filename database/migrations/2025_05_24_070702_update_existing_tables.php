<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Update categories table if it exists
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'slug')) {
                    $table->string('slug')->unique()->after('name');
                }
                if (!Schema::hasColumn('categories', 'description')) {
                    $table->text('description')->nullable()->after('slug');
                }
                if (!Schema::hasColumn('categories', 'image')) {
                    $table->string('image')->nullable()->after('description');
                }
                if (!Schema::hasColumn('categories', 'is_active')) {
                    $table->boolean('is_active')->default(true)->after('image');
                }
            });
        }

        // Update products table if it exists
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'slug')) {
                    $table->string('slug')->unique()->after('name');
                }
                if (!Schema::hasColumn('products', 'original_price')) {
                    $table->decimal('original_price', 10, 2)->nullable()->after('price');
                }
                if (!Schema::hasColumn('products', 'size')) {
                    $table->string('size')->nullable()->after('original_price');
                }
                if (!Schema::hasColumn('products', 'brand')) {
                    $table->string('brand')->nullable()->after('size');
                }
                if (!Schema::hasColumn('products', 'condition')) {
                    $table->enum('condition', ['excellent', 'very_good', 'good', 'fair'])->default('good')->after('brand');
                }
                if (!Schema::hasColumn('products', 'images')) {
                    $table->json('images')->nullable()->after('condition');
                }
                if (!Schema::hasColumn('products', 'is_available')) {
                    $table->boolean('is_available')->default(true)->after('images');
                }
                if (!Schema::hasColumn('products', 'is_featured')) {
                    $table->boolean('is_featured')->default(false)->after('is_available');
                }
                if (!Schema::hasColumn('products', 'seller_id')) {
                    $table->foreignId('seller_id')->default(1)->constrained('users')->after('category_id');
                }
            });
        }
    }

    public function down()
    {
        // Rollback logic if needed
    }
};