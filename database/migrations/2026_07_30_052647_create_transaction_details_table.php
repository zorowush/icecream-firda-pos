<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {

            $table->id();
            $table->foreignId('transaction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('product_name');
            $table->integer('qty');
            $table->string('package_name');
            $table->string('flavor_name');
            $table->decimal('price',12,2);
            $table->decimal('subtotal',12,2);
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};