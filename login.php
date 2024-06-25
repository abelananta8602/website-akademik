<?php
include 'koneksi.php';

if (!file_exists('koneksi.php')) {
    echo "File 'koneksi.php' not found!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            echo "Login berhasil!";
            
            header("Location: home.php");
            exit();
        } else {
            echo "Login gagal! Kata sandi salah.";
        }
    } else {
        echo "Login gagal! Username salah.";
    }

    $conn->close();
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #F7F7F7;
            display: flex;
            flex-direction: column;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .sidebar {
            height: 100%;
            width: 270px;
            position: fixed;
            top: 0;
            left: 0;
            background-image: url('image/bglogindua.png');
            background-color: #0D0C22;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        #main {
            margin-left: 270px;
            padding: 16px;
            overflow-y: auto;
            flex: 1;
          
        }

        .header {
            margin-left: 70px;
            margin-top: 150px;
            padding-bottom: 20px;
        }

        .header p,
        .header h4 {
            margin: 0;
        }

        .header p {
            font-size: 28px;
            line-height: 1.2;
        }

        .header h4 {
            font-size: 33px;
            line-height: 1.2;
            margin-top: 10px;
        }

        .container {
            margin-left: 51px;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            padding: 0 20px;
        }

        .card {
            height: 330px;
            padding: 20px;
            width: 480px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 20px;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .form-control {
            width: 400px;
            height: 40px;
            font-size: 0.9rem;
            background-color: #E6E6E6;
        }

        .signup {
            margin-left: 60px;
            height: 290px;
            margin-top: 20px;
            background-color: #0E0D23;
            color: white;
            padding: 20px;
            border-radius: 0px 0px 60px 0px;
            width: 230px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .signup p {
            margin: 0;
            font-size: 1.1rem;
            text-align: center;
            
            margin-bottom: 10px;
        }

        .btn-circle {
            width: 40px;
            height: 40px;
            padding: 0;
            border-radius: 50%;
            font-size: 20px;
            line-height: 40px;
            background-color: white;
            color: black;
            border: none;
            text-align: center;
            cursor: pointer;
        }

        .content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-left: 340px;
        }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <center>
            <h1 style="font-size:25px; color:white; font-family:merriweather; margin-top: 370px;">LOGIN</h1>
        </center>
    </div>
    <div id="main">
        <div>
            <div class="header">
                <p style="font-family:merriweather;">PANEL ADMIN</p>
                <h4 style="font-weight:bold; font-family:merriweather;">AKADEMIK SISWA UNIVERSITAS GARUDA UTAMA</h4>
            </div>
            <div class="container">
                <div class="row" style="height: 80vh;">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form action="login.php" method="POST" autocomplete="off">
                                    <div class="mb-3">
                                        <label style="margin-top: 17px;" for="username" class="form-label">Masukkan Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" autocomplete="off" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Masukkan kata sandi</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan kata sandi" autocomplete="off" value="">
                                    </div>
                                    <button style="height:40px; width:400px; background-color:black; color:white" type="submit" >Log in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="signup">
                            <p style="font-family:merriweather; font-size:18px">Anda belum punya akun?<br><strong style="font-family:merriweather; font-size:22px">DAFTAR YUK!</strong></p>
                            <a href="register.php" class="btn btn-circle">></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
