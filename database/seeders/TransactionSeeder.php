<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Salesperson;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salespeople = Salesperson::pluck('id');
        $salespersonId = $salespeople->count() > 0
            ? $salespeople->random()
            : Salesperson::factory();

        Transaction::factory(10)->create([
            'salesperson_id' => $salespersonId
        ])
            ->map(function (Transaction $item) {
                $productId = Product::query()
                    ->where('type', $item->type)
                    ->get()
                    ->pluck('id')
                    ->toArray();
                for ($i = 0; $i < rand(1, count($productId)); $i++) {
                    TransactionDetail::factory()->create([
                        'transaction_id' => $item->id,
                        'product_id' => $productId[$i]
                    ]);
                }

                $item->grandtotal = $item->details->sum('subtotal') ?? 0;
                $item->save();
            });
    }
}
