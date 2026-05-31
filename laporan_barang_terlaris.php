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
                    <a href="logout.php" class="block p-2 rounded bg-red-500 hover:bg-red-600">
                        Logout
                    </a>
                </li>

            </ul>

        </div>

        <!-- CONTENT -->
        <div class="flex-1 p-6">

            <!-- content -->
            <!-- <div class="p-2"> -->

            <div class="bg-white p-2 rounded shadow">

                <div class="flex justify-between">

                    <h2 class="text-2xl font-bold">

                        🏆 Laporan Barang Terlaris

                    </h2>

                    <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded">

                        Kembali

                    </a>

                </div>

                <hr class="my-4">

                <div class="flex gap-2 mb-4">

                    <select id="bulan" class="border p-2 rounded">

                        <?php
                        for($i=1;$i<=12;$i++){
                            echo "<option value='$i'>$i</option>";
                        }
                        ?>

                    </select>

                    <select id="tahun" class="border p-2 rounded">

                        <?php
                        for($i=date('Y')-5;$i<=date('Y')+1;$i++){
                            echo "<option>$i</option>";
                        }
                        ?>

                    </select>

                    <button onclick="loadData()" class="bg-blue-500 text-white px-4 rounded">

                        Tampilkan

                    </button>

                </div>

                <!-- Dashboard -->

                <div class="grid grid-cols-3 gap-4 mb-4">

                    <div class="bg-blue-100 p-2 rounded">

                        <div>Total Barang</div>

                        <div id="totalBarang" class="text-3xl font-bold text-blue-600">

                            0

                        </div>

                    </div>

                    <div class="bg-green-100 p-2 rounded">

                        <div>Total Terjual</div>

                        <div id="totalTerjual" class="text-3xl font-bold text-green-600">

                            0

                        </div>

                    </div>

                    <div class="bg-pink-100 p-2 rounded">

                        <div>Total Omzet</div>

                        <div id="totalOmzet" class="text-2xl font-bold text-pink-600">

                            Rp 0

                        </div>

                    </div>

                </div>

                <!-- Table -->

                <table class="w-full border">

                    <thead class="bg-gray-200">

                        <tr>

                            <th>No</th>
                            <th>Barang</th>
                            <th>Harga</th>
                            <th>Qty Terjual</th>
                            <th>Omzet</th>

                        </tr>

                    </thead>

                    <tbody id="dataTerlaris"></tbody>

                </table>

            </div>

            <!-- </div> -->


        </div>

    </div>
    <script>
    function rupiah(x) {

        return new Intl.NumberFormat(
            'id-ID'
        ).format(x);

    }

    function loadData() {

        let bulan =
            document.getElementById(
                'bulan'
            ).value;

        let tahun =
            document.getElementById(
                'tahun'
            ).value;

        fetch(
                `ajax_barang_terlaris.php?bulan=${bulan}&tahun=${tahun}`
            )

            .then(r => r.json())

            .then(dataTerlaris => {

                let html = '';

                let no = 1;

                let totalQty = 0;

                let totalOmzet = 0;

                dataTerlaris.forEach(row => {

                    totalQty +=
                        parseInt(
                            row.total_terjual
                        );

                    totalOmzet +=
                        parseInt(
                            row.total_omzet
                        );

                    html += `

            <tr>

            <td class='border p-2 text-center'>

            ${no++}

            </td>

            <td class='border p-2'>

            ${row.nama_barang}

            </td>

            <td class='border p-2 text-right'>

            Rp ${rupiah(row.harga)}

            </td>

            <td class='border p-2 text-center'>

            ${rupiah(row.total_terjual)}

            </td>

            <td class='border p-2 text-right'>

            Rp ${rupiah(row.total_omzet)}

            </td>

            </tr>

            `;

                });

                document.getElementById(
                    'dataTerlaris'
                ).innerHTML = html;

                document.getElementById(
                    'totalBarang'
                ).innerHTML = dataTerlaris.length;

                document.getElementById(
                    'totalTerjual'
                ).innerHTML = rupiah(totalQty);

                document.getElementById(
                        'totalOmzet'
                    ).innerHTML =
                    "Rp " + rupiah(totalOmzet);

            });

    }

    loadData();
    </script>
</body>

</html>