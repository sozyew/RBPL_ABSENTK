<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>