<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\SubmitTransactionRequest;
use App\Models\Product;
use App\Models\Salesperson;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Inertia\Inertia;

class TransactionController extends Controller
{
    private function defaultProps(): mixed
    {
        $products = Product::all()->toArray();
        $salespeople = Salesperson::all()
            ->map(function ($item) {
                $sales['id'] = $item->id;
                $sales['name'] = $item->user->name;

                return $sales;
            })->toArray();

        return [
            'products' => $products,
            'salespeople' => $salespeople
        ];
    }

    public function create(): \Inertia\Response
    {
        $props = $this->defaultProps();

        return Inertia::render('Transactions/Create', $props);
    }

    public function edit(Transaction $transaction): \Inertia\Response
    {
        $props = array_merge([
            'transaction' => $transaction,
            'transDetails' => $transaction->details
        ], $this->defaultProps());

        return Inertia::render('Transactions/Edit', $props);
    }

    public function submit(SubmitTransactionRequest $request): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $action = $request->has('id') ? 'update' : 'create';
        $transaction = ! $request->has('id')
            ? new Transaction()
            : Transaction::find($request->id);
        $transaction->fill($request->except('details'));
        $transaction->save();
        $transaction->details()->delete();

        $detailModels = collect();
        collect($request->only('details'))->map(function ($details) use ($detailModels) {
            foreach ($details as $detail) {
                $detailModels->push($detail);
            }
        });
        $details = $detailModels->map(function ($detail) {
            return new TransactionDetail($detail);
        });
        $transaction->details()->saveMany($details);
        sleep(1);

        return redirect(route('transactions'))
            ->with('message', 'Successfully ' . $action . ' transaction!');
    }

    public function destroy(Transaction $transaction): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
    {
        $transaction->delete();
        sleep(1);

        return redirect(route('transactions'))
            ->with('message', 'Transaction deleted successfully!');
    }
}
