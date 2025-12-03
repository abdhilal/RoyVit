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
        Schema::create('tree_products', function (Blueprint $table) {
            $table->id();
            $table->string('factory');
            $table->string('name');
            $table->integer('quantity');
            $table->decimal('Regular_price');
            $table->decimal('General_price');
            $table->decimal('wholesale_price');
            $table->integer('Bonus1');
            $table->integer('Bonus2');

            $table->tinyInteger('month')->unsigned();
            $table->smallInteger('year')->unsigned();
            $table->date('month_year')->nullable();

            $table->foreignId('warehouse_id')->nullable()->constrained()->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tree_products');
    }
};
