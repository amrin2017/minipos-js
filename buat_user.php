<?php
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