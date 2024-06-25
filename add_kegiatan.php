<?php
include 'koneksi.php';

function get_kegiatan_by_id($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM kegiatan WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$success = false;
$error = false;
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
    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = true;
    }
    $stmt->close();
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                if ($success) {
                    document.getElementById('popup').style.display = 'block';
                } else if ($error) {
                    document.getElementById('popup-fail').style.display = 'block';
                }
            });
          </script>";
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
            height: 220px;
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 10;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .popup .message {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: left;
            font-family: 'Segoe UI';
        }

        .popup .sub-message {
            font-family: 'Segoe UI';
            text-align: left;
            font-size: 16px;
            color: grey;
            margin-bottom: 20px;
        }

        .popup .actions a {
            display: inline-block;
            margin: 10px 5px;
            color: #000;
            text-decoration: none;
            font-weight: bold;
        }

        .actions {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .separator {
            height: 1px;
            background-color: #ccc;
            margin: 20px 0;
        }

        .nav-link {
            color: #000;
            font-family: 'Segoe UI';
            font-size: 16px;

        }

        .nav-link2 {
            font-family: 'Segoe UI';
        }

        /* Styling untuk popup gagal */
        .popup-fail {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 10;
            border-radius: 10px;
            text-align: center;
            max-width: 400px;
            width: 100%;
            border-left: 5px solid red;
            /* Garis tepi merah di sebelah kiri */
        }

        .message-fail {
            font-size: 20px;
            margin-bottom: 10px;
            font-weight: bold;
            color: red;
            text-align: left;
        }

        .sub-message-fail {
            font-size: 16px;
            color: grey;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="title">Tambah Kegiatan</div>
    </div>
    <div class="breadcrumb">
        <a href="kegiatan.php">Kegiatan</a> > <a href="add_kegiatan.php" class="active">Tambah Kegiatan</a>
    </div>
    <div style="margin-top: 50px;" class="form-container">
        <form action="add_kegiatan.php" method="post">
            <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
            <input type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" value="<?php echo $editData['nama_kegiatan'] ?? ''; ?>" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" value="<?php echo $editData['deskripsi'] ?? ''; ?>" required>
            <input type="text" name="waktu" placeholder="Waktu" value="<?php echo $editData['waktu'] ?? ''; ?>" required>
            <input type="text" name="tempat" placeholder="Tempat" value="<?php echo $editData['tempat'] ?? ''; ?>" required>
            <button type="submit">Simpan</button>
        </form>
    </div>
    <div class="popup" id="popup">
        <div class="message">DATA SUKSES DITAMBAHKAN</div>
        <div class="sub-message">Silahkan kembali ke halaman utama <br> untuk melihat hasil data yang telah <br> ditambahkan</div>
        <div class="separator"></div>
        <div class="actions">
            <a href="kegiatan.php" class="nav-link">KEMBALI</a>
            <a style="color: grey; font-size:14px" href="add_kegiatan.php" class="nav-link2">TAMBAH DATA BARU</a>
        </div>
    </div>
    <div class="popup-fail" id="popup-fail">
        <div class="message-fail">DATA GAGAL DISIMPAN</div>
        <div class="sub-message-fail">Silahkan periksa internet anda dan coba <br> lagi untuk menambahkan data</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (<?php echo isset($_POST['nama_kegiatan']) ? 'true' : 'false'; ?>) {
                if (<?php echo $success ? 'true' : 'false'; ?>) {
                    document.getElementById('popup').style.display = 'block';
                } else if (<?php echo $error ? 'true' : 'false'; ?>) {
                    document.getElementById('popup-fail').style.display = 'block';
                }
            }
        });
    </script>
</body>

</html>
