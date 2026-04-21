<?php
$conn = mysqli_connect("localhost","root","","db_absensi_tk");
date_default_timezone_set("Asia/Jakarta");


$today = date("Y-m-d");
$hari  = date("l");
$tanggalFull = date("d F Y");


if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];

    mysqli_query($conn, "
        DELETE FROM absensi 
        WHERE id_siswa = '$id' 
        AND tanggal = '$today'
    ");

    header("Location: izin_sakit.php");
    exit;
}


if(isset($_POST['simpan'])){
    $id         = $_POST['id'];
    $status     = $_POST['status'];
    $keterangan = $_POST['keterangan'];

    if($status == "Hadir"){
        $keterangan = "";
    }

    $cek = mysqli_query($conn, "
        SELECT * FROM absensi 
        WHERE id_siswa = '$id' 
        AND tanggal = '$today'
    ");

    if(mysqli_num_rows($cek) > 0){
        mysqli_query($conn, "
            UPDATE absensi 
            SET status = '$status',
                keterangan = '$keterangan'
            WHERE id_siswa = '$id' 
            AND tanggal = '$today'
        ");
    } else {
        mysqli_query($conn, "
            INSERT INTO absensi (id_siswa, tanggal, hari, status, keterangan)
            VALUES ('$id','$today','$hari','$status','$keterangan')
        ");
    }

    header("Location: izin_sakit.php");
    exit;
}


$data = mysqli_query($conn, "
    SELECT s.*, a.status, a.keterangan
    FROM siswa s
    LEFT JOIN absensi a 
        ON s.id_siswa = a.id_siswa 
        AND a.tanggal = '$today'
    ORDER BY s.nama_siswa ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Izin & Sakit</title>

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
            background:linear-gradient(180deg,#b7e4c7,#95d5b2);
            padding:25px 20px 40px;
            color:white;
            border-bottom-left-radius:40px;
            border-bottom-right-radius:40px;
            text-align:center;
        }

        .container{
            padding:15px;
            margin-top:-25px;
        }

        .card{
            background:#e7e7e7;
            padding:14px;
            border-radius:20px;
            margin-bottom:14px;
            box-shadow:0 4px 8px rgba(0,0,0,0.1);
        }

        .nama{
            font-size:14px;
            margin-bottom:8px;
        }

        .badge{
            float:right;
            padding:5px 15px;
            border-radius:20px;
            font-size:11px;
            color:white;
        }

        .hadir{ background:#52b788; }
        .izin{ background:#f4a261; }
        .sakit{ background:#e63946; }

        .radio-group{
            margin-top:6px;
            font-size:12px;
            display:flex;
            gap:10px;
        }

        textarea{
            width:100%;
            margin-top:8px;
            border:none;
            border-radius:12px;
            padding:8px;
            font-size:12px;
        }

        .btn{
            margin-top:8px;
            background:#52b788;
            color:white;
            border:none;
            padding:6px 15px;
            border-radius:20px;
            font-size:12px;
            cursor:pointer;
        }
    </style>
</head>

<body>
<div class="phone">

    <div class="header">
        <h2>Input Izin & Sakit</h2>
        <small><?php echo $hari." - ".$tanggalFull; ?></small>
    </div>

    <div class="container">

        <?php while($row = mysqli_fetch_assoc($data)){ ?>
        <div class="card">

            <div class="nama">
                <?php echo $row['nama_siswa']; ?>

                <?php if($row['status']){
                    echo "<span class='badge ".strtolower($row['status'])."'>".$row['status']."</span>";
                } ?>
            </div>

            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id_siswa']; ?>">

                <div class="radio-group">
                    <label><input type="radio" name="status" value="Hadir" <?php if($row['status']=="Hadir") echo "checked"; ?>> Hadir</label>
                    <label><input type="radio" name="status" value="Izin" <?php if($row['status']=="Izin") echo "checked"; ?>> Izin</label>
                    <label><input type="radio" name="status" value="Sakit" <?php if($row['status']=="Sakit") echo "checked"; ?>> Sakit</label>
                </div>

                <textarea name="keterangan"><?php echo $row['keterangan']; ?></textarea>

                <button name="simpan" class="btn">Simpan</button>

                <a href="?hapus=<?php echo $row['id_siswa']; ?>">
                    <button type="button" class="btn" style="background:#e63946;">
                        Hapus
                    </button>
                </a>
            </form>

        </div>
        <?php } ?>

        <a href="dashboard.php">
            <button style="width:100%;margin-top:15px;padding:10px;border:none;border-radius:25px;background:#52796f;color:white;">
                Selesai
            </button>
        </a>

    </div>
</div>
</body>
</html>
