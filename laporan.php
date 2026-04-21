<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");
date_default_timezone_set("Asia/Jakarta");


$today = date("Y-m-d");
$bulan = date("m");
$tahun = date("Y");


function hitung($conn,$status,$today){
    $q = mysqli_query($conn,"SELECT COUNT(*) as jml FROM absensi WHERE status='$status' AND tanggal='$today'");
    return mysqli_fetch_assoc($q)['jml'];
}

$hadir = hitung($conn,"Hadir",$today);
$izin  = hitung($conn,"Izin",$today);
$sakit = hitung($conn,"Sakit",$today);

$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as jml FROM siswa"))['jml'];
$sudah = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(DISTINCT id_siswa) as jml FROM absensi WHERE tanggal='$today'"))['jml'];
$belum = $total - $sudah;


$hariList = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
$label    = ['Sen','Sel','Rab','Kam','Jum'];

$dataChart = [];
foreach($hariList as $h){
    $q = mysqli_query($conn,"
        SELECT COUNT(*) as total 
        FROM absensi 
        WHERE status='Hadir'
        AND hari='$h'
        AND MONTH(tanggal)='$bulan'
        AND YEAR(tanggal)='$tahun'
    ");
    $dataChart[] = mysqli_fetch_assoc($q)['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laporan</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{background:#dcdcc8;display:flex;justify-content:center;}
.phone{width:390px;min-height:100vh;background:#f5f5f0;}

.header{
background:linear-gradient(180deg,#b7e4c7,#95d5b2);
padding:25px 20px 40px;
color:white;
border-bottom-left-radius:40px;
border-bottom-right-radius:40px;
text-align:center;
}

.container{padding:20px;margin-top:-25px;}

.card{
background:#e7e7e7;
border-radius:25px;
padding:20px;
margin-bottom:15px;
box-shadow:0 6px 12px rgba(0,0,0,0.1);
}

.stats{
display:grid;
grid-template-columns:1fr 1fr;
gap:10px;
}

.chart{
display:flex;
justify-content:space-between;
align-items:flex-end;
height:220px;
margin-top:20px;
}

.bar-wrapper{text-align:center;}

.bar{
width:45px;
border-radius:15px 15px 0 0;
display:flex;
justify-content:center;
font-size:12px;
font-weight:bold;
color:#333;
}

.hijau{background:#b7e4c7;}
.kuning{background:#ffe066;}

.label{margin-top:6px;font-size:12px;}

.btn{
width:100%;
margin-top:10px;
padding:10px;
border:none;
border-radius:25px;
color:white;
cursor:pointer;
}
</style>
</head>

<body>
<div class="phone">

<div class="header">
<h2>Laporan Absensi</h2>
<p><?php echo date("d F Y"); ?></p>
</div>

<div class="container">

<div class="stats">
<div class="card"><span>Hadir</span><h3><?php echo $hadir; ?></h3></div>
<div class="card"><span>Izin</span><h3><?php echo $izin; ?></h3></div>
<div class="card"><span>Sakit</span><h3><?php echo $sakit; ?></h3></div>
<div class="card"><span>Belum</span><h3><?php echo $belum; ?></h3></div>
</div>

<div class="card">
<div class="chart">

<?php foreach($dataChart as $i => $jml){
$height = ($jml==0)?15:$jml*5;
$warna = ($i%2==0)?"hijau":"kuning";
?>

<div class="bar-wrapper">
<a href="detail.php?hari=<?php echo $hariList[$i]; ?>">
<div class="bar <?php echo $warna; ?>" style="height:<?php echo $height; ?>px;">
<?php echo $jml; ?>
</div>
</a>
<div class="label"><?php echo $label[$i]; ?></div>
</div>

<?php } ?>

</div>
</div>

<a href="semua_data.php">
<button class="btn" style="background:#52796f;">Lihat Semua Data</button>
</a>

<button onclick="window.print()" class="btn" style="background:#52b788;">Download PDF</button>

<a href="dashboard.php">
    <button class="btn" style="background:#6c757d;">
        Kembali ke Dashboard
    </button>
</a>

</div>
</div>
</body>
</html>
