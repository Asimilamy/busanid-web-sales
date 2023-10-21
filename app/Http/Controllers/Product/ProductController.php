<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\SubmitProductRequest;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function create(): \Inertia\Response
    {
        return Inertia::render('Products/Create');
    }

    public function edit(Product $product): \Inertia\Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function submit(SubmitProductRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $action = $request->has('id') ? 'update' : 'create';
        $product = ! $request->has('id')
            ? new Product()
            : Product::find($request->id);
        $product->fill($request->validated());
        $product->save();
        sleep(1);

        return redirect(route('products'))
            ->with('message', 'Successfully ' . $action . ' product!');
    }

    public function destroy(Product $product): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $product->delete();
        sleep(1);

        return redirect(route('products'))
            ->with('message', 'Product deleted successfully!');
    }
}
