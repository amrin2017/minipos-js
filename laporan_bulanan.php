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
                    <a href="barang.php" class="block p-2 rounded hover:bg-blue-500">
                        Barang 📦
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


            <?php
// include 'koneksi.php';
// include 'auth.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$sql = "SELECT
            DATE(p.tanggal) as tgl,
            COUNT(*) as transaksi,
            SUM(b.harga * p.jumlah) as omzet
        FROM penjualan p
        JOIN barang b ON p.barang_id = b.id
        WHERE MONTH(p.tanggal) = '$bulan'
        AND YEAR(p.tanggal) = '$tahun'
        GROUP BY DATE(p.tanggal)
        ORDER BY DATE(p.tanggal)";

$res = $conn->query($sql);

$totalTransaksi = 0;
$totalOmzet = 0;
?>

            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <title>Laporan Bulanan</title>
                <script src="https://cdn.tailwindcss.com"></script>
            </head>

            <body class="bg-gray-100 p-6">

                <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

                    <div class="flex justify-between mb-4">

                        <h1 class="text-2xl font-bold">
                            📅 Laporan Bulanan
                        </h1>

                        <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">
                            Kembali
                        </a>

                    </div>

                    <!-- FILTER -->

                    <form method="GET" class="flex gap-2 mb-4">

                        <select name="bulan" class="border p-2 rounded">

                            <?php
            for($i=1;$i<=12;$i++){
                $selected = ($bulan==$i)?'selected':'';
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>

                        </select>

                        <select name="tahun" class="border p-2 rounded">

                            <?php
            for($i=date('Y')-5;$i<=date('Y')+1;$i++){

                $selected = ($tahun==$i)?'selected':'';

                echo "<option value='$i' $selected>$i</option>";
            }
            ?>

                        </select>

                        <button class="bg-blue-500 text-white px-4 rounded">
                            Tampilkan
                        </button>


                        <a href="cetak_bulanan.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" target="_blank"
                            class="bg-green-500 text-white px-4 py-2 rounded"> 🖨 Cetak Laporan
                        </a>

                        <a href="export_bulanan_excel.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>"
                            class="bg-emerald-600 text-white px-4 py-2 rounded">
                            📊 Export Excel
                        </a>

                    </form>

                    <!-- INFO -->

                    <div class="bg-blue-100 p-3 rounded mb-4">

                        Bulan :
                        <b><?= $bulan ?></b>

                        Tahun :
                        <b><?= $tahun ?></b>

                    </div>

                    <!-- TABEL -->

                    <table class="w-full border border-collapse">

                        <thead class="bg-gray-200">

                            <tr>
                                <th class="border p-2">No</th>
                                <th class="border p-2">Tanggal</th>
                                <th class="border p-2">Jumlah Transaksi</th>
                                <th class="border p-2">Omzet</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php
        $no=1;

        while($d=$res->fetch_assoc()):

            $totalTransaksi += $d['transaksi'];
            $totalOmzet += $d['omzet'];
        ?>

                            <tr>

                                <td class="border p-2 text-center">
                                    <?= $no++ ?>
                                </td>

                                <td class="border p-2">
                                    <?= date('d-m-Y',strtotime($d['tgl'])) ?>
                                </td>

                                <td class="border p-2 text-center">
                                    <?= $d['transaksi'] ?>
                                </td>

                                <td class="border p-2 text-right">
                                    Rp <?= number_format($d['omzet']) ?>
                                </td>

                            </tr>

                            <?php endwhile; ?>

                        </tbody>

                        <tfoot class="bg-gray-100 font-bold">

                            <tr>

                                <td colspan="2" class="border p-2 text-right">
                                    TOTAL
                                </td>

                                <td class="border p-2 text-center">
                                    <?= $totalTransaksi ?>
                                </td>

                                <td class="border p-2 text-right text-red-600">
                                    Rp <?= number_format($totalOmzet) ?>
                                </td>

                            </tr>

                        </tfoot>

                    </table>

                    <!-- SUMMARY

                    <div class="grid grid-cols-2 gap-4 mt-6">

                        <div class="bg-green-100 p-4 rounded">

                            <div class="font-bold">
                                Total Transaksi
                            </div>

                            <div class="text-3xl font-bold text-green-600">
                                <?= $totalTransaksi ?>
                            </div>

                        </div>

                        <div class="bg-pink-100 p-4 rounded">

                            <div class="font-bold">
                                Total Omzet
                            </div>

                            <div class="text-3xl font-bold text-pink-600">
                                Rp <?= number_format($totalOmzet) ?>
                            </div>

                        </div>

                    </div> -->

                </div>





        </div>

    </div>

</body>

</html>