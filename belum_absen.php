<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");

if(!$conn){
    die("Koneksi gagal");
}


$today = date("Y-m-d");

$data = mysqli_query($conn,"
SELECT s.nama_siswa,
a.status
FROM siswa s
LEFT JOIN absensi a 
ON s.id_siswa = a.id_siswa 
AND a.tanggal='$today'
ORDER BY s.nama_siswa ASC
");


$hadirQ = mysqli_query($conn,"SELECT * FROM siswa WHERE status='Hadir'");
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
<title>Siswa Belum Absen</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
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
    padding:25px 20px 40px;
    color:white;
    border-bottom-left-radius:40px;
    border-bottom-right-radius:40px;
    text-align:center;
}

.header h2{
    font-size:18px;
}

.counter{
    font-size:12px;
    margin-top:8px;
}

.container{
    padding:15px;
    margin-top:-25px;
}

.card{
    background:#e7e7e7;
    padding:14px;
    border-radius:18px;
    margin-bottom:14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 4px 8px rgba(0,0,0,0.1);
}

.nama{
    font-size:14px;
    font-weight:500;
    width:70%;
}

.status-belum{
    background:#ffd6d6;
    padding:6px 14px;
    border-radius:20px;
    font-size:11px;
    color:#b00020;
}

.status-hadir{
    width:24px;
    height:24px;
    border-radius:50%;
    background:#c9d9c8;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#4a7c59;
    font-size:13px;
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

a{
    text-decoration:none;
}
</style>
</head>

<body>

<div class="phone">

    <div class="header">
        <h2>Siswa Belum Absen</h2>
        <div class="counter">
            Hadir : <?php echo $hadir; ?> / <?php echo $total; ?>
        </div>
    </div>

    <div class="container">

        <?php while($row = mysqli_fetch_assoc($data)){ 
            $status = isset($row['status']) ? $row['status'] : 'Belum';
        ?>

        <div class="card">
            <div class="nama">
                <?php echo $row['nama_siswa']; ?>
            </div>

            <?php if($status == "Hadir"){ ?>
                <div class="status-hadir">✓</div>
            <?php }else{ ?>
                <div class="status-belum">Belum Absen</div>
            <?php } ?>

        </div>

        <?php } ?>

        
        <a href="dashboard.php">
            <button class="btn-back">Kembali ke Dashboard</button>
        </a>

    </div>

</div>

</body>
</html>
