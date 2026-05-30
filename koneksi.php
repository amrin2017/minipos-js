<?php
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