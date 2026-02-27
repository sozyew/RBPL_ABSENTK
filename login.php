<?php
session_start();

$default_username = "admin";
$default_password = "12345";

if(isset($_POST['login'])){
    if($_POST['username'] == $default_username && $_POST['password'] == $default_password){
        $_SESSION['login'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins', sans-serif;
}

body{
    background:#1c1c1c;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}


.phone{
    width:390px;
    height:844px;
    border-radius:40px;
    overflow:hidden;
    box-shadow:0 25px 60px rgba(0,0,0,0.5);
}


.login-screen{
    height:100%;
    background:linear-gradient(to bottom,#a8c48c,#5f8f73);
    padding:25px;
    text-align:center;
    position:relative;
}


.login-img{
    width:100%;
    margin-top:30px;
}


.title{
    color:white;
    font-size:32px;
    font-weight:600;
    margin:30px 0;
}


input{
    width:100%;
    padding:16px;
    margin:15px 0;
    border:none;
    border-radius:35px;
    background:#f2f2f2;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
    font-size:14px;
    outline:none;
}


button{
    width:65%;
    padding:14px;
    margin-top:20px;
    border:none;
    border-radius:35px;
    background:linear-gradient(to right,#4fd1a5,#e5e2b8);
    font-weight:600;
    font-size:16px;
    cursor:pointer;
}


.bottom-text{
    position:absolute;
    bottom:40px;
    width:100%;
    left:0;
    text-align:center;
    color:#111;
    font-size:14px;
}

.bottom-text span{
    font-weight:700;
}

.error{
    color:#ffdddd;
    margin-bottom:10px;
}
</style>

</head>
<body>

<div class="phone">
<div class="login-screen">

    <img src="SISWA.jpg" class="login-img">

    <h1 class="title">Welcome Back</h1>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="username" placeholder="username" required>
        <input type="password" name="password" placeholder="password" required>
        <button type="submit" name="login">Sign In</button>
    </form>

    <!-- <div class="bottom-text">
        Belum Punya Akun?<br>
        <span>Masuk</span>
    </div> -->

</div>
</div>

</body>
</html>