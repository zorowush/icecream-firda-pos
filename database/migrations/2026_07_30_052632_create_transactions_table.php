<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {

            $table->id();
            $table->string('invoice')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('partner_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('sale_type', [
                'eceran',
                'distributor'
            ]);
            $table->decimal('subtotal',12,2);
            $table->decimal('discount',12,2)->default(0);
            $table->decimal('grand_total',12,2);
            $table->enum('payment_method',[
                'cash',
                'qris',
                'transfer'
            ]);
            $table->enum('payment_status',[
                'paid',
                'unpaid'
            ])->default('paid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};