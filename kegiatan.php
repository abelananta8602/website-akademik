<?php
include 'koneksi.php';

function get_kegiatan($conn)
{
    $sql = "SELECT * FROM kegiatan";
    $result = $conn->query($sql);
    return $result;
}

function get_kegiatan_by_id($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM kegiatan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama_kegiatan = $_POST['nama_kegiatan'];
    $deskripsi = $_POST['deskripsi'];
    $waktu = $_POST['waktu'];
    $tempat = $_POST['tempat'];
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO kegiatan (nama_kegiatan, deskripsi, waktu, tempat) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama_kegiatan, $deskripsi, $waktu, $tempat);
    } elseif ($action == 'edit') {
        $stmt = $conn->prepare("UPDATE kegiatan SET nama_kegiatan=?, deskripsi=?, waktu=?, tempat=? WHERE id=?");
        $stmt->bind_param("ssssi", $nama_kegiatan, $deskripsi, $waktu, $tempat, $id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: kegiatan.php");
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM kegiatan WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: kegiatan.php");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = get_kegiatan_by_id($conn, $_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Akademik - Kegiatan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
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
        <button style="margin:30px; font-weight:bold; background-color:#60EFFF" id="openModal" class="text-dark btn">Tambah Kegiatan</button>
    </div>
    <div class="card-container">
        <?php
        $result = get_kegiatan($conn);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h3>' . $row['nama_kegiatan'] . '</h3>';
                echo '<p>' . $row['deskripsi'] . '</p>';
                echo '<p><strong>Waktu:</strong> ' . $row['waktu'] . '</p>';
                echo '<p><strong>Tempat:</strong> ' . $row['tempat'] . '</p>';
                echo '<div class="card-actions">
                        <a href="kegiatan.php?edit=' . $row['id'] . '">Edit</a> |
                        <a href="kegiatan.php?delete=' . $row['id'] . '">Hapus</a>
                      </div>';
                echo '</div>';
            }
        } else {
            echo '<p class="text-center">Tidak ada data kegiatan</p>';
        }
        ?>
    </div>
</div>

<div id="formModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 style="margin-top: 15px;"><?php echo isset($editData) ? 'Edit' : 'Tambah'; ?> Kegiatan</h2>
        <form id="kegiatanForm" method="post" action="kegiatan.php">
            <input type="hidden" name="action" value="<?php echo isset($editData) ? 'edit' : 'add'; ?>">
            <input type="hidden" name="id" value="<?php echo isset($editData) ? $editData['id'] : ''; ?>">
            <label for="nama_kegiatan">Nama Kegiatan:</label>
            <input type="text" id="nama_kegiatan" name="nama_kegiatan" value="<?php echo isset($editData) ? $editData['nama_kegiatan'] : ''; ?>" required>

            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required><?php echo isset($editData) ? $editData['deskripsi'] : ''; ?></textarea>

            <label for="waktu">Waktu:</label>
            <input type="datetime-local" id="waktu" name="waktu" value="<?php echo isset($editData) ? date('Y-m-d\TH:i', strtotime($editData['waktu'])) : ''; ?>" required>

            <label for="tempat">Tempat:</label>
            <input type="text" id="tempat" name="tempat" value="<?php echo isset($editData) ? $editData['tempat'] : ''; ?>" required>
            <button type="submit"><?php echo isset($editData) ? 'Ubah' : 'Simpan'; ?></button>
        </form>
    </div>
</div>

<script>
    var modal = document.getElementById("formModal");
    var btn = document.getElementById("openModal");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        document.getElementById('kegiatanForm').reset();
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

.card-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 250px;
    text-align: left;
}

.card h3 {
    margin-top: 0;
    font-size: 20px;
    color: #333;
}

.card p {
    color: #555;
    font-size: 14px;
    margin-bottom: 10px;
}

.card-actions {
    text-align: center;
    margin-top: 10px;
}

.card-actions a {
    text-decoration: none;
    color: #60EFFF;
    font-weight: bold;
    margin: 0 5px;
}

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
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
    border-radius: 8px;
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