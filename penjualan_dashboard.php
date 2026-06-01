<?php
// penjualan_dashboard.php

// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id

// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
 

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



        <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">

            <h2 class="text-xl font-bold mb-4">🛒 Mini POS Sistem Penjualan </h2>

            <!-- DASHBOARD -->
            <div class="grid grid-cols-3 gap-4 mb-4">

                <div class="bg-pink-100 text-black font-bold p-2 rounded">
                    <div>Total Transaksi</div>
                    <div id="totalData" class="text-xl font-bold text-pink-600">0</div>
                </div>

                <div class="bg-green-100 text-black font-bold p-2 rounded">
                    <div> 💵 Total Penjualan</div>
                    <div id="totalPenjualan" class="text-xl font-bold text-green-600">Rp 0</div>
                </div>
                <div class="bg-gray-100 text-black font-bold p-2 rounded">
                    <div>💰 Total Belanja </div>
                    <div id="previewTotal" class="text-2xl font-bold text-red-600">Rp 0</div>
                </div>
            </div>

            <!-- SEARCH -->
            <input id="search" placeholder="Cari barang..." class="border p-2 mb-4 w-full" oninput="loadData(1)">

            <!-- FORM -->
            <div class="flex gap-2 mb-2">
                <input type="hidden" id="id">

                <select id="barang" class="border p-2" onchange="hitungTotal()"></select>

                <input id="jumlah" type="number" placeholder="Jumlah" class="border p-2" oninput="hitungTotal()">

                <input id="usia" type="number" placeholder="Usia Pembeli" class="border p-2">

                <select id="bayar" class="border p-2">
                    <option>Cash</option>
                    <option>Transfer</option>
                    <option>E-Wallet</option>
                </select>

                <button onclick="simpan()" class="bg-blue-500 text-white px-2 rounded">
                    Simpan
                </button>
            </div>

            <!-- TOTAL BELANJA -->
            <!-- <div class="mb-4">
    <span class="font-semibold">Total Belanja: </span>
    <span id="previewTotal" class="text-blue-600 font-bold">Rp 0</span>
</div> -->

            <!-- TABLE -->
            <table class="w-full border text-sm">
                <thead class="bg-gray-200">
                    <tr>
                        <th>No</th>
                        <th>Struk</th>
                        <th>Barang</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Metoda Bayar</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data"></tbody>
            </table>

            <!-- PAGINATION -->
            <div id="paging" class="mt-4"></div>

        </div>
        <!-- end CONTENT   -->
    </div>

    <script>
    /* FORMAT RUPIAH */
    function rupiah(a) {
        return new Intl.NumberFormat("id-ID").format(a);
    }

    /* ================= LOAD DASHBOARD ================= */
    function loadDashboard() {
        fetch("api.php?action=dashboard")
            .then(r => r.json())
            .then(res => {
                document.getElementById("totalData").innerText = res.totalData;
                document.getElementById("totalPenjualan").innerText =
                    "Rp " + rupiah(res.totalPenjualan);
            })
            .catch(err => {
                console.error("Dashboard error:", err);
            });
    }

    /* ================= LOAD BARANG ================= */
    function loadBarang() {
        fetch("api.php?action=barang")
            .then(r => r.json())
            .then(data => {
                let html = `<option value="">-- Pilih Barang --</option>`;

                data.forEach(b => {
                    html += `<option value="${b.id}" data-harga="${b.harga}">
                ${b.nama_barang} (Rp ${rupiah(b.harga)})
            </option>`;
                });

                document.getElementById("barang").innerHTML = html;
            });
    }

    /* ================= HITUNG TOTAL ================= */
    function hitungTotal() {

        let select = document.getElementById("barang");
        let jumlah = parseInt(document.getElementById("jumlah").value) || 0;

        if (!select.value) {
            document.getElementById("previewTotal").innerText = "Rp 0";
            return;
        }

        let harga = parseInt(select.options[select.selectedIndex].dataset.harga) || 0;

        let total = harga * jumlah;

        document.getElementById("previewTotal").innerText =
            "Rp " + rupiah(total);
    }

    /* ================= LOAD DATA ================= */
    function loadData(page = 1) {

        let search = document.getElementById("search").value;

        fetch(`api.php?action=read&page=${page}&search=${search}`)
            .then(r => r.json())
            .then(res => {

                let html = "";
                let no = (res.page - 1) * res.limit + 1;

                res.data.forEach(d => {
                    html += `
        <tr>
        <td>${no++}</td>
        <td>${d.id}</td>
        <td>${d.nama_barang}</td>
        <td align='right'>Rp ${rupiah(d.harga)}</td>
        <td align='right'>${d.jumlah}</td>
        <td align='right'>Rp ${rupiah(d.total)}</td>
        <td align='center'>${d.metode_bayar}</td>
        <td>${d.tanggal ?? '-'}</td>
        <td>
        <button onclick="edit(${d.id},${d.barang_id},${d.jumlah},${d.usia_pembeli},'${d.metode_bayar}')">Edit</button>
        <button onclick="hapus(${d.id})" class="text-red-500">Hapus</button>
        <button onclick="struk(${d.id})" class="text-green-600">Struk</button>
        </td>
        </tr>`;
                });
                document.getElementById("data").innerHTML = html;

                // pagination
                let pages = Math.ceil(res.total / res.limit);
                let phtml = "";

                for (let i = 1; i <= pages; i++) {
                    phtml += `<button onclick="loadData(${i})"
            class="px-2 border ${i===res.page?'bg-blue-500 text-white':''}">
            ${i}
            </button>`;
                }

                document.getElementById("paging").innerHTML = phtml;

            })
            .catch(err => {
                console.error("Load data error:", err);
            });
    }

    /* ================= SIMPAN ================= */
    function simpan() {

        let fd = new FormData();

        fd.append("id", document.getElementById("id").value);
        fd.append("barang_id", document.getElementById("barang").value);
        fd.append("jumlah", document.getElementById("jumlah").value);
        fd.append("usia", document.getElementById("usia").value);
        fd.append("bayar", document.getElementById("bayar").value);

        let url = "api.php?action=create";
        if (document.getElementById("id").value) {
            url = "api.php?action=update";
        }

        fetch(url, {
                method: "POST",
                body: fd
            })
            .then(r => r.json())
            .then(res => {
                if (res.status) {
                    loadData();
                    loadDashboard();
                    resetForm();
                } else {
                    alert(res.error);
                }
            });
    }

    /* ================= DELETE ================= */
    function hapus(id) {

        if (!confirm("Hapus data?")) return;

        let fd = new FormData();
        fd.append("id", id);

        fetch("api.php?action=delete", {
                method: "POST",
                body: fd
            })
            .then(() => {
                loadData();
                loadDashboard();
            });
    }

    /* ================= EDIT ================= */
    function edit(id, barang_id, jumlah, usia, bayar) {
        document.getElementById("id").value = id;
        document.getElementById("barang").value = barang_id;
        document.getElementById("jumlah").value = jumlah;
        document.getElementById("usia").value = usia;
        document.getElementById("bayar").value = bayar;

        hitungTotal();
    }

    /* ================= RESET ================= */
    function resetForm() {
        document.getElementById("id").value = "";
        document.getElementById("jumlah").value = "";
        document.getElementById("usia").value = "";
        document.getElementById("previewTotal").innerText = "Rp 0";
    }

    /* ================= STRUK ================= */
    function struk(id) {
        window.open("api.php?action=struk&id=" + id, "_blank");
    }

    /* INIT */
    loadBarang();
    loadData();
    loadDashboard();
    </script>
</body>

</html>