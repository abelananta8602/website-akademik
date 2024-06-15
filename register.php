<?php

include 'koneksi.php';

if (!file_exists('koneksi.php')) {
    echo "File 'db.php' not found!";
    exit();
}





if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (email, username, password) VALUES ('$email', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body>
<div style="margin-top: 70px" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div style="background-color: #60EFFF;"  class="card-header text-center">
                    <h2>Register</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="register.php">
                        <div class="form-group">
                           <p style="font-weight: 400;" >Complete the data below to create your new account.</p>
                            <label style="margin-top:10px"  for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button style="font-weight:bold; background-color: #60EFFF;"  type="submit" class="text-dark btn btn-primary btn-block">register</button>
                        <center style="margin-top: 20px;" ><span>if you already have an account, you can create one <a href="login.php">here.</a></span></center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<style>
    body{
       
    background-repeat: no-repeat;
        background-image: url('image/bg.png');
        background-size:53% auto ; 
        display: flex;
    }
</style>
