<?php

namespace App\Http\Controllers\Transaction;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TransactionsIndex
{
    public function __invoke(): mixed
    {
        $globalSearch = AllowedFilter::callback('global', function (Builder $query, mixed $value) {
            $query->where(function (Builder $query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('name', 'LIKE', '%' . $value . '%')
                        ->orWhere('date', 'LIKE', '%' . $value . '%')
                        ->orWhere('type', 'LIKE', '%' . $value . '%')
                        ->orWhere('grandtotal', 'LIKE', '%' . $value . '%');
                });
            });
        });

        $transactions = QueryBuilder::for(
            Transaction::query()
                ->leftJoin('salespeople', 'transactions.salesperson_id', '=', 'salespeople.id')
                ->leftJoin('users', 'salespeople.user_id', '=', 'users.id')
                ->select([
                    'transactions.*',
                    'users.name'
                ])
        )
            ->defaultSort('-id')
            ->allowedSorts(['id', 'name', 'date', 'type', 'grandtotal'])
            ->allowedFilters(['name', 'date', 'type', 'grandtotal', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Transactions/Index', [
            'transactions' => $transactions,
            'start_date' => now()->subDays(7)->format('Y-m-d'),
            'end_date' => now()->format('Y-m-d'),
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch()
                ->defaultSort('-id')
                ->column(key: 'id', sortable: true)
                ->column(key: 'name', searchable: true, sortable: true)
                ->column(key: 'date', searchable: true, sortable: true)
                ->column(key: 'type', searchable: true, sortable: true)
                ->column(key: 'grandtotal', searchable: true, sortable: true)
                ->column(label: 'Actions');
        });
    }
}
