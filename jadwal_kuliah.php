<?php
include 'koneksi.php';

function get_jadwal_kuliah($conn) {
    $sql = "SELECT * FROM jadwal_kuliah";
    $result = $conn->query($sql);
    return $result;
}

function get_jadwal_kuliah_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM jadwal_kuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
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
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO jadwal_kuliah (hari, tanggal, waktu, mata_kuliah, dosen, ruangan, kode_mk, tipe_kelas) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $hari, $tanggal, $waktu, $mata_kuliah, $dosen, $ruangan, $kode_mk, $tipe_kelas);
    } elseif ($action == 'edit') {
        $stmt = $conn->prepare("UPDATE jadwal_kuliah SET hari=?, tanggal=?, waktu=?, mata_kuliah=?, dosen=?, ruangan=?, kode_mk=?, tipe_kelas=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $hari, $tanggal, $waktu, $mata_kuliah, $dosen, $ruangan, $kode_mk, $tipe_kelas, $id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: jadwal_kuliah.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM jadwal_kuliah WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: jadwal_kuliah.php");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = get_jadwal_kuliah_by_id($conn, $_GET['edit']);
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
            <li><a style="font-weight:semi-bold;" class="text-dark" href="main.php">Mahasiswa</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="mata_kuliah.php">Mata Kuliah</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="jadwal_kuliah.php">Jadwal Kuliah</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="ukm.php">UKM</a></li>
            <li><a style="font-weight:semi-bold;" class="text-dark" href="kegiatan.php">Kegiatan</a></li>
        </ul>
    </nav>
    <div style="margin-top: 50px;" class="container">
        <div class="text-center">
            <button style="margin:30px; font-weight:bold; background-color:#60EFFF" id="openModal" class="text-dark btn">Tambah Jadwal Kuliah</button>
        </div>
        <center>
            <table>
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
                            echo '<td>' . $row['hari'] . '</td>';
                            echo '<td>' . $row['tanggal'] . '</td>';
                            echo '<td>' . $row['waktu'] . '</td>';
                            echo '<td>' . $row['mata_kuliah'] . '</td>';
                            echo '<td>' . $row['dosen'] . '</td>';
                            echo '<td>' . $row['ruangan'] . '</td>';
                            echo '<td>' . $row['kode_mk'] . '</td>';
                            echo '<td>' . $row['tipe_kelas'] . '</td>';
                            echo '<td>
                            <a href="jadwal_kuliah.php?edit=' . $row['id'] . '">Edit</a> |
                            <a href="jadwal_kuliah.php?delete=' . $row['id'] . '">Hapus</a>
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
        <span class="close">&times;</span>
        <h2 style="margin-top: 15px;">Tambah/Ubah Jadwal Kuliah</h2>
        <form id="jadwalForm" method="post" action="jadwal_kuliah.php">
            <input type="hidden" name="action" value="<?php echo isset($editData) ? 'edit' : 'add'; ?>">
            <input type="hidden" name="id" value="<?php echo isset($editData) ? $editData['id'] : ''; ?>">
            <label style="margin-top: 10px;" for="hari">Hari:</label>
            <input type="text" id="hari" name="hari" value="<?php echo isset($editData) ? $editData['hari'] : ''; ?>" required>
            <label for="tanggal">Tanggal:</label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo isset($editData) ? $editData['tanggal'] : ''; ?>" required>
            <label for="waktu">Waktu:</label>
            <input type="text" id="waktu" name="waktu" value="<?php echo isset($editData) ? $editData['waktu'] : ''; ?>" required>
            <label for="mata_kuliah">Mata Kuliah:</label>
            <input type="text" id="mata_kuliah" name="mata_kuliah" value="<?php echo isset($editData) ? $editData['mata_kuliah'] : ''; ?>" required>
            <label for="dosen">Dosen:</label>
            <input type="text" id="dosen" name="dosen" value="<?php echo isset($editData) ? $editData['dosen'] : ''; ?>" required>
            <label for="ruangan">Ruangan:</label>
            <input type="text" id="ruangan" name="ruangan" value="<?php echo isset($editData) ? $editData['ruangan'] : ''; ?>" required>
            <label for="kode_mk">Kode Mata Kuliah:</label>
            <input type="text" id="kode_mk" name="kode_mk" value="<?php echo isset($editData) ? $editData['kode_mk'] : ''; ?>" required>
            <label for="tipe_kelas">Tipe Kelas:</label>
            <select id="tipe_kelas" name="tipe_kelas" required>
                <option value="Teori" <?php echo isset($editData) && $editData['tipe_kelas'] == 'Teori' ? 'selected' : ''; ?>>Teori</option>
                <option value="Praktikum" <?php echo isset($editData) && $editData['tipe_kelas'] == 'Praktikum' ? 'selected' : ''; ?>>Praktikum</option>
            </select>
            <button style=" background-color: #60EFFF; margin-top: 30px;" type="submit"><?php echo isset($editData) ? 'Ubah' : 'Tambah'; ?></button>
        </form>
    </div>
</div>


    <style>
        nav {
            background-color: #60EFFF;
            color: white;
            padding: 20px 0;
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
            font-weight: 500;
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .text-center {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
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
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            max-height: 70vh;
            border-radius: 8px;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #60EFFF;
            font-weight: bold;
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #50d8d8;
        }
    </style>

    <script>
        var modal = document.getElementById("formModal");
var btn = document.getElementById("openModal");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    document.getElementById('jadwalForm').reset();
    modal.style.display = "block";
    document.querySelector("input[name='action']").value = 'add';
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

<?php if (isset($_GET['edit'])): ?>
document.getElementById("formModal").style.display = "block";
document.querySelector("input[name='action']").value = 'edit';
<?php endif; ?>

    </script>
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
