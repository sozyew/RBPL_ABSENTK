<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");

if(!$conn){
    die("Koneksi gagal");
}


if(isset($_GET['hadir'])){
    $id = intval($_GET['hadir']);
    mysqli_query($conn,"UPDATE siswa SET status='Hadir' WHERE id_siswa=$id");
    header("Location: absen.php");
    exit;
}


$data = mysqli_query($conn,"SELECT * FROM siswa ORDER BY nama_siswa ASC");

$hadirQ = mysqli_query($conn,"SELECT * FROM siswa WHERE status='Hadir'");
$hadir = $hadirQ ? mysqli_num_rows($hadirQ) : 0;

$totalQ = mysqli_query($conn,"SELECT * FROM siswa");
$total = $totalQ ? mysqli_num_rows($totalQ) : 0;
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


.btn-hadir{
    background:linear-gradient(to right,#b7e4c7,#52b788);
    border:none;
    padding:6px 18px;
    border-radius:20px;
    font-size:11px;
    cursor:pointer;
}


.check{
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

a{
    text-decoration:none;
}
</style>
</head>
<body>

<div class="phone">

    <div class="header">
        <h2>Absen Siswa</h2>
        <div class="counter">
            Sudah Absen : <?php echo $hadir; ?> / <?php echo $total; ?>
        </div>
    </div>

    <div class="container">

        <?php while($row = mysqli_fetch_assoc($data)){ 
            $status = $row['status'] ?? 'Belum';
        ?>

        <div class="card">
            <div class="nama">
                <?php echo $row['nama_siswa']; ?>
            </div>

            <?php if($status == "Hadir"){ ?>
                <div class="check">✓</div>
            <?php }else{ ?>
                <a href="?hadir=<?php echo $row['id_siswa']; ?>">
                    <button class="btn-hadir">Hadir</button>
                </a>
            <?php } ?>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>