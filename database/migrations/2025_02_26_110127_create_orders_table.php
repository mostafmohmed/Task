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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('user_name');
          
            $table->string('address_name');
            $table->string('building_number');
            
        
            
            $table->decimal('total_price',8,2);
            $table->string('user_phone');
$table->enum('status',['panding','shipped','deliverd'])->default('panding');
$table->string('country');
$table->enum('payment_method',['paypal','Stripe']);

            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
