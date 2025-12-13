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
        Schema::create('book_inventory', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->integer('quantity_available')->default(0);
            $table->integer('quantity_sold')->default(0);
            $table->decimal('price', 8, 2);
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->enum('format', ['physical', 'digital', 'both'])->default('physical');
            $table->timestamps();
            $table->unique('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_inventory');
    }
};
