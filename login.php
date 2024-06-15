<?php


include 'koneksi.php';

if (!file_exists('koneksi.php')) {
    echo "File 'db.php' not found!";
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            header("Location: main.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email address.";
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
<div style="margin-top: 100px;" class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div style="background-color: #60EFFF;" class="card-header text-center">
                    <h2>Login</h2>
                </div>
                <div class="card-body">
                    <form method="POST" action="login.php">
                        <div class="form-group">
                            <span>Please enter your username and password to enter the website.</span>
                            <label style="margin-top:20px" for="email">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button style="font-weight:bold; background-color: #60EFFF;" type="submit" class="text-dark btn btn-primary btn-block">Login</button>
                        <center style="margin-top: 20px;" ><span>if you don't have an account then you can create an account <a href="register.php">here.</a></span></center>
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


