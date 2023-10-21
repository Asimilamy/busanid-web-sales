<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salesperson_id')
                ->constrained('salespeople')
                ->cascadeOnDelete();
            $table->date('date');
            $table->string('type');
            $table->double('grandtotal');
            $table->timestamps();
        });

        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')
                ->constrained('transactions')
                ->cascadeOnDelete();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();
            $table->double('qty')->default(0);
            $table->double('value')->default(0);
            $table->double('subtotal')->default(0);
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
        Schema::dropIfExists('transaction_details');
        Schema::dropIfExists('transactions');
    }
};
