<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

$username = $_SESSION['username'];

// Data barang
$kode_barang = ['BRG001', 'BRG002', 'BRG003', 'BRG004', 'BRG005'];
$nama_barang = ['HVS', 'Map', 'Stabilo', 'Tinta spidol', 'Tinta pulpen'];
$harga_barang = [3000, 7000, 2000, 5000, 8000];

// Menampung nilai random transaksi
$beli = [];
$jumlah = [];
$total = [];
$grandtotal = 0;

$jumlah_transaksi = 5;

// Generate transaksi random
for ($i = 0; $i < $jumlah_transaksi; $i++) {
    $indexBarang = rand(0, count($kode_barang) - 1);

    $beli[$i] = $indexBarang;
    $jumlah[$i] = rand(1, 5); // jumlah beli random 1–5
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - POLGAN MART</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }
        .wrapper {
            width: 800px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .logout-btn {
            padding: 6px 10px;
            background: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #999;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background: #e9ecef;
        }
        .summary {
            margin-top: 15px;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="wrapper">
    
    <div class="header">
        <div>
            <strong>-- POLGAN MART --</strong><br>
            Selamat datang, <strong><?php echo htmlspecialchars($username); ?></strong>
        </div>

        <a class="logout-btn" href="logout.php">Logout</a>
    </div>

    <h2>Daftar Penjualan (Random)</h2>

    <table>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
        </tr>

        <?php
        $no = 1;

        foreach ($beli as $key => $indexBarang) {
            $kode = $kode_barang[$indexBarang];
            $nama = $nama_barang[$indexBarang];
            $harga = $harga_barang[$indexBarang];
            $qty   = $jumlah[$key];

            $subtotal = $harga * $qty;
            $grandtotal += $subtotal;
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $kode; ?></td>
                <td><?php echo $nama; ?></td>
                <td>Rp <?php echo number_format($harga, 0, ',', '.'); ?></td>
                <td><?php echo $qty; ?></td>
                <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>
        <?php } ?>
    </table>

    <?php  
    // Menentukan diskon
    if ($grandtotal < 50000) {
        $diskonPersen = 5;
    } elseif ($grandtotal <= 100000) {
        $diskonPersen = 10;
    } else {
        $diskonPersen = 15;
    }

    $diskonNominal = $grandtotal * $diskonPersen / 100;
    $totalAkhir = $grandtotal - $diskonNominal;
    ?>

    <div class="summary">
        <p><strong>Total Belanja:</strong> Rp <?php echo number_format($grandtotal, 0, ',', '.'); ?></p>
        <p><strong>Diskon (<?php echo $diskonPersen; ?>%):</strong> Rp <?php echo number_format($diskonNominal, 0, ',', '.'); ?></p>
        <p><strong>Total Akhir:</strong> Rp <?php echo number_format($totalAkhir, 0, ',', '.'); ?></p>
    </div>

</div>

</body>
</html>