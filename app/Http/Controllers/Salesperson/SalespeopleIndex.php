<?php

namespace App\Http\Controllers\Salesperson;

use App\Models\Product;
use App\Models\Salesperson;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SalespeopleIndex
{
    public function __invoke(): mixed
    {
        $globalSearch = AllowedFilter::callback('global', function (Builder $query, mixed $value) {
            $query->where(function (Builder $query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('users.name', 'LIKE', '%' . $value . '%')
                        ->orWhere('users.email', 'LIKE', '%' . $value . '%');
                });
            });
        });

        $salespeople = QueryBuilder::for(
            Salesperson::query()
                ->leftJoin('users', 'salespeople.user_id', '=', 'users.id')
                ->select([
                    'salespeople.id',
                    'users.name',
                    'users.email',
                ])
        )
            ->defaultSort('-id')
            ->allowedSorts(['id', 'name', 'email'])
            ->allowedFilters(['name', 'email', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Salespeople/Index', [
            'salespeople' => $salespeople
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch()
                ->defaultSort('-id')
                ->column(key: 'id', sortable: true)
                ->column(key: 'name', searchable: true, sortable: true)
                ->column(key: 'email', searchable: true, sortable: true)
                ->column(label: 'Actions');
        });
    }
}
