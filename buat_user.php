<?php
include 'koneksi.php';

$nama     = "Administrator";
$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$level    = "admin";

$sql = "INSERT INTO users(nama,username,password,level_user)
        VALUES('$nama','$username','$password','$level')";
        

if($conn->query($sql)){
    echo "User berhasil dibuat";
}else{
    echo $conn->error;
}
?>