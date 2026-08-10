<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {

            $table->id();

            $table->string('business_name');

            $table->string('owner_name')->nullable();

            $table->string('logo')->nullable();

            $table->string('address')->nullable();

            $table->string('phone')->nullable();

            $table->string('email')->nullable();

            $table->integer('minimum_stock')->default(10);

            $table->decimal('tax', 5, 2)->default(0);

            $table->text('receipt_footer')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};