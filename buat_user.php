<?php

// buat_user.php

// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id

// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
 

include 'koneksi.php';

$nama     = "Administrator";
$username = "Meta";
$password = password_hash("metamedia", PASSWORD_DEFAULT);
$level    = "admin";

$sql = "INSERT INTO users(nama,username,password,level_user)
        VALUES('$nama','$username','$password','$level')";
        

if($conn->query($sql)){
    echo "User berhasil dibuat";
}else{
    echo $conn->error;
}
?>