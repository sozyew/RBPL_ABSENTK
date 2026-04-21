<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");

if(!isset($_GET['hari'])){
    die("Hari tidak ditemukan");
}

$hari = $_GET['hari'];

$query = mysqli_query($conn,"
SELECT s.nama_siswa, a.status, a.keterangan, a.tanggal
FROM siswa s
LEFT JOIN absensi a 
ON s.id_siswa = a.id_siswa AND a.hari='$hari'
ORDER BY a.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail</title>

<style>
body{background:#dcdcc8;display:flex;justify-content:center;font-family:sans-serif;}
.phone{width:390px;background:#f5f5f0;min-height:100vh;padding:15px;}

h2{text-align:center;margin-bottom:15px;}

table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:10px;
overflow:hidden;
}

th,td{
padding:8px;
border-bottom:1px solid #ccc;
font-size:13px;
}

th{background:#52796f;color:white;}
</style>
</head>

<body>
<div class="phone">

<h2><?php echo $hari; ?></h2>

<table>
<tr>
<th>Tanggal</th>
<th>Nama</th>
<th>Status</th>
<th>Keterangan</th>
</tr>

<?php while($d=mysqli_fetch_assoc($query)){ ?>
<tr>
<td><?php echo $d['tanggal']; ?></td>
<td><?php echo $d['nama_siswa']; ?></td>
<td><?php echo $d['status']; ?></td>
<td><?php echo $d['keterangan']; ?></td>
</tr>
<?php } ?>

</table>

</div>
</body>
</html>