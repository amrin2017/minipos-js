<?php
include 'koneksi.php';
include 'auth.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

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

$filename = "Laporan_Penjualan_".$bulan."_".$tahun.".xls";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$sql = "
SELECT
    DATE(p.tanggal) AS tgl,
    COUNT(*) AS transaksi,
    SUM(b.harga * p.jumlah) AS omzet
FROM penjualan p
JOIN barang b ON p.barang_id=b.id
WHERE MONTH(p.tanggal)='$bulan'
AND YEAR(p.tanggal)='$tahun'
GROUP BY DATE(p.tanggal)
ORDER BY DATE(p.tanggal)
";

$result = $conn->query($sql);

$totalTransaksi = 0;
$totalOmzet = 0;
?>

<table border="1">

    <tr>
        <th colspan="4">
            LAPORAN PENJUALAN BULANAN
        </th>
    </tr>

    <tr>
        <th colspan="4">
            Bulan <?= $namaBulan[(int)$bulan] ?>
            <?= $tahun ?>
        </th>
    </tr>

    <tr>
        <td colspan="4"></td>
    </tr>

    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Jumlah Transaksi</th>
        <th>Omzet</th>
    </tr>

    <?php
$no = 1;

while($row = $result->fetch_assoc()):

    $totalTransaksi += $row['transaksi'];
    $totalOmzet += $row['omzet'];
?>

    <tr>

        <td><?= $no++ ?></td>

        <td>
            <?= date('d-m-Y', strtotime($row['tgl'])) ?>
        </td>

        <td>
            <?= $row['transaksi'] ?>
        </td>

        <td>
            <?= $row['omzet'] ?>
        </td>

    </tr>

    <?php endwhile; ?>

    <tr>

        <th colspan="2">
            TOTAL
        </th>

        <th>
            <?= $totalTransaksi ?>
        </th>

        <th>
            <?= $totalOmzet ?>
        </th>

    </tr>

</table>