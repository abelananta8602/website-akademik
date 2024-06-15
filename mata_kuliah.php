<?php
include 'koneksi.php';

function get_matakuliah($conn) {
    $sql = "SELECT * FROM matakuliah";
    $result = $conn->query($sql);
    return $result;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $namamatakuliah = $_POST['namamatakuliah'];
    $dosen = $_POST['dosen'];
    $jam = $_POST['jam'];
    $tanggal = $_POST['tanggal'];

    if ($_POST['action'] == 'add') {
        $sql = "INSERT INTO matakuliah (namamatakuliah, dosen, jam, tanggal) VALUES ('$namamatakuliah', '$dosen', '$jam', '$tanggal')";
    } elseif ($_POST['action'] == 'edit') {
        $sql = "UPDATE matakuliah SET namamatakuliah='$namamatakuliah', dosen='$dosen', jam='$jam', tanggal='$tanggal' WHERE id='$id'";
    }
    $conn->query($sql);
    header("Location: mata_kuliah.php");
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM matakuliah WHERE id='$id'";
    $conn->query($sql);
    header("Location: mata_kuliah.php");
}

// Inisialisasi variabel untuk formulir
$action = 'add';
$id = $namamatakuliah = $dosen = $jam = $tanggal = '';

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM matakuliah WHERE id='$id'");
    $row = $result->fetch_assoc();
    $namamatakuliah = $row['namamatakuliah'];
    $dosen = $row['dosen'];
    $jam = $row['jam'];
    $tanggal = $row['tanggal'];
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
            <button style="font-weight:700; background-color: #60EFFF;" class="text-dark" onclick="document.getElementById('formModal').style.display='block'">Tambah Mata Kuliah</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nama Mata Kuliah</th>
                    <th>Dosen</th>
                    <th>Jam</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $result = get_matakuliah($conn);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>'.$row['namamatakuliah'].'</td>';
                        echo '<td>'.$row['dosen'].'</td>';
                        echo '<td>'.$row['jam'].'</td>';
                        echo '<td>'.$row['tanggal'].'</td>';
                        echo '<td>
                            <a href="mata_kuliah.php?edit='.$row['id'].'">Edit</a> |
                            <a href="mata_kuliah.php?delete='.$row['id'].'">Hapus</a>
                        </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="5" class="text-center">Tidak ada data mata kuliah</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="formModal" class="modal">
        <div class="modal-content">
        <span class="close" onclick="document.getElementById('formModal').style.display='none'">&times;</span>
            <h2><?php echo $action == 'add' ? 'Tambah Mata Kuliah' : 'Edit Mata Kuliah'; ?></h2>
            <form method="post" action="mata_kuliah.php">
                <input type="hidden" name="action" value="<?php echo $action; ?>">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="namamatakuliah">Nama Mata Kuliah:</label>
                <input type="text" id="namamatakuliah" name="namamatakuliah" value="<?php echo $namamatakuliah; ?>" required>
                <label for="dosen">Dosen:</label>
                <input type="text" id="dosen" name="dosen" value="<?php echo $dosen; ?>" required>
                <label for="jam">Jam:</label>
                <input type="time" id="jam" name="jam" value="<?php echo $jam; ?>" required>
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" required>
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
