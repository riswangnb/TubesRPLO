<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ $filterType == 'harian' ? 'Harian' : ($filterType == 'bulanan' ? 'Bulanan' : 'Custom') }} - {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .report-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 3px solid #56C5D0;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #56C5D0;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-top: 15px;
        }
        .report-period {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }
        .print-info {
            font-size: 12px;
            color: #999;
            margin-top: 10px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-card {
            padding: 20px;
            border-left: 4px solid #56C5D0;
            background-color: #f9fafb;
        }
        .summary-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 30px 0 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #56C5D0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        thead {
            background-color: #56C5D0;
            color: white;
        }
        thead th {
            padding: 12px 8px;
            text-align: left;
            font-size: 12px;
            font-weight: 600;
        }
        tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
            color: #333;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #b45309;
        }
        .status-proses {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-selesai {
            background-color: #dcfce7;
            color: #166534;
        }
        .status-diambil {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        .breakdown-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }
        .breakdown-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 5px;
            margin-bottom: 8px;
        }
        .breakdown-label {
            font-size: 13px;
            color: #666;
        }
        .breakdown-value {
            font-size: 13px;
            font-weight: bold;
            color: #333;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: right;
            color: #999;
            font-size: 12px;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
        .signature-line {
            margin-top: 80px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .report-container {
                box-shadow: none;
                padding: 20px;
            }
            .no-print {
                display: none;
            }
            @page {
                margin: 1cm;
            }
        }
        .print-button {
            background-color: #56C5D0;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .print-button:hover {
            background-color: #45a3ad;
        }
        .back-button {
            background-color: #6b7280;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin-left: 10px;
            text-decoration: none;
            display: inline-block;
        }
        .back-button:hover {
            background-color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="no-print" style="max-width: 1000px; margin: 0 auto 20px;">
        <button onclick="window.print()" class="print-button">🖨️ Cetak Laporan</button>
        <a href="{{ route('admin.laporan.index', request()->query()) }}" class="back-button">← Kembali</a>
    </div>

    <div class="report-container">
        <!-- Header -->
        <div class="header">
            <div class="company-name">FreshClean Laundry</div>
            <div class="report-title">Laporan {{ $filterType == 'harian' ? 'Harian' : ($filterType == 'bulanan' ? 'Bulanan' : 'Custom') }}</div>
            <div class="report-period">
                Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
            </div>
            <div class="print-info">
                Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i:s') }}
            </div>
        </div>

        <!-- Summary -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Orders</div>
                <div class="summary-value">{{ $totalOrders }}</div>
            </div>
            <div class="summary-card" style="border-left-color: #10b981;">
                <div class="summary-label">Total Pendapatan</div>
                <div class="summary-value" style="font-size: 18px;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card" style="border-left-color: #f59e0b;">
                <div class="summary-label">Total Berat</div>
                <div class="summary-value">{{ number_format($totalBerat, 1) }} kg</div>
            </div>
            <div class="summary-card" style="border-left-color: #8b5cf6;">
                <div class="summary-label">Rata-rata/Order</div>
                <div class="summary-value" style="font-size: 18px;">Rp {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 0, ',', '.') : 0 }}</div>
            </div>
        </div>

        <!-- Breakdown Section -->
        <h3 class="section-title">Breakdown Per Status & Layanan</h3>
        <div class="breakdown-grid">
            <!-- By Status -->
            <div>
                <h4 style="font-size: 14px; margin-bottom: 10px; color: #666;">Per Status</h4>
                @foreach($ordersByStatus as $item)
                <div class="breakdown-item">
                    <div>
                        <span class="status-badge status-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                        <span class="breakdown-label" style="margin-left: 10px;">{{ $item->total }} order</span>
                    </div>
                    <span class="breakdown-value">Rp {{ number_format($item->revenue, 0, ',', '.') }}</span>
                </div>
                @endforeach
                @if($ordersByStatus->isEmpty())
                <p style="text-align: center; color: #999; padding: 20px;">Tidak ada data</p>
                @endif
            </div>

            <!-- By Package -->
            <div>
                <h4 style="font-size: 14px; margin-bottom: 10px; color: #666;">Per Layanan</h4>
                @foreach($ordersByPackage as $item)
                <div class="breakdown-item">
                    <div>
                        <div class="breakdown-label" style="font-weight: 600; color: #333;">{{ $item->package->nama ?? 'Custom' }}</div>
                        <div class="breakdown-label" style="font-size: 11px;">{{ $item->total }} order • {{ number_format($item->total_berat, 1) }} kg</div>
                    </div>
                    <span class="breakdown-value">Rp {{ number_format($item->revenue, 0, ',', '.') }}</span>
                </div>
                @endforeach
                @if($ordersByPackage->isEmpty())
                <p style="text-align: center; color: #999; padding: 20px;">Tidak ada data</p>
                @endif
            </div>
        </div>

        <!-- Orders Table -->
        <h3 class="section-title">Detail Orders</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 15%;">Invoice</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 20%;">Pelanggan</th>
                    <th style="width: 18%;">Layanan</th>
                    <th style="width: 10%;" class="text-center">Berat</th>
                    <th style="width: 12%;" class="text-right">Total</th>
                    <th style="width: 8%;" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $order->invoice_number ?? '-' }}</td>
                    <td>{{ is_string($order->tanggal_order) ? \Carbon\Carbon::parse($order->tanggal_order)->format('d/m/Y') : $order->tanggal_order->format('d/m/Y') }}</td>
                    <td>{{ $order->pelanggan->nama }}</td>
                    <td>{{ $order->package->nama ?? '-' }}</td>
                    <td class="text-center">{{ $order->berat ? number_format($order->berat, 1) . ' kg' : '-' }}</td>
                    <td class="text-right" style="font-weight: 600;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td class="text-center">
                        <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                    </td>
                </tr>
                @endforeach
                @if($orders->isEmpty())
                <tr>
                    <td colspan="8" class="text-center" style="padding: 30px; color: #999;">Tidak ada data untuk periode ini</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
                <tr style="background-color: #f9fafb; font-weight: bold;">
                    <td colspan="5" class="text-right" style="padding: 12px 8px;">TOTAL</td>
                    <td class="text-center">{{ number_format($totalBerat, 1) }} kg</td>
                    <td class="text-right" style="color: #56C5D0;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Dibuat oleh,</p>
                <div class="signature-line">
                    <p style="font-size: 13px; color: #333;">Admin</p>
                </div>
            </div>
            <div class="signature-box">
                <p style="font-size: 12px; color: #666; margin-bottom: 5px;">Mengetahui,</p>
                <div class="signature-line">
                    <p style="font-size: 13px; color: #333;">Owner</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>FreshClean Laundry - Jl. Bersih No. 123, Jakarta Selatan</p>
            <p>Telp: 0812-3456-7890 | Email: info@freshclean.com</p>
        </div>
    </div>
</body>
</html>
