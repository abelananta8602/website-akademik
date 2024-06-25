
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-section">
            <div style="margin-left:70px">
                <a class="tulisan1" style="font-size: 20px; font-family: merriweather;" href="">Panel Admin</a>
                <a class="tulisan1" style="font-size: 25px; padding-left: 30px; font-family: merriweather; font-weight: bold;" href="">Akademik</a>
            </div>
        </div>

        <?php
        $current_page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file halaman saat ini

        $menu_items = [
            ['name' => 'Beranda', 'url' => 'home.php'],
            ['name' => 'Mahasiswa', 'url' => 'main.php'],
            ['name' => 'Mata Kuliah', 'url' => 'mata_kuliah.php'],
            ['name' => 'Jadwal Kuliah', 'url' => 'jadwal_kuliah.php'],
            ['name' => 'UKM', 'url' => 'ukm.php'],
            ['name' => 'Kegiatan', 'url' => 'kegiatan.php']
            
        ];

        foreach ($menu_items as $item) {
            $active_class = ($current_page === $item['url']) ? 'active' : '';
            echo "<a href='{$item['url']}' class='menu-item {$active_class}'>{$item['name']}</a>";
        }
        ?>
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

.tulisan1 {
    color: #000 !important;
}

.sidebar-section {
    padding-top: 20px;
    padding-bottom: 20px;
    margin: 0;
    background-color: #FFF6E9;
    color: #000;
    border-radius: 0px 0px 35px 0px;
}

.sidebar {
    height: 100%;
    width: 330px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #0D0C22;
    overflow-x: hidden;
}

.sidebar a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 25px;
    color: #ffffff;  /* Warna teks default putih */
    display: block;
    transition: 0.3s;
}

.sidebar a:hover,
.sidebar a.active {
    color: #000000;  /* Warna teks hitam saat aktif atau di-hover */
    background-color: #FFF6E9;
}

.sidebar a.menu-item {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 23px;
    color: #ffffff;  /* Warna teks default putih */
    margin-top: 30px;
}

.sidebar a.menu-item:hover,
.sidebar a.menu-item.active {
    color: #000000;  /* Warna teks hitam saat aktif atau di-hover */
    background-color: #FFF6E9;
}
</style>
