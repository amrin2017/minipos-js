<!-- 
 // barang.php
 
// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id
// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
  
barang.php      → Tampilan
barang_api.php  → Backend AJAX
koneksi.php     → Koneksi Database

-->

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
                    <a href="grafik_barang_terlaris_pie.php">

                        📊 Grafik Barang Terlaris

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
        <div class="flex-1 p-2">

            <div class="max-w-6xl mx-auto bg-white p-2 rounded shadow">

                <h2 class="text-2xl font-bold mb-4">
                    📦 Master Barang
                </h2>

                <div class="grid grid-cols-4 gap-2 mb-4">

                    <input type="hidden" id="id">

                    <input type="text" id="nama_barang" placeholder="Nama Barang" class="border p-2">

                    <input type="number" id="stock" placeholder="Stock" class="border p-2">

                    <input type="number" id="harga" placeholder="Harga" class="border p-2">

                </div>

                <div class="mb-4">

                    <button onclick="simpan()" class="bg-blue-500 text-white px-2 py-2 rounded">

                        Simpan

                    </button>

                    <button onclick="resetForm()" class="bg-gray-500 text-white px-2 py-2 rounded">

                        Reset

                    </button>

                </div>

                <input id="search" placeholder="Cari Barang..." class="border p-2 w-full mb-4" onkeyup="loadData()">

                <table class="w-full border">

                    <thead class="bg-gray-200">

                        <tr>

                            <th class="border p-2">No</th>
                            <th class="border p-2">Nama Barang</th>
                            <th class="border p-2">Stock</th>
                            <th class="border p-2">Harga</th>
                            <th class="border p-2">Aksi</th>

                        </tr>

                    </thead>

                    <tbody id="data"></tbody>

                </table>

            </div>



        </div>

    </div>

    <script>
    function rupiah(nilai) {
        return new Intl.NumberFormat('id-ID').format(nilai);
    }

    function loadData() {

        let search =  document.getElementById("search").value;

        fetch(
                "barang_api.php?action=read&search=" + search
            )

            .then(r => r.json())

            .then(data => {

                let html = "";
                let no = 1;

                data.forEach(row => {

                    html += `
<tr>

    <td class="border p-2">${no++}</td>

    <td class="border p-2">
    ${row.nama_barang}
    </td>

    <td class="border p-2 text-center">
    ${row.stock}
    </td>

    <td class="border p-2 text-right">
    Rp ${rupiah(row.harga)}
    </td>

    <td class="border p-2">

    <button
    onclick="edit(
    ${row.id},
    '${row.nama_barang}',
    ${row.stock},
    ${row.harga}
    )"
class="bg-yellow-500 text-white px-2">

Edit

</button>

<button
onclick="hapus(${row.id})"
class="bg-red-500 text-white px-2">

Hapus

</button>

</td>

</tr>
`;

                });

                document.getElementById("data").innerHTML = html;

            });

    }

    function simpan() {

        let fd = new FormData();

        fd.append(
            "id",
            document.getElementById("id").value
        );

        fd.append(
            "nama_barang",
            document.getElementById("nama_barang").value
        );

        fd.append(
            "stock",
            document.getElementById("stock").value
        );

        fd.append(
            "harga",
            document.getElementById("harga").value
        );

        let url =
            "barang_api.php?action=create";

        if (document.getElementById("id").value) {

            url =
                "barang_api.php?action=update";

        }

        fetch(url, {
                method: "POST",
                body: fd
            })

            .then(r => r.json())

            .then(res => {

                alert(res.message);

                loadData();

                resetForm();

            });

    }

    function edit(
        id,
        nama,
        stock,
        harga
    ) {

        document.getElementById("id").value = id;
        document.getElementById("nama_barang").value = nama;
        document.getElementById("stock").value = stock;
        document.getElementById("harga").value = harga;

    }

    function hapus(id) {

        if (!confirm("Yakin Hapus data ?"))
            return;

        let fd = new FormData();

        fd.append("id", id);

        fetch(
                "barang_api.php?action=delete", {
                    method: "POST",
                    body: fd
                }
            )

            .then(r => r.json())

            .then(res => {

                alert(res.message);

                loadData();

            });

    }

    function resetForm() {

        document.getElementById("id").value = "";
        document.getElementById("nama_barang").value = "";
        document.getElementById("stock").value = "";
        document.getElementById("harga").value = "";

    }

    loadData();
    </script>

</body>

</html>