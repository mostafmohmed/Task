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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prodect_id')->constrained('produects')->cascadeOnDelete();
            $table->foreignId('oreder_id')->nullable()->constrained('orders')->cascadeOnDelete();
            $table->string('produect_name');
       
            $table->integer('produect_quantity');
            $table->decimal('produect_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
