<?php
include 'koneksi.php';


function get_kegiatan($conn) {
    $sql = "SELECT * FROM kegiatan";
    $result = $conn->query($sql);
    return $result;
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM kegiatan WHERE id='$id'";
    $conn->query($sql);
    header("Location: kegiatan.php");
}

$id = $nama_kegiatan = $deskripsi = $waktu = $tempat = '';
$action = 'add';

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM kegiatan WHERE id='$id'");
    $row = $result->fetch_assoc();
    $nama_kegiatan = $row['nama_kegiatan'];
    $deskripsi = $row['deskripsi'];
    $waktu = $row['waktu'];
    $tempat = $row['tempat'];
    $action = 'edit';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $deskripsi = $_POST['deskripsi'];
    $waktu = $_POST['waktu'];
    $tempat = $_POST['tempat'];

    if ($_POST['action'] == 'add') {
        $sql = "INSERT INTO kegiatan (nama_kegiatan, deskripsi, waktu, tempat) VALUES ('$nama_kegiatan', '$deskripsi', '$waktu', '$tempat')";
    } elseif ($_POST['action'] == 'edit') {
        $sql = "UPDATE kegiatan SET nama_kegiatan='$nama_kegiatan', deskripsi='$deskripsi', waktu='$waktu', tempat='$tempat' WHERE id='$id'";
    }
    $conn->query($sql);
    header("Location: kegiatan.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Akademik</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav>
        <ul>
            <li><a style="font-weight:semi-bold;"  href="main.php">Mahasiswa</asty></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="mata_kuliah.php">Mata Kuliah</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="jadwal_kuliah.php">Jadwal Kuliah</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="ukm.php">UKM</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="kegiatan.php">Kegiatan</a></li>
        </ul>
    </nav>
    <div class="container">
       
        <button style="margin-top:70px; font-weight:bold; background-color:#60EFFF" id="openModal" class="text-dark; btn ">Tambah Kegiatan</button>

  
        <div id="ukmModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="modalTitle">Tambah UKM</h2>
                <form id="ukmForm" method="post">
                    <input type="hidden" name="action" id="action" value="add">
                    <input type="hidden" name="id" id="id">
                    <label for="nama">Nama UKM:</label>
                    <input type="text" id="nama" name="nama" required>
                    <label for="deskripsi">Deskripsi:</label>
                    <textarea id="deskripsi" name="deskripsi" required></textarea>
                    <button type="submit">Simpan</button>
                </form>
            </div>
        </div>

      
        <div class="card-container">
            <?php
            $result = get_kegiatan($conn);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="card">
                        <div class="card-content">
                            <h2>' . $row['nama_kegiatan'] . '</h2>
                            <p>' . $row['deskripsi'] . '</p>
                            <div class="card-actions">
                                <button class="edit-btn" data-id="' . $row['id'] . '" data-nama="' . $row['nama_kegiatan'] . '" data-deskripsi="' . $row['deskripsi'] . '">Edit</button>
                                <a href="kegiatan.php?delete=' . $row['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<p>Tidak ada Kegiatan</p>';
            }
            ?>
        </div>
    </div>

    <script>
      
        var modal = document.getElementById("ukmModal");

      var btn = document.getElementById("openModal");

      
        var span = document.getElementsByClassName("close")[0];

        
        btn.onclick = function() {
            document.getElementById('ukmForm').reset();
            document.getElementById('modalTitle').innerText = 'Tambah UKM';
            document.getElementById('action').value = 'add';
            modal.style.display = "block";
        }

        
        span.onclick = function() {
            modal.style.display = "none";
        }

        
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('modalTitle').innerText = 'Edit UKM';
                document.getElementById('action').value = 'edit';
                document.getElementById('id').value = button.getAttribute('data-id');
                document.getElementById('nama').value = button.getAttribute('data-nama');
                document.getElementById('deskripsi').value = button.getAttribute('data-deskripsi');
                modal.style.display = "block";
            });
        });
    </script>
</body>
</html>

<style>
    nav {
    background-color: #60EFFF;
    color: white;
    padding: 10px 0;
}

nav ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 15px;
}

nav ul li a {
    color: black;
    text-decoration: none;
    font-size: 18px;
}

nav ul li a:hover {
    text-decoration: underline;
}
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
}
    body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}

.text-center {
    text-align: center;
}

.btn {
    background-color: #60EFFF;
    
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: inline-block;
    margin-bottom: 20px;
}

.btn:hover {
    background-color: #0056b3;
}

.card-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
}

.card {
    width: 300px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.card-content {
    padding: 20px;
}

.card-content h2 {
    margin-top: 0;
}

.card-content p {
    color: #555;
}

.card-actions {
    padding-top: 10px;
    border-top: 1px solid #ddd;
    text-align: right;
}

.card-actions button,
.card-actions a {
    color: #007bff;
    text-decoration: none;
    margin-left: 10px;
    background: none;
    border: none;
    cursor: pointer;
    font: inherit;
}

.card-actions button:hover,
.card-actions a:hover {
    text-decoration: underline;
}

.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4); 
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; 
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    max-width: 500px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

</style>
