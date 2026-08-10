<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            $table->string('code')->unique();

            $table->foreignId('package_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('flavor_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('price',12,2);
            $table->enum('sale_type',[
                'eceran',
                'distributor',
                'keduanya'
            ])->default('keduanya');

            $table->integer('stock')->default(0);

            $table->integer('minimum_stock')->default(10);

            $table->string('image')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};