<?php

namespace App\Exports;

use App\Models\Salesperson;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Query\JoinClause;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TransactionsExport implements FromView, ShouldAutoSize
{
    public string $startDate;
    public string $endDate;

    public function __construct(string $startDate, string $endDate)
    {
        $this->startDate = $startDate ?? now()->subDays(7)->format('Y-m-d');
        $this->endDate = $endDate ?? now()->format('Y-m-d');
    }

    public function view(): View
    {
        return view('exports.transactions', [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'salespeople' => Salesperson::query()
                ->with(['user', 'transactions', 'transactions.details', 'transactions.details.product'])
                ->get()
        ]);
    }
}
