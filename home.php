<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dicoba Dulu</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php include 'components/sidebar.php'; ?>

    <div id="main">
        <div class="welcome-container">
            <div class="left-box">SELAMAT DATANG DI AKADEMIK SISWA UNIVERSITAS GARUDA UTAMA</div>
        </div>

        <section class="card-section">
            <div class="card-layer">
                <div class="card card-1">
                    <div class="card-content">
                        <div class="card-text">
                            <p style="font-size:22px; font-family: merriweather; ">Panel Mahasiswa</p>
                            <button class="btn" onclick="window.location.href='main.php'">Selengkapnya</button>
                        </div>
                        <div class="card-image"><img src="image/gambar1.png" alt="Gambar Kartu 1"></div>
                    </div>
                </div>
                <div class="card card-2">
                    <div class="card-content">
                        <div class="card-text">
                            <p style="font-size:22px; font-family: merriweather; ">Panel Mata Kuliah</p>
                            <button class="btn" onclick="window.location.href='mata_kuliah.php'">Selengkapnya</button>
                        </div>
                        <div class="card-image"><img src="image/gambar2.png" alt="Gambar Kartu 2"></div>
                    </div>
                </div>
            </div>
            <div class="card-layer">
                <div class="card card-3">
                    <div class="card-content">
                        <div class="card-text">
                            <p style="font-size:22px; font-family: merriweather; ">Panel Jadwal</p>
                            <button class="btn" onclick="window.location.href='jadwal_kuliah.php'">Selengkapnya</button>
                        </div>
                        <div class="card-image"><img src="image/gambar3.png" alt="Gambar Kartu 3"></div>
                    </div>
                </div>
                <div class="card card-4">
                    <div class="card-content">
                        <div class="card-text">
                            <p style="font-size:22px; font-family: merriweather; ">Panel Kegiatan</p>
                            <button class="btn" onclick="window.location.href='kegiatan.php'">Selengkapnya</button>
                        </div>
                        <div class="card-image"><img src="image/gambar4.png" alt="Gambar Kartu 4"></div>
                    </div>
                </div>
            </div>
            <div class="card-layer">
                <div class="card full-card card-5">
                    <div class="card-content">
                        <div class="card-text">
                            <p style="font-size:22px; font-family: merriweather; ">Panel UKM</p>
                            <button class="btn" onclick="window.location.href='ukm.php'">Selengkapnya</button>
                        </div>
                        <div class="card-image2"><img src="image/gambar5.png" alt="Gambar Kartu 5"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>


<style>
body {
    font-family: "Lato", sans-serif;
    margin: 0;
    padding: 0;
    background-color: #F7F7F7;
}

#main {
    margin-left: 400px;
    padding: 16px;
    display: flex;
    flex-direction: column;
}

.welcome-container {
    display: flex;
    align-items: center;
    margin-top: 50px;
    margin-bottom: 50px;
}

.left-box {
    font-size: 32px;
    width: 60%;
    word-break: break-word;
    font-weight: bolder;
}

.card-section {
    margin-right: 30px;
    background-color: #ffffff;
    padding: 20px;
    margin-top: 10px;
    margin-bottom: 100px;
}

.card-layer {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.card {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px 0px 0px 20px;
    display: flex;
    align-items: flex-start; /* Align items to the top */
}

.full-card {
    width: 100%;
}

.card-content {
    display: flex;
    font-weight: bold;
    width: 100%;
    padding-top: 30px;
    align-items: flex-start; /* Ensure items are aligned to the top */
    justify-content: space-between; 
    justify-content: space-between; 
    position: relative;
}

.card-text {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    padding-top: 0;
}

.card-text p {
    margin: 0 0 10px 0;
}

.card-image img {
    width: 150px;
    height: 180px;
    border-radius: 8px;
    margin-left: 20px;
    align-items: flex-end !important; 
}
.card-image2 img {
    width: 300px;
    height: 150px;
    border-radius: 8px;
    margin-left: 20px;
    align-items: flex-end !important; 
}
.btn {
    width: 200px;
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #0D0C22;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.btn:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

@media screen and (max-width: 600px) {
    .sidebar {
        width: 100%;
    }

    .sidebar a {
        font-size: 18px;
    }

    #main {
        margin-left: 0;
    }
}

.card-layer:first-child .card:nth-child(1) {
    flex-grow: 1;
    max-width: 45%;
    margin-right: 20px;
    /* Memberikan jarak antara kartu kiri dan kanan */
}

.card-layer:first-child .card:nth-child(2) {
    flex-grow: 2;
    max-width: 55%;
}

.card-layer .card {
    margin-right: 20px;
    /* Memberikan jarak antar kartu */
}

.card-layer .card:last-child {
    margin-right: 0;
    /* Menghilangkan margin pada kartu terakhir di layer */
}

.card-layer:not(:first-child):not(:last-child) .card {
    flex-grow: 1;
    width: 48%;
    /* Atur lebar kartu pada layer selain layer pertama dan terakhir */
    max-width: 48%;
}

.card-layer:last-child .card {
    width: 100%;
    /* Atur lebar kartu pada layer terakhir menjadi penuh */
    max-width: 100%;
}

/* Custom Backgrounds for Each Card */
.card-1 {
    background-image: url(image/bghome.png);
}

.card-2 {
    background-image: url(image/bghomedua.png);
}

.card-3 {
    background-image: url(image/bghometiga.png);
    
}

.card-4 {
    background-image: url(image/bghomeempat.png);
    background-position: center;
}

.card-5 {
    background-image: url(image/bghomelima.png);
}
</style>
