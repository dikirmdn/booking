<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        .stats {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .stats-row {
            display: table;
            width: 100%;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            width: 20%;
        }
        .stat-number {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .status {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .status-cancelled { background-color: #e2e3e5; color: #383d41; }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Booking Ruang Meeting</h1>
        <p>Periode: {{ $period }}</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="stats">
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Booking</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['approved'] }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['pending'] }}</div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['rejected'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $stats['cancelled'] }}</div>
                <div class="stat-label">Dibatalkan</div>
            </div>
        </div>
    </div>

    @if($bookings->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Booking</th>
                <th>Ruangan</th>
                <th>Judul</th>
                <th>Pemesan</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $booking->created_at->format('d/m/Y') }}</td>
                <td>{{ $booking->room->name }}</td>
                <td>{{ $booking->title }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->start_time->format('d/m/Y H:i') }}</td>
                <td>{{ $booking->end_time->format('d/m/Y H:i') }}</td>
                <td>
                    @if($booking->status === 'approved')
                        <span class="status status-approved">Disetujui</span>
                    @elseif($booking->status === 'pending')
                        <span class="status status-pending">Pending</span>
                    @elseif($booking->status === 'rejected')
                        <span class="status status-rejected">Ditolak</span>
                    @else
                        <span class="status status-cancelled">Dibatalkan</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p>Tidak ada data booking untuk periode yang dipilih.</p>
    </div>
    @endif

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem pada {{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>