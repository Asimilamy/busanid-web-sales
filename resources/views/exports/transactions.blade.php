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
            <th>{{ $salesperson->transactions->unique('date')->count() }}</th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'barang';
                })->count() }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'jasa';
                })->count() }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'barang';
                })
                ->sum('grandtotal') }}
            </th>
            <th>
                {{ $salesperson->transactions->filter(function ($item) {
                    return $item['type'] == 'jasa';
                })
                ->sum('grandtotal') }}
            </th>
        </tr>
    @endforeach
</table>
