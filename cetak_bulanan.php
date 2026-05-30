<?php
include 'koneksi.php';
include 'auth.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

/* =========================
   RINGKASAN BULANAN
========================= */

$qSummary = $conn->query("
SELECT
    COUNT(*) AS total_transaksi,
    IFNULL(SUM(b.harga * p.jumlah),0) AS total_omzet
FROM penjualan p
JOIN barang b ON p.barang_id = b.id
WHERE MONTH(p.tanggal) = '$bulan'
AND YEAR(p.tanggal) = '$tahun'
");

$summary = $qSummary->fetch_assoc();

/* =========================
   DETAIL HARIAN
========================= */

$sql = "
SELECT
    DATE(p.tanggal) AS tgl,
    COUNT(*) AS transaksi,
    SUM(b.harga * p.jumlah) AS omzet
FROM penjualan p
JOIN barang b ON p.barang_id = b.id
WHERE MONTH(p.tanggal) = '$bulan'
AND YEAR(p.tanggal) = '$tahun'
GROUP BY DATE(p.tanggal)
ORDER BY DATE(p.tanggal)
";

$result = $conn->query($sql);

$namaBulan = [
    1=>'Januari',
    2=>'Februari',
    3=>'Maret',
    4=>'April',
    5=>'Mei',
    6=>'Juni',
    7=>'Juli',
    8=>'Agustus',
    9=>'September',
    10=>'Oktober',
    11=>'November',
    12=>'Desember'
];

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Bulanan</title>
    <link rel="stylesheet" href="style.css">



</head>

<body onload="window.print()">

    <!-- =========================
     HEADER
========================= -->

    <div class="header">

        <h1>UNIT BISNIS META-U</h1>

        <p>Jl. By Pass No.100 Padang</p>

        <p>Telp. (0751) 123456</p>

        <h2>LAPORAN PENJUALAN BULANAN</h2>

        <p>
            Periode :
            <?= $namaBulan[(int)$bulan] ?>
            <?= $tahun ?>
        </p>

    </div>

    <div class="garis"></div>

    <!-- =========================
     RINGKASAN
========================= -->

    <div class="info">

        <table>

            <tr>
                <td width="200"><b>Bulan</b></td>
                <td><?= $namaBulan[(int)$bulan] ?></td>
            </tr>

            <tr>
                <td><b>Tahun</b></td>
                <td><?= $tahun ?></td>
            </tr>

        </table>

    </div>

    <!-- =========================
     DETAIL LAPORAN
========================= -->

    <table>

        <thead>

            <tr>

                <th width="60">No</th>

                <th>Tanggal</th>

                <th width="180">Jumlah Transaksi</th>

                <th width="250">Omzet</th>

            </tr>

        </thead>

        <tbody>

            <?php
$no = 1;

while($row = $result->fetch_assoc()):
?>

            <tr>

                <td class="text-center">
                    <?= $no++ ?>
                </td>

                <td>
                    <?= date('d-m-Y', strtotime($row['tgl'])) ?>
                </td>

                <td class="text-center">
                    <?= number_format($row['transaksi']) ?>
                </td>

                <td class="text-right">
                    Rp <?= number_format($row['omzet']) ?>
                </td>

            </tr>

            <?php endwhile; ?>

        </tbody>

        <tfoot>

            <tr>

                <th colspan="2" class="text-right">
                    TOTAL BULANAN
                </th>

                <th class="text-center">
                    <?= number_format($summary['total_transaksi']) ?>
                </th>

                <th class="text-right">
                    Rp <?= number_format($summary['total_omzet']) ?>
                </th>

            </tr>

        </tfoot>

    </table>

    <!-- =========================
     RINGKASAN EKSEKUTIF
========================= -->

    <table class="summary">

        <tr>
            <td width="180">
                Total Transaksi
            </td>

            <td width="20">:</td>

            <td>
                <?= number_format($summary['total_transaksi']) ?>
            </td>
        </tr>

        <tr>
            <td>
                Total Omzet
            </td>

            <td>:</td>

            <td>
                Rp <?= number_format($summary['total_omzet']) ?>
            </td>
        </tr>

    </table>

    <!-- =========================
     TANDA TANGAN
========================= -->

    <div class="ttd">

        Padang,
        <?= date('d-m-Y') ?>

        <br><br><br><br><br>

        <b>
            <b><?= $_SESSION['nama'] ?></b>
        </b>

        <br>

        Pimpinan

    </div>

    <div class="footer-clear"></div>

</body>

</html>