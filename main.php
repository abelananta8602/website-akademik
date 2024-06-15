<?php
include 'koneksi.php';

// Fungsi untuk menampilkan data mahasiswa
function get_mahasiswa($conn) {
    $sql = "SELECT * FROM mahasiswa";
    $result = $conn->query($sql);
    return $result;
}

// Fungsi untuk menambah atau mengedit mahasiswa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];

    if ($_POST['action'] == 'add') {
        $sql = "INSERT INTO mahasiswa (nim, nama, alamat, email, telepon) VALUES ('$nim', '$nama', '$alamat', '$email', '$telepon')";
    } elseif ($_POST['action'] == 'edit') {
        $sql = "UPDATE mahasiswa SET nama='$nama', alamat='$alamat', email='$email', telepon='$telepon' WHERE nim='$nim'";
    }
    $conn->query($sql);
    header("Location: main.php");
}

// Fungsi untuk menghapus mahasiswa
if (isset($_GET['delete'])) {
    $nim = $_GET['delete'];
    $sql = "DELETE FROM mahasiswa WHERE nim='$nim'";
    $conn->query($sql);
    header("Location: main.php");
}

// Inisialisasi variabel untuk formulir
$action = 'add';
$nim = $nama = $alamat = $email = $telepon = '';

if (isset($_GET['edit'])) {
    $nim = $_GET['edit'];
    $result = $conn->query("SELECT * FROM mahasiswa WHERE nim='$nim'");
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
    $alamat = $row['alamat'];
    $email = $row['email'];
    $telepon = $row['telepon'];
    $action = 'edit';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Akademik</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<nav>
        <ul>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="main.php">Mahasiswa</asty></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="mata_kuliah.php">Mata Kuliah</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="jadwal_kuliah.php">Jadwal Kuliah</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="ukm.php">UKM</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="kegiatan.php">Kegiatan</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="text-center">
            <button style="font-weight:700; background-color: paleturquoise;" class="text-dark" onclick="document.getElementById('formModal').style.display='block'">Tambah Mahasiswa</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = get_mahasiswa($conn);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.$row['nim'].'</td>';
                        echo '<td>'.$row['nama'].'</td>';
                        echo '<td>'.$row['alamat'].'</td>';
                        echo '<td>'.$row['email'].'</td>';
                        echo '<td>'.$row['telepon'].'</td>';
                        echo '<td>
                            <a href="main.php?edit='.$row['nim'].'">Edit</a> |
                            <a href="main.php?delete='.$row['nim'].'">Hapus</a>
                        </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">Tidak ada data mahasiswa</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="formModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('formModal').style.display='none'">&times;</span>
            <h2><?php echo $action == 'add' ? 'Tambah Mahasiswa' : 'Edit Mahasiswa'; ?></h2>
            <form method="post" action="main.php">
                <input type="hidden" name="action" value="<?php echo $action; ?>">
                <label for="nim">NIM:</label>
                <input type="text" id="nim" name="nim" value="<?php echo $nim; ?>" required <?php echo $action == 'edit' ? 'readonly' : ''; ?>>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>
                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
                <label for="telepon">No. Telepon:</label>
                <input type="text" id="telepon" name="telepon" value="<?php echo $telepon; ?>" required>
                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>
</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    
</head>
<body>

</body>
</html>

<style>
    nav {
    background-color: paleturquoise;
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
    color: white;
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

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
    text-align: left;
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
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 10% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
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

.text-center {
    text-align: center;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    display: inline-block;
    margin: 10px 0;
    text-decoration: none;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

</style>
