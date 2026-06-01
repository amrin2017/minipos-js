<?php
include 'koneksi.php';
include 'auth.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$sql = "
SELECT
    b.nama_barang,
    SUM(p.jumlah) total_terjual
FROM penjualan p
JOIN barang b
    ON p.barang_id = b.id
WHERE MONTH(p.tanggal)='$bulan'
AND YEAR(p.tanggal)='$tahun'
GROUP BY p.barang_id
ORDER BY total_terjual DESC
LIMIT 5
";

$result = $conn->query($sql);

$labels = [];
$data = [];

while($row = $result->fetch_assoc()){

    $labels[] = $row['nama_barang'];
    $data[]   = $row['total_terjual'];
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Mini-POS | Grafik </title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    <a href="grafik_barang_terlaris_pie.php">

                        🏆 Grafik Barang Terlaris

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

            <div class="max-w-6xl mx-auto">

                <div class="bg-white p-6 rounded-xl shadow">

                    <h2 class="text-3xl font-bold mb-5">

                        🏆 Top 5 Barang Terlaris

                    </h2>

                    <form method="GET" class="flex gap-3 mb-5">

                        <select name="bulan" class="border p-2 rounded">

                            <?php
        for($i=1;$i<=12;$i++){
        ?>

                            <option value="<?= $i ?>" <?= $bulan==$i?'selected':'' ?>>

                                Bulan <?= $i ?>

                            </option>

                            <?php } ?>

                        </select>

                        <input type="number" name="tahun" value="<?= $tahun ?>" class="border p-2 rounded">

                        <button class="bg-blue-600 text-white px-4 rounded">

                            Tampilkan

                        </button>

                    </form>

                    <div class="grid md:grid-cols-2 gap-6">

                        <div>

                            <canvas id="pieChart"></canvas>

                        </div>

                        <div>

                            <table class="w-full border">

                                <thead class="bg-gray-200">

                                    <tr>

                                        <th class="border p-2">No</th>

                                        <th class="border p-2">
                                            Barang
                                        </th>

                                        <th class="border p-2">
                                            Terjual
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php

            $no=1;

            foreach($labels as $k=>$barang){

            ?>

                                    <tr>

                                        <td class="border p-2 text-center">

                                            <?= $no++ ?>

                                        </td>

                                        <td class="border p-2">

                                            <?= $barang ?>

                                        </td>

                                        <td class="border p-2 text-center">

                                            <?= $data[$k] ?>

                                        </td>

                                    </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>



        </div>

    </div>
    <script>
    const ctx =
        document.getElementById('pieChart');

    new Chart(ctx, {

        type: 'pie',

        data: {

            labels: <?= json_encode($labels) ?>,

            datasets: [{

                data: <?= json_encode($data) ?>,

                backgroundColor: [

                    '#3B82F6',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444',
                    '#8B5CF6'

                ],

                borderWidth: 1

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    position: 'bottom'

                },

                title: {

                    display: true,

                    text: 'Distribusi Penjualan Barang Terlaris'

                }

            }

        }

    });
    </script>

</body>

</html>