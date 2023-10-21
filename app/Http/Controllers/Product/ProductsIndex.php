<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductsIndex
{
    public function __invoke(): mixed
    {
        $globalSearch = AllowedFilter::callback('global', function (Builder $query, mixed $value) {
            $query->where(function (Builder $query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query->orWhere('name', 'LIKE', '%' . $value . '%')
                        ->orWhere('type', 'LIKE', '%' . $value . '%');
                });
            });
        });

        $products = QueryBuilder::for(Product::class)
            ->defaultSort('-id')
            ->allowedSorts(['id', 'name', 'type'])
            ->allowedFilters(['name', 'type', $globalSearch])
            ->paginate()
            ->withQueryString();

        return Inertia::render('Products/Index', [
            'products' => $products
        ])->table(function (InertiaTable $table) {
            $table->withGlobalSearch()
                ->defaultSort('-id')
                ->column(key: 'id', sortable: true)
                ->column(key: 'name', searchable: true, sortable: true)
                ->column(key: 'type', searchable: true, sortable: true)
                ->column(label: 'Actions');
        });
    }
}
