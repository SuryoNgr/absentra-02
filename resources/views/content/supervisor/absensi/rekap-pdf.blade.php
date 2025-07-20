<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h3>Rekap Absensi Petugas</h3>
    <p>Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Petugas</th>
                <th>Role</th>
                <th>Check-in</th>
                <th>Checkout</th>
                <th>Status</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absensi as $i => $data)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $data->petugas->nama ?? '-' }}</td>
                    <td>{{ $data->petugas->role ?? '-' }}</td>
                    <td>{{ $data->checkin_at }}</td>
                    <td>{{ $data->checkout_at }}</td>
                    <td>{{ $data->status }}</td>
                    <td>{{ $data->lokasi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
