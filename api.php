<?php
include 'koneksi.php';

$action = $_GET['action'] ?? '';

/* ===== HELPER ===== */
function json($data){
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function fail($msg){
    json(["status"=>false,"error"=>$msg]);
}

/* ================= LIST BARANG ================= */
if ($action === 'barang') {

    $res = $conn->query("SELECT id,nama_barang,harga FROM barang");

    $data = [];
    while($r = $res->fetch_assoc()) $data[] = $r;

    json($data);
}

/* ================= READ ================= */
if ($action === 'read') {

    $page  = max(1, (int)($_GET['page'] ?? 1));
    $limit = 10;
    $start = ($page - 1) * $limit;

    $search = $_GET['search'] ?? '';
    $where = $search ? "WHERE b.nama_barang LIKE '%$search%'" : "";

    $sql = "SELECT 
                p.id, p.barang_id, p.jumlah, p.usia_pembeli,
                p.metode_bayar, p.tanggal,
                b.nama_barang, b.harga,
                (b.harga * p.jumlah) total
            FROM penjualan p
            JOIN barang b ON p.barang_id=b.id
            $where
            ORDER BY p.id DESC
            LIMIT $start,$limit";

    $res = $conn->query($sql);

    if(!$res) fail($conn->error);

    $data = [];
    while($r = $res->fetch_assoc()) $data[] = $r;

    $total = $conn->query("
        SELECT COUNT(*) t
        FROM penjualan p
        JOIN barang b ON p.barang_id=b.id
        $where
    ")->fetch_assoc()['t'];

    json([
        "data"=>$data,
        "total"=>$total,
        "page"=>$page,
        "limit"=>$limit
    ]);
}

/* ================= CREATE ================= */
if ($action === 'create') {

    $barang_id = (int)$_POST['barang_id'];
    $jumlah    = (int)$_POST['jumlah'];
    $usia      = (int)$_POST['usia'];
    $bayar     = $_POST['bayar'];
    $nama_user = $_SESSION['nama'] ;

    // cek stok
    $q = $conn->query("SELECT stock FROM barang WHERE id=$barang_id");
    $stok = $q->fetch_assoc()['stock'];

    if ($stok < $jumlah) fail("Stok tidak cukup");
 // kurangi stok
    $conn->query("UPDATE barang SET stock = stock - $jumlah WHERE id=$barang_id");

    // insert
    $conn->query("INSERT INTO penjualan(barang_id,jumlah,usia_pembeli,metode_bayar,nama_user)
                  VALUES($barang_id,$jumlah,$usia,'$bayar', '$nama_user')");

   
    json(["status"=>true]);
}

/* ================= UPDATE ================= */
if ($action === 'update') {

    $id        = (int)$_POST['id'];
    $barang_id = (int)$_POST['barang_id'];
    $jumlahBaru= (int)$_POST['jumlah'];
    $usia      = (int)$_POST['usia'];
    $bayar     = $_POST['bayar'];

    $q = $conn->query("SELECT barang_id,jumlah FROM penjualan WHERE id=$id");
    $old = $q->fetch_assoc();

    // kembalikan stok lama
    $conn->query("UPDATE barang SET stock = stock + {$old['jumlah']} WHERE id={$old['barang_id']}");

    // cek stok baru
    $q2 = $conn->query("SELECT stock FROM barang WHERE id=$barang_id");
    $stok = $q2->fetch_assoc()['stock'];

    if ($stok < $jumlahBaru) fail("Stok tidak cukup");

    // update
    $conn->query("UPDATE penjualan SET
        barang_id=$barang_id,
        jumlah=$jumlahBaru,
        usia_pembeli=$usia,
        metode_bayar='$bayar'
        WHERE id=$id");

    // kurangi stok
    $conn->query("UPDATE barang SET stock = stock - $jumlahBaru WHERE id=$barang_id");

    json(["status"=>true]);
}


/* =======================
   DASHBOARD
======================= */
if ($action === 'dashboard') {

    // total transaksi
    $totalData = $conn->query("SELECT COUNT(*) t FROM penjualan")
                      ->fetch_assoc()['t'];

    // total penjualan (uang)
    $totalPenjualan = $conn->query("
        SELECT IFNULL(SUM(b.harga * p.jumlah),0) t
        FROM penjualan p
        JOIN barang b ON p.barang_id=b.id
    ")->fetch_assoc()['t'];

    json([
        "totalData"=>$totalData,
        "totalPenjualan"=>$totalPenjualan
    ]);
}
/* =======================
   CETAK STRUK
======================= */
if ($action === 'struk') {

    header('Content-Type: text/html');

    $id = (int)$_GET['id'];

    $sql = "SELECT 
                p.id, p.jumlah, p.metode_bayar, p.tanggal,
                b.nama_barang, b.harga,
                (b.harga*p.jumlah) total, p.nama_user
            FROM penjualan p
            JOIN barang b ON p.barang_id=b.id
            WHERE p.id=$id";

    $res = $conn->query($sql);
    $d = $res->fetch_assoc();

    echo "
<!DOCTYPE html>
<html>
<head>
<title>Struk</title>
<style>
body {
    font-family: monospace;
    width: 280px;
    margin: auto;
}
.center { text-align: center; }
.right { text-align: right; }
hr { border-top: 1px dashed black; }

.big { font-size: 16px; font-weight: bold; }
.small { font-size: 12px; }
</style>
</head>

<body onload='window.print()'>

<div class='center'>
    <div class='big'>💰UNIT BISNIS META</div>
    <div class='big'>STRUK </div>
    <div class='small'>Jl. Sudirman No.123, Padang</div>
</div>

<hr>

<div class='small'>
Tanggal: ".date('d-m-Y H:i', strtotime($d['tanggal']))."<br>
No Struk: {$d['id']}
</div>

<hr>

<table width='100%' class='small'>
<tr>
    <td>{$d['nama_barang']}</td>
</tr>
<tr>
    <td>{$d['jumlah']} x Rp ".number_format($d['harga'])."</td>
    <td class='right'>Rp ".number_format($d['total'])."</td>
</tr>
</table>

<hr>

<table width='100%' class='small'>
<tr>
    <td><b>Total</b></td>
    <td class='right'><b>Rp ".number_format($d['total'])."</b></td>
</tr>
<tr>
    <td>Bayar</td>
    <td class='right'>{$d['metode_bayar']}</td>
</tr>
</table>

<hr>

<div class='center small'>
    Petugas: {$d['nama_user']} <br>
    Terima kasih 🙏<br>
    Barang tidak dapat dikembalikan
</div>

</body>
</html>
";
    exit;
}

/* ================= DELETE ================= */
if ($action === 'delete') {

    $id = (int)$_POST['id'];

    $q = $conn->query("SELECT barang_id,jumlah FROM penjualan WHERE id=$id");
    $d = $q->fetch_assoc();

    // kembalikan stok
    $conn->query("UPDATE barang SET stock = stock + {$d['jumlah']} WHERE id={$d['barang_id']}");

    $conn->query("DELETE FROM penjualan WHERE id=$id");

    json(["status"=>true]);
}

/* ================= DEFAULT ================= */
json(["status"=>false,"error"=>"Invalid action"]);