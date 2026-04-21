<?php 
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost","root","","db_absensi_tk");

date_default_timezone_set("Asia/Jakarta");
$today = date("Y-m-d");

// status hadir
$hadir = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as jml FROM absensi 
WHERE status='Hadir' AND tanggal='$today'
"))['jml'];

// status izin
$izin = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as jml FROM absensi 
WHERE status='Izin' AND tanggal='$today'
"))['jml'];

// status sakit
$sakit = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as jml FROM absensi 
WHERE status='Sakit' AND tanggal='$today'
"))['jml'];

// status belum absen
$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as jml FROM siswa"))['jml'];

$sudah = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(DISTINCT id_siswa) as jml FROM absensi 
WHERE tanggal='$today'
"))['jml'];

$belum = $total - $sudah;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <style>
    .stats{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:10px;
    }
    </style>
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
            <span>Hadir</span>
            <h3><?php echo $hadir; ?></h3>
        </div>

        <div class="card">
            <span>Izin</span>
            <h3><?php echo $izin; ?></h3>
        </div>

        <div class="card">
            <span>Sakit</span>
            <h3><?php echo $sakit; ?></h3>
        </div>

        <div class="card">
            <span>Belum</span>
            <h3><?php echo $belum; ?></h3>
        </div>
    </div>

    <div class="menu">
        <a href="absen.php" class="menu-item">
            <strong>Absen Siswa</strong>
            <small>Siswa Input Absen</small>
        </a>

        <a href="belum_absen.php" class="menu-item">
            <strong>Siswa Belum Absen</strong>
            <small>Lihat siswa yang belum hadir</small>
        </a>

        <a href="izin_sakit.php" class="menu-item">
            <strong>Input Izin & Sakit</strong>
            <small>Catat keterangan</small>
        </a>

        <a href="laporan.php" class="menu-item">
            <strong>Kelola Absensi</strong>
            <small>Edit Kehadiran</small>
        </a>

    </div>

</div>
</div>

</body>
</html>
