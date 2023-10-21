<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $qty = rand(1, 9);
        $value = $this->faker->randomNumber(rand(5, 7));
        $subtotal = $value * $qty;

        return [
            'transaction_id' => Transaction::factory(),
            'product_id' => Product::factory(),
            'qty' => $qty,
            'value' => $value,
            'subtotal' => $subtotal
        ];
    }
}
