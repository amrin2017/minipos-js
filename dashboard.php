<?php
include 'koneksi.php';
include 'auth.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Dashboard Mini-POS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex">

        <!-- SIDEBAR -->
        <div class="w-64 bg-blue-700 min-h-screen text-white">

            <div class="p-4 text-2xl font-bold border-b">
                💰 Mini POS <br> Unit Bisnis Meta-U
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

            <div class="bg-white p-4 rounded shadow mb-4">

                <h1 class="text-2xl font-bold">
                    Dashboard
                </h1>

                <p class="text-gray-600">
                    Selamat datang,
                    <b><?= $_SESSION['nama'] ?></b>
                </p>

            </div>

            <?php
        $totalBarang = $conn->query("SELECT COUNT(*) t FROM barang")
                            ->fetch_assoc()['t'];

        $totalTransaksi = $conn->query("SELECT COUNT(*) t FROM penjualan")
                               ->fetch_assoc()['t'];

        $totalPenjualan = $conn->query("
            SELECT IFNULL(SUM(b.harga * p.jumlah),0) t
            FROM penjualan p
            JOIN barang b ON p.barang_id=b.id
        ")->fetch_assoc()['t'];
        ?>

            <div class="grid grid-cols-3 gap-4">

                <div class="bg-blue-500 text-white p-6 rounded shadow">
                    <div class="text-lg">
                        Total Barang
                    </div>

                    <div class="text-3xl font-bold">
                        <?= $totalBarang ?>
                    </div>
                </div>

                <div class="bg-green-500 text-white p-6 rounded shadow">
                    <div class="text-lg">
                        Total Transaksi
                    </div>

                    <div class="text-3xl font-bold">
                        <?= $totalTransaksi ?>
                    </div>
                </div>

                <div class="bg-pink-500 text-white p-6 rounded shadow">
                    <div class="text-lg">
                        Total Penjualan
                    </div>

                    <div class="text-3xl font-bold">
                        Rp <?= number_format($totalPenjualan) ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>

</html>