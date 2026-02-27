<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="phone">
<div class="screen dashboard-bg">

    <div class="header">
        <h2>Halo, TK BA BLIGO 2!</h2>
        <p>Siap melaksanakan kegiatan hari ini?</p>
    </div>

    <div class="stats">
        <div class="card">
            <span>Sudah Hadir</span>
            <h3>3</h3>
        </div>

        <div class="card">
            <span>Belum Hadir</span>
            <h3>9</h3>
        </div>
    </div>

    <div class="menu">
        <a href="absen.php" class="menu-item">
            <strong>Absen Siswa</strong>
            <small>Siswa Input Absen Mandiri</small>
        </a>

        <div class="menu-item">
            <strong>Siswa Belum Absen</strong>
            <small>Lihat daftar siswa yang belum hadir</small>
        </div>

        <div class="menu-item">
            <strong>Input Keterangan Izin & Sakit</strong>
            <small>Catat keterangan izin & sakit</small>
        </div>

        <div class="menu-item">
            <strong>Kelola Absensi</strong>
            <small>Edit & input kehadiran siswa</small>
        </div>
    </div>

</div>
</div>

</body>
</html>