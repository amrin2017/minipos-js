<?php
include 'koneksi.php';

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$sql = "
SELECT
    b.id,
    b.nama_barang,
    b.harga,

    SUM(p.jumlah) total_terjual,

    SUM(
        p.jumlah * b.harga
    ) total_omzet

FROM penjualan p

JOIN barang b
ON p.barang_id=b.id

WHERE MONTH(p.tanggal)='$bulan'
AND YEAR(p.tanggal)='$tahun'

GROUP BY b.id

ORDER BY total_terjual DESC
";

$res = $conn->query($sql);

$dataTerlaris=[];

while($row=$res->fetch_assoc()){
    $dataTerlaris[]=$row;
}

header('Content-Type: application/json');

echo json_encode($dataTerlaris);
?>