<?php
// koneksi.php

// Universitas Metamedia, Padang
// Fakultas Teknologi Informasi dan Industri Kreatif
// Program Studi : Sistem Informasi
// Matakuliah Pemrogaraman Web
// Dosen: Ir. Muhammad Amrin Lubis, M.Sc, email: mamrinlubis@metamedia.ac.id

// Pendaftaran mahasiswa baru: https://pmb.metamedia.ac.id/beranda_pmb
 

session_start();

$conn = new mysqli(
    "localhost",
    "Admindb",
    "cDJ_Di8CfiETT@rY",
    "db_penjualan"
);

if ($conn->connect_error) {
    die("DB Error");
}
?>