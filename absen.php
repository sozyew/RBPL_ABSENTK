<?php
session_start();
if(!isset($_SESSION['login'])){
    header("Location: login.php");
    exit;
}

$conn = mysqli_connect("localhost","root","","db_absensi_tk");

date_default_timezone_set("Asia/Jakarta");

$today = date("Y-m-d");
$hari = date("l");


if(isset($_GET['id'])){
    $id = $_GET['id'];

    $cek = mysqli_query($conn,"SELECT * FROM absensi 
        WHERE id_siswa='$id' AND tanggal='$today'");

    if(mysqli_num_rows($cek) > 0){
        mysqli_query($conn,"UPDATE absensi 
            SET status='Hadir', keterangan=''
            WHERE id_siswa='$id' AND tanggal='$today'");
    } else {
        mysqli_query($conn,"INSERT INTO absensi 
        (id_siswa,tanggal,hari,status,keterangan)
        VALUES ('$id','$today','$hari','Hadir','')");
    }

    header("Location: absen.php");
    exit;
}


$data = mysqli_query($conn,"
SELECT s.id_siswa, s.nama_siswa, a.status
FROM siswa s
LEFT JOIN absensi a 
ON s.id_siswa = a.id_siswa 
AND a.tanggal='$today'
ORDER BY s.nama_siswa ASC
");


$hadir = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as jml FROM absensi 
WHERE status='Hadir' AND tanggal='$today'
"))['jml'];

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) as jml FROM siswa
"))['jml'];
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Absen Siswa</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:sans-serif;
}

body{
    background:#dcdcc8;
    display:flex;
    justify-content:center;
}

.phone{
    width:390px;
    min-height:100vh;
    background:#f5f5f0;
}


.header{
    background:#7fa483;
    padding:25px;
    text-align:center;
    color:white;
    border-bottom-left-radius:40px;
    border-bottom-right-radius:40px;
}

.container{
    padding:15px;
    margin-top:-20px;
}


.card{
    background:#e7e7e7;
    padding:14px;
    border-radius:18px;
    margin-bottom:12px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 8px rgba(0,0,0,0.1);
}


.btn-hadir{
    background:#52b788;
    color:white;
    border:none;
    padding:6px 14px;
    border-radius:15px;
    font-size:12px;
    cursor:pointer;
}


.status-hadir{
    background:#c9d9c8;
    padding:6px 12px;
    border-radius:15px;
    font-size:12px;
}

.status-izin{
    color:orange;
    font-weight:bold;
}

.status-sakit{
    color:red;
    font-weight:bold;
}

.btn-back{
    width:100%;
    margin-top:15px;
    padding:10px;
    border:none;
    border-radius:25px;
    background:#52796f;
    color:white;
    font-size:14px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="phone">

<div class="header">
    <h2>Absen Siswa</h2>
    <p><?php echo $hadir; ?> / <?php echo $total; ?> hadir</p>
</div>

<div class="container">

<?php while($row = mysqli_fetch_assoc($data)){ ?>

<div class="card">

<span><?php echo $row['nama_siswa']; ?></span>

<div>

<?php if(!$row['status']){ ?>

<form method="GET" action="absen.php" style="margin:0;">
    <input type="hidden" name="id" value="<?php echo $row['id_siswa']; ?>">
    <button type="submit" class="btn-hadir">Hadir</button>
</form>

<?php } elseif($row['status'] == "Hadir"){ ?>

<span class="status-hadir">✓ Hadir</span>

<?php } elseif($row['status'] == "Izin"){ ?>

<span class="status-izin">Izin</span>

<?php } elseif($row['status'] == "Sakit"){ ?>

<span class="status-sakit">Sakit</span>

<?php } ?>

</div>

</div>

<?php } ?>

<a href="dashboard.php">
    <button class="btn-back">Kembali ke Dashboard</button>
</a>

</div>

</div>

</body>
</html>
