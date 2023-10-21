<table>
    <tr>
        <td><strong>Requestor</strong></td>
        <td>{{ auth()->user()->name }} ({{ auth()->user()->email }})</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><strong>Parameter</strong></td>
        <td></td>
    </tr>
    <tr>
        <td><strong>Start Date</strong></td>
        <td>{{ $startDate }}</td>
    </tr>
    <tr>
        <td><strong>End Date</strong></td>
        <td>{{ $endDate }}</td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <th><strong>User</strong></th>
        <th><strong>Jumlah Hari Kerja</strong></th>
        <th><strong>Jumlah Transaksi Barang</strong></th>
        <th><strong>Jumlah Transaksi Jasa</strong></th>
        <th><strong>Nominal Transaksi Barang</strong></th>
        <th><strong>Nominal Transaksi Jasa</strong></th>
    </tr>
    @foreach ($salespeople as $salesperson)
        <tr>
            <th>{{ $salesperson->user->name }}</th>
            <th>
                {{ $salesperson->transactions
                ->whereBetween('date', [$startDate, $endDate])
                ->unique('date')->count() }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'barang';
                })->whereBetween('date', [$startDate, $endDate])
                ->count() }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'jasa';
                })->whereBetween('date', [$startDate, $endDate])
                ->count() }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'barang';
                })
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('grandtotal') }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'jasa';
                })
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('grandtotal') }}
            </th>
        </tr>
    @endforeach
</table>
