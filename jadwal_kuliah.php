<?php
include 'koneksi.php';

function get_jadwal_kuliah($conn) {
    $sql = "SELECT * FROM jadwal_kuliah";
    $result = $conn->query($sql);
    return $result;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $hari = $_POST['hari'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $mata_kuliah = $_POST['mata_kuliah'];
    $dosen = $_POST['dosen'];
    $ruangan = $_POST['ruangan'];
    $kode_mk = $_POST['kode_mk'];
    $tipe_kelas = $_POST['tipe_kelas'];

    if ($_POST['action'] == 'add') {
        $sql = "INSERT INTO jadwal_kuliah (hari, tanggal, waktu, mata_kuliah, dosen, ruangan, kode_mk, tipe_kelas) VALUES ('$hari', '$tanggal', '$waktu', '$mata_kuliah', '$dosen', '$ruangan', '$kode_mk', '$tipe_kelas')";
    } elseif ($_POST['action'] == 'edit') {
        $sql = "UPDATE jadwal_kuliah SET hari='$hari', tanggal='$tanggal', waktu='$waktu', mata_kuliah='$mata_kuliah', dosen='$dosen', ruangan='$ruangan', kode_mk='$kode_mk', tipe_kelas='$tipe_kelas' WHERE id='$id'";
    }
    $conn->query($sql);
    header("Location: jadwal_kuliah.php");
}

 if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM jadwal_kuliah WHERE id='$id'";
$conn->query($sql);
header("Location: jadwal_kuliah.php");
}


$action = 'add';
$id = $hari = $tanggal = $waktu = $mata_kuliah = $dosen = $ruangan = $kode_mk = $tipe_kelas = '';

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM jadwal_kuliah WHERE id='$id'");
    $row = $result->fetch_assoc();
    $hari = $row['hari'];
    $tanggal = $row['tanggal'];
    $waktu = $row['waktu'];
    $mata_kuliah = $row['mata_kuliah'];
    $dosen = $row['dosen'];
    $ruangan = $row['ruangan'];
    $kode_mk = $row['kode_mk'];
    $tipe_kelas = $row['tipe_kelas'];
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
            <button style="font-weight:700; background-color: #60EFFF;" class="text-dark" onclick="document.getElementById('formModal').style.display='block'">Tambah Jadwal Kuliah</button>
        </div>
        <center>
        <table >
            <thead>
                <tr>
                <th>Hari</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Ruangan</th>
                    <th>Kode Mata Kuliah</th>
                    <th>Tipe Kelas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            
                $result = get_jadwal_kuliah($conn);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.$row['hari'].'</td>';
                        echo '<td>'.$row['tanggal'].'</td>';
                        echo '<td>'.$row['waktu'].'</td>';
                        echo '<td>'.$row['mata_kuliah'].'</td>';
                        echo '<td>'.$row['dosen'].'</td>';
                        echo '<td>'.$row['ruangan'].'</td>';
                        echo '<td>'.$row['kode_mk'].'</td>';
                        echo '<td>'.$row['tipe_kelas'].'</td>';
                        echo '<td>
                            <a href="jadwal_kuliah.php?edit='.$row['id'].'">Edit</a> |
                            <a href="jadwal_kuliah.php?delete='.$row['id'].'">Hapus</a>
                        </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="9" class="text-center">Tidak ada jadwal kuliah</td></tr>';
                }
                ?>
            </tbody>
        </table>
        </center>
    </div>

    <div id="formModal" class="modal">
        <div class="modal-content">
        <span class="close" onclick="document.getElementById('formModal').style.display='none'">&times;</span>
            <h2><?php echo $action == 'add' ? 'Tambah Jadwal Kuliah' : 'Edit Jadwal Kuliah'; ?></h2>
            <form method="post" action="jadwal_kuliah.php">
                <input type="hidden" name="action" value="<?php echo $action; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="hari">Hari:</label>
                <input type="text" id="hari" name="hari" value="<?php echo $hari; ?>" required>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" required>
                <label for="waktu">Waktu:</label>
                <input type="text" id="waktu" name="waktu" value="<?php echo $waktu; ?>" required>
                <label for="mata_kuliah">Mata Kuliah:</label>
                <input type="text" id="mata_kuliah" name="mata_kuliah" value="<?php echo $mata_kuliah; ?>" required>
                <label for="dosen">Dosen:</label>
                <input type="text" id="dosen" name="dosen" value="<?php echo $dosen; ?>" required>
                <label for="ruangan">Ruangan:</label>
                <input type="text" id="ruangan" name="ruangan" value="<?php echo $ruangan; ?>" required>
                <label for="kode_mk">Kode Mata Kuliah:</label>
                <input type="text" id="kode_mk" name="kode_mk" value="<?php echo $kode_mk; ?>" required>
                <label for="tipe_kelas">Tipe Kelas:</label>
                <select id="tipe_kelas" name="tipe_kelas" required>
                    <option value="Teori" <?php echo $tipe_kelas == 'Teori' ? 'selected' : ''; ?>>Teori</option>
                    <option value="Praktikum" <?php echo $tipe_kelas == 'Praktikum' ? 'selected' : ''; ?>>Praktikum</option>
                </select>
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
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
}

table {
    width: 900px;
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


