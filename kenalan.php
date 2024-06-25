<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perkenalan Anggota Kelompok</title>
    <style>
        body {
            background-image: url(image/elips.png);
            background-size: cover;
            background-position: bottom center;
            background-repeat: no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #E6E6E6;
            margin: 0;
            padding: 0;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 1s ease, opacity 1s ease;
            position: absolute;
        }
        .container.hide {
            transform: translateY(-100vh);
            opacity: 0;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .member-card {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 200px;
            text-align: center;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-10px);
        }
        .card img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 15px;
        }
        .card h2 {
            margin: 0;
            color: #333;
            font-size: 1.5em;
        }
        .card p {
            margin: 5px 0 0;
            color: #777;
            font-size: 1em;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        .button-container a {
            text-decoration: none;
            padding: 15px 30px;
            background-color: #0D0C22;
            color: #fff;
            border-radius: 50px;
            font-size: 1.2em;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .button-container a:hover {
            background-color: #0D0C22;
            transform: scale(1.05);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
        }
        .button-container a:active {
            background-color: #0D0C22;
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <h1>Perkenalan Anggota Kelompok</h1>
        <div class="member-card">
            <div class="card">
              
                <h2>Abel Ananta Putra Saputro</h2>
                <p>NIM: 202351071</p>
            </div>
            <div class="card">
             
                <h2>Defin Faisa Hakim</h2>
                <p>NIM: 202351069</p>
            </div>
            <div class="card">
              
                <h2>Hisyam</h2>
                <p>NIM: 202351057</p>
            </div>
            <div class="card">
               
                <h2>Vito Latif Mahendra</h2>
                <p>NIM: 202351060</p>
            </div>
            <div class="card">
                
                <h2>Ahmad Fahriz Fadhilah</h2>
                <p>NIM: 202351049</p>
            </div>
        </div>
        <div class="button-container">
            <a href="#" id="startButton">Mulai Program</a>
        </div>
    </div>
    <script>
        document.getElementById('startButton').addEventListener('click', function(event) {
            event.preventDefault();
            var container = document.getElementById('container');
            container.classList.add('hide');
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 1000); // Sesuaikan dengan durasi animasi
        });
    </script>
</body>
</html>
