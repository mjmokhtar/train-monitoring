<?php
$host = "192.168.0.160"; // Ganti dengan host database Anda jika berbeda
$username = "restek"; // Ganti dengan username database Anda
$password = "mysql2025"; // Ganti dengan password database Anda jika ada
$dbname = "train_tracking"; // Ganti dengan nama database Anda

$db = mysqli_connect($host, $username, $password, $dbname);

if(!$db){
    die("ERROR: Gagal Terhubung: " . mysqli_connect_error());
}

?>
