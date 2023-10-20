<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return Inertia::render('Product/Index', [
            'products' => $products
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        sleep(1);

        return redirect(route('products'))->with('message', 'Product deleted successfully!');
    }
}
