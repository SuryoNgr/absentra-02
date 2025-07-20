<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Aktivitas Petugas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: center; }
        th { background-color: #eee; }
        h3, p { text-align: center; }
    </style>
</head>
<body>
    <h3>Laporan Aktivitas Petugas</h3>
    @if($petugasNama)
        <p>Nama Petugas: <strong>{{ $petugasNama }}</strong></p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Role</th>
                <th>Tanggal</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td>{{ $item->petugas->nama }}</td>
                <td>{{ ucfirst($item->petugas->role) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y H:i') }}</td>
                <td>{{ $item->catatan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Tidak ada data aktivitas.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
