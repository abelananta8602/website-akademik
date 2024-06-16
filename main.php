<?php
include 'koneksi.php';

function get_mahasiswa($conn)
{
    $sql = "SELECT * FROM mahasiswa";
    $result = $conn->query($sql);
    return $result;
}

function get_mahasiswa_by_id($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM mahasiswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO mahasiswa (nim, nama, alamat, email, telepon) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nim, $nama, $alamat, $email, $telepon);
    } elseif ($action == 'edit') {
        $stmt = $conn->prepare("UPDATE mahasiswa SET nim=?, nama=?, alamat=?, email=?, telepon=? WHERE id=?");
        $stmt->bind_param("sssssi", $nim, $nama, $alamat, $email, $telepon, $id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: main.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: main.php");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = get_mahasiswa_by_id($conn, $_GET['edit']);
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
        <button style="margin:30px; font-weight:bold; background-color:#60EFFF" id="openModal" class="text-dark btn">Tambah Mahasiswa</button>
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
                    echo '<td>' . $row['nim'] . '</td>';
                    echo '<td>' . $row['nama'] . '</td>';
                    echo '<td>' . $row['alamat'] . '</td>';
                    echo '<td>' . $row['email'] . '</td>';
                    echo '<td>' . $row['telepon'] . '</td>';
                    echo '<td>
                            <a href="main.php?edit=' . $row['id'] . '">Edit</a> |
                            <a href="main.php?delete=' . $row['id'] . '">Hapus</a>
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
        <span class="close">&times;</span>
        <h2 style="margin-top: 15px;"><?php echo isset($editData) ? 'Edit' : 'Tambah'; ?> Mahasiswa</h2>
        <form id="mahasiswaForm" method="post" action="main.php">
            <input type="hidden" name="action" value="<?php echo isset($editData) ? 'edit' : 'add'; ?>">
            <input type="hidden" name="id" value="<?php echo isset($editData) ? $editData['id'] : ''; ?>">
            <label for="nim">NIM:</label>
            <input type="text" id="nim" name="nim" value="<?php echo isset($editData) ? $editData['nim'] : ''; ?>" required>

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo isset($editData) ? $editData['nama'] : ''; ?>" required>

            <label for="alamat">Alamat:</label>
            <input type="text" id="alamat" name="alamat" value="<?php echo isset($editData) ? $editData['alamat'] : ''; ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo isset($editData) ? $editData['email'] : ''; ?>" required>

            <label for="telepon">No. Telepon:</label>
            <input type="text" id="telepon" name="telepon" value="<?php echo isset($editData) ? $editData['telepon'] : ''; ?>" required>
            <button type="submit"><?php echo isset($editData) ? 'Ubah' : 'Simpan'; ?></button>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById("formModal");
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        document.getElementById('mahasiswaForm').reset();
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

    <?php if (isset($_GET['edit'])) : ?>
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