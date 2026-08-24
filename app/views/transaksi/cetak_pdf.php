<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #333;
        margin: 20px;
    }

    .header {
        text-align: center;
        margin-bottom: 25px;
        border-bottom: 2px solid #2b5748;
        padding-bottom: 10px;
    }

    .header h2 {
        margin: 0;
        color: #2b5748;
        text-transform: uppercase;
    }

    .header p {
        margin: 5px 0 0 0;
        color: #666;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th {
        background-color: #2b5748;
        color: white;
        padding: 8px;
        text-align: center;
        font-size: 11px;
    }

    td {
        padding: 8px;
        font-size: 11px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .badge-selesai {
        color: #155724;
        background-color: #d4edda;
        padding: 3px 8px;
        border-radius: 4px;
        font-weight: bold;
        font-size: 10px;
    }

    .summary-box {
        margin-top: 20px;
        float: right;
        width: 300px;
    }

    .summary-box table {
        border: none;
    }

    .summary-box td {
        border: none;
        padding: 4px 8px;
    }

    @media print {
        .no-print {
            display: none;
        }
    }
    </style>
</head>

<body onload="window.print();">

    <!-- Tombol Cetak / Simpan PDF versi Browser -->
    <div class="no-print" style="margin-bottom: 15px;">
        <button onclick="window.print()"
            style="padding: 8px 16px; background-color: #2b5748; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Cetak / Simpan PDF
        </button>
        <button onclick="window.close()"
            style="padding: 8px 16px; background-color: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Tutup
        </button>
    </div>

    <!-- Header Laporan -->
    <div class="header">
        <h2>Laporan Penjualan</h2>
        <small>Dicetak pada: <?= date('d-m-Y H:i'); ?></small>
    </div>

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="6%">Jenis</th>
                <th width="6%">Metode Bayar</th>
                <th width="20%">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $totalPendapatan = 0;
            if (!empty($dataTransaksi)): 
                foreach ($dataTransaksi as $row): 
                    $totalPendapatan += $row['total'];

                    // Menggunakan nama kolom yang benar: tanggal_dibuat
                    $rawTanggal = $row['tanggal_dibuat'] ?? null;
                    if (!empty($rawTanggal) && strtotime($rawTanggal) !== false) {
                        $tanggalFormatted = date('d-m-Y', strtotime($rawTanggal));
                    } else {
                        $tanggalFormatted = '-';
                    }
            ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td class="text-center"><?= str_pad($row['id_transaksi'], 5, "0", STR_PAD_LEFT); ?></td>
                <td class="text-center"><?= $tanggalFormatted; ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? 'Umum'); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['jenis_transaksi']); ?></td>
                <td class="text-center"><?= htmlspecialchars($row['metode_pembayaran']); ?></td>
                <td class="text-right">Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Tidak ada data transaksi yang berstatus Selesai.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Ringkasan Total -->
    <?php if (!empty($dataTransaksi)): ?>
    <div class="summary-box">
        <table>
            <tr>
                <td><strong>Total Transaksi:</strong></td>
                <td class="text-right"><?= count($dataTransaksi); ?> Transaksi</td>
            </tr>
            <tr style="font-size: 14px; color: #2b5748;">
                <td><strong>Total Pendapatan:</strong></td>
                <td class="text-right"><strong>Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?></strong></td>
            </tr>
        </table>
    </div>
    <?php endif; ?>

</body>

</html>