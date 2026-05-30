<?php
include 'koneksi.php';
include 'auth.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dashboard POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex">

        <!-- SIDEBAR -->
        <div class="w-64 bg-blue-700 min-h-screen text-white">

            <div class="p-4 text-2xl font-bold border-b">
                💰 Mini POS
            </div>

            <ul class="p-4 space-y-2">

                <li>
                    <a href="dashboard.php" class="block p-2 rounded hover:bg-blue-500">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="penjualan_dashboard.php" class="block p-2 rounded hover:bg-blue-500">
                        Transaksi Penjualan
                    </a>
                </li>
                <li>
                    <a href="laporan_harian.php" class="block p-2 rounded hover:bg-blue-500">
                        📅 Laporan Harian
                    </a>
                </li>

                <li>
                    <a href="laporan_bulanan.php" class="block p-2 rounded hover:bg-blue-500">
                        📅 Laporan Bulanan

                    </a>
                </li>

                <li>
                    <a href="laporan_barang_terlaris.php" class="block p-2 rounded hover:bg-blue-500">
                        🏆 Barang Terlaris
                    </a>
                </li>


                <li>
                    <a href="logout.php" class="block p-2 rounded bg-red-500 hover:bg-red-600">
                        Logout
                    </a>
                </li>

            </ul>

        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-6">

            <!-- content -->

            <?php
// include 'koneksi.php';
// include 'auth.php';

$tanggal = $_GET['tanggal'] ?? date('Y-m-d');

$sql = "SELECT 
            p.id,
            p.tanggal,
            p.jumlah,
            p.metode_bayar,
            b.nama_barang,
            b.harga,
            (b.harga * p.jumlah) total
        FROM penjualan p
        JOIN barang b ON p.barang_id = b.id
        WHERE DATE(p.tanggal) = '$tanggal'
        ORDER BY p.id DESC";

$res = $conn->query($sql);

// total transaksi
$totalTransaksi = 0;

// total uang
$totalPenjualan = 0;
?>

            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <title>Laporan Harian</title>
                <script src="https://cdn.tailwindcss.com"></script>
            </head>

            <body class="bg-gray-100 p-6">

                <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

                    <div class="flex justify-between items-center mb-4">

                        <h1 class="text-2xl font-bold">
                            📊 Laporan Harian Penjualan
                        </h1>

                        <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Kembali
                        </a>

                    </div>

                    <!-- FILTER -->
                    <form method="GET" class="flex gap-2 mb-4">

                        <input type="date" name="tanggal" value="<?= $tanggal ?>" class="border p-2 rounded">

                        <button class="bg-blue-500 text-white px-4 rounded">
                            Tampilkan
                        </button>

                        <button type="button" onclick="window.print()" class="bg-green-500 text-white px-4 rounded">
                            Cetak
                        </button>

                    </form>

                    <!-- INFO -->
                    <div class="bg-blue-100 p-3 rounded mb-4">

                        <b>Tanggal:</b>
                        <?= date('d-m-Y', strtotime($tanggal)) ?>

                    </div>

                    <!-- TABLE -->
                    <table class="w-full border border-collapse">

                        <thead class="bg-gray-200">

                            <tr>
                                <th class="border p-2">No</th>
                                <th class="border p-2">ID</th>
                                <th class="border p-2">Tanggal</th>
                                <th class="border p-2">Barang</th>
                                <th class="border p-2">Harga</th>
                                <th class="border p-2">Jumlah</th>
                                <th class="border p-2">Total</th>
                                <th class="border p-2">Pembayaran</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
        $no = 1;

        while($d = $res->fetch_assoc()):

            $totalTransaksi++;
            $totalPenjualan += $d['total'];
        ?>

                            <tr>

                                <td class="border p-2 text-center">
                                    <?= $no++ ?>
                                </td>

                                <td class="border p-2">
                                    <?=$d['id'] ?>
                                </td>
                                <td class="border p-2">
                                    <?= date('d-m-Y H:i', strtotime($d['tanggal'])) ?>
                                </td>

                                <td class="border p-2">
                                    <?= $d['nama_barang'] ?>
                                </td>

                                <td class="border p-2 text-right">
                                    Rp <?= number_format($d['harga']) ?>
                                </td>

                                <td class="border p-2 text-center">
                                    <?= $d['jumlah'] ?>
                                </td>

                                <td class="border p-2 text-right">
                                    Rp <?= number_format($d['total']) ?>
                                </td>

                                <td class="border p-2 text-center">
                                    <?= $d['metode_bayar'] ?>
                                </td>

                            </tr>

                            <?php endwhile; ?>

                        </tbody>

                        <!-- FOOTER -->
                        <tfoot class="bg-gray-100 font-bold">

                            <tr>

                                <td colspan="6" class="border p-2 text-right">
                                    TOTAL PENJUALAN
                                </td>

                                <td class="border p-2 text-right text-red-600">
                                    Rp <?= number_format($totalPenjualan) ?>
                                </td>

                                <td class="border p-2"></td>

                            </tr>

                        </tfoot>

                    </table>

                    <!-- SUMMARY -->
                    <div class="grid grid-cols-2 gap-4 mt-6">

                        <div class="bg-green-100 p-2 rounded">

                            <div class="text-lg font-bold">
                                Total Transaksi
                            </div>

                            <div class="text-3xl text-green-600 font-bold">
                                <?= $totalTransaksi ?>
                            </div>

                        </div>

                        <div class="bg-pink-100 p-2 rounded">

                            <div class="text-lg font-bold">
                                Total Penjualan
                            </div>

                            <div class="text-3xl text-pink-600 font-bold">
                                Rp <?= number_format($totalPenjualan) ?>
                            </div>

                        </div>

                    </div>

                </div>





        </div>

</body>

</html>