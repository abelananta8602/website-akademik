<?php
include 'koneksi.php';

function get_jadwal_kuliah_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM matakuliah WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $namamatakuliah = $_POST['namamatakuliah'];
    $dosen = $_POST['dosen'];
    $jam = $_POST['jam'];
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO matakuliah (namamatakuliah, dosen, jam ) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $namamatakuliah, $dosen, $jam);
    } elseif ($action == 'edit') {
        $stmt = $conn->prepare("UPDATE matakuliah SET namamatakuliah=?, dosen=?, jam=? WHERE id=?");
        $stmt->bind_param("sssi", $namamatakuliah, $dosen, $jam, $id);
    }
    $stmt->execute();
    $stmt->close();
    header("Location: mata_kuliah.php");
}

$editData = null;
if (isset($_GET['id'])) {
    $editData = get_jadwal_kuliah_by_id($conn, $_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
            margin: 0;
        }
        .header {
            width: 100%;
            max-width: 800px;
            text-align: left;
            margin-top: 30px;
        }
        .header .title {
            font-size: 24px;
            font-weight: bold;
            text-align: left;
        }
        .breadcrumb {
            margin-top: 10px;
            width: 100%;
            max-width: 800px;
            text-align: left;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #333;
        }
        .breadcrumb a:hover,
        .breadcrumb a.active {
            color: #000;
            font-weight: bold;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            margin-top: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="tel"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            background-color: #E0E0E0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .form-container button {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-sizing: border-box;
        }
        .form-container button:hover {
            background-color: #333;
        }
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 10;
            border-radius: 10px;
        }
        .popup .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .popup .actions a {
            display: inline-block;
            margin-right: 10px;
            color: #000;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #f2f2f2;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        .popup .actions a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Edit Mata Kuliah</div>
    </div>
    <div class="breadcrumb">
        <a href="mata_kuliah.php">mata kuliah</a> > <a href="edit_mata_kuliah.php" class="active">Edit Mata Kuliah</a>
    </div>
    <div style="margin-top: 50px;" class="form-container">
    <form action="edit_mata_kuliah.php?id=<?php echo $editData['id'] ?? ''; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
            <input type="text" name="namamatakuliah" placeholder="Nama Mata Kuliah" value="<?php echo $editData['namamatakuliah'] ?? ''; ?>" required>
            <input type="text" name="dosen" placeholder="Dosen" value="<?php echo $editData['dosen'] ?? ''; ?>" required>
            <input type="text" name="jam" placeholder="Waktu Mulai" value="<?php echo $editData['jam'] ?? ''; ?>" required>
            <button type="submit">Simpan</button>
        </form>
    </div>
    <div class="popup" id="popup">
        <div class="message">DATA SUKSES DITAMBAHKAN</div>
        <div class="sub-message">Silahkan kembali ke halaman utama <br> untuk melihat hasil data yang telah <br> ditambahkan</div>
        <div class="separator"></div>
        <div class="actions">
            <a href="mata_kuliah.php" class="nav-link">KEMBALI</a>
            <a style="color: grey; font-size:14px" href="add_mata_kuliah.php" class="nav-link2">TAMBAH DATA BARU</a>
        </div>
    </div>

    <script>
         document.addEventListener('DOMContentLoaded', function() {
            if (<?php echo isset($_POST['nim']) ? 'true' : 'false'; ?>) {
                document.getElementById('popup').style.display = 'block';
            }
        });
    </script>
</body>

</html>
