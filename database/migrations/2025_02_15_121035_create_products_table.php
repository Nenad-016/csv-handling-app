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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_number')->unique();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->string('manufacturer_name');
            $table->string('upc')->unique();
            $table->string('sku')->unique();
            $table->decimal('regular_price', 8, 2);
            $table->decimal('sale_price', 8, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->index(['created_at', 'updated_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
