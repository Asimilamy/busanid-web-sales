<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Salesperson;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'salesperson_id' => Salesperson::factory(),
            'date' => Date::parse()
                ->subDays(rand(1, 15))
                ->subMonths(rand(1, 12))
                ->format('Y-m-d'),
            'type' => $this->faker->randomElement(['barang', 'jasa']),
            'grandtotal' => 0
        ];
    }
}
