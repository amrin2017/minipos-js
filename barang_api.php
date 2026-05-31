<?php
// barang_api.php
// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id
// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
 


include 'koneksi.php';

$action = $_GET['action'] ?? '';

header(
'Content-Type: application/json'
);

/* ================= READ ================= */

if($action=='read'){

$search =
$_GET['search'] ?? '';

$sql = "
SELECT *
FROM barang
WHERE nama_barang
LIKE '%$search%'
ORDER BY id DESC
";

$result =
$conn->query($sql);

$data=[];

while(
$row =
$result->fetch_assoc()
){

$data[]=$row;

}

echo json_encode($data);
exit;
}

/* ================= CREATE ================= */

if($action=='create'){

$nama =
trim($_POST['nama_barang']);

$stock =
(int)$_POST['stock'];

$harga =
(int)$_POST['harga'];

if($nama==''){

echo json_encode([
"message"=>"Nama barang wajib diisi"
]);

exit;

}

$stmt =
$conn->prepare(
"INSERT INTO barang
(nama_barang,stock,harga)
VALUES (?,?,?)"
);

$stmt->bind_param(
"sii",
$nama,
$stock,
$harga
);

$stmt->execute();

echo json_encode([
"message"=>"Data berhasil disimpan"
]);

exit;
}

/* ================= UPDATE ================= */

if($action=='update'){

$id =
(int)$_POST['id'];

$nama =
trim($_POST['nama_barang']);

$stock =
(int)$_POST['stock'];

$harga =
(int)$_POST['harga'];

$stmt =
$conn->prepare(
"UPDATE barang
SET
nama_barang=?,
stock=?,
harga=?
WHERE id=?"
);

$stmt->bind_param(
"siii",
$nama,
$stock,
$harga,
$id
);

$stmt->execute();

echo json_encode([
"message"=>"Data berhasil diupdate"
]);

exit;
}

/* ================= DELETE ================= */

if($action=='delete'){

$id =
(int)$_POST['id'];

$stmt =
$conn->prepare(
"DELETE FROM barang
WHERE id=?"
);

$stmt->bind_param(
"i",
$id
);

$stmt->execute();

echo json_encode([
"message"=>"Data berhasil dihapus"
]);

exit;
}