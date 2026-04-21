<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");

date_default_timezone_set("Asia/Jakarta");

$data = mysqli_query($conn,"
SELECT s.nama_siswa, a.status, a.keterangan, a.tanggal
FROM absensi a
JOIN siswa s ON a.id_siswa = s.id_siswa
ORDER BY a.tanggal DESC, s.nama_siswa ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semua Data Absensi</title>

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
padding:15px;
}

h2{
text-align:center;
margin-bottom:15px;
}


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

th{
background:#52796f;
color:white;
}


.badge{
padding:3px 10px;
border-radius:10px;
color:white;
font-size:11px;
}

.hadir{background:#52b788;}
.izin{background:#f4a261;}
.sakit{background:#e63946;}

.kosong{
color:#999;
font-style:italic;
}


.btn{
width:100%;
margin-top:10px;
padding:10px;
border:none;
border-radius:25px;
background:#52b788;
color:white;
cursor:pointer;
}
</style>
</head>

<body>

<div class="phone">

<h2>Semua Data Absensi</h2>

<button onclick="window.print()" class="btn">
Download PDF
</button>

<table>
<tr>
<th>Tanggal</th>
<th>Nama</th>
<th>Status</th>
<th>Keterangan</th>
</tr>

<?php while($d = mysqli_fetch_assoc($data)){ ?>
<tr>

<td><?php echo $d['tanggal']; ?></td>

<td><?php echo $d['nama_siswa']; ?></td>

<td>
<?php
if($d['status']){
    echo "<span class='badge ".strtolower($d['status'])."'>".$d['status']."</span>";
}else{
    echo "<span class='kosong'>Belum</span>";
}
?>
</td>

<td><?php echo $d['keterangan'] ? $d['keterangan'] : '-'; ?></td>

</tr>
<?php } ?>

</table>

</div>

</body>
</html>
