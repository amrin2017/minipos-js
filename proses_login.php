<?php
// proses_login.php

// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id

// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
 

include 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

// var_dump($_POST);
// die; 

$sql = "SELECT * FROM users WHERE username='$username'";

$res = $conn->query($sql);

if ($res->num_rows > 0) {

    $user = $res->fetch_assoc();

    // cek password hash
    if (password_verify($password, $user['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['level'] = $user['level_user'];

        header("Location: dashboard.php");
        exit;
    }
}

header("Location: login.php?error=1");
?>