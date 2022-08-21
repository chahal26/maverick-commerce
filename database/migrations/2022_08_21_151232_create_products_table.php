<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('default');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->string('SKU')->nullable();
            $table->text('description')->nullable();
            $table->float('actual_price')->default(0);
            $table->float('selling_price')->default(0);
            $table->float('shipping_charges')->default(0);
            $table->integer('stock')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
