<?php
include 'koneksi.php';

function get_ukm_by_id($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM ukm WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = get_ukm_by_id($conn, $_GET['edit']);
}

$success = false;
$error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $action = $_POST['action'];

    if ($action == 'add') {
        $stmt = $conn->prepare("INSERT INTO ukm (nama, deskripsi) VALUES (?, ?)");
        $stmt->bind_param("ss", $nama, $deskripsi);
    } elseif ($action == 'edit') {
        $stmt = $conn->prepare("UPDATE ukm SET nama=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("ssi", $nama, $deskripsi, $id);
    }
    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = true;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah UKM</title>
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
        .form-container input[type="tel"],
        .form-container textarea {
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
        <div class="title">Tambah UKM</div>
    </div>
    <div class="breadcrumb">
        <a href="ukm.php">UKM</a> > <a href="add_ukm.php" class="active">Tambah UKM</a>
    </div>
    <div style="margin-top: 50px;" class="form-container">
        <form action="add_ukm.php" method="post">
            <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
            <input type="text" name="nama" placeholder="Nama" value="<?php echo $editData['nama'] ?? ''; ?>" required>
            <textarea name="deskripsi" placeholder="Deskripsi" required><?php echo $editData['deskripsi'] ?? ''; ?></textarea>
            <button type="submit">Simpan</button>
        </form>
    </div>
    <div class="popup" id="popup">
        <div class="message">DATA SUKSES DITAMBAHKAN</div>
        <div class="sub-message">Silahkan kembali ke halaman utama <br> untuk melihat hasil data yang telah <br> ditambahkan</div>
        <div class="separator"></div>
        <div class="actions">
            <a href="ukm.php" class="nav-link">KEMBALI</a>
            <a style="color: grey; font-size:14px" href="add_ukm.php" class="nav-link2">TAMBAH DATA BARU</a>
        </div>
    </div>
    <div class="popup-fail" id="popup-fail">
        <div class="message-fail">DATA GAGAL DISIMPAN</div>
        <div class="sub-message-fail">Silahkan periksa internet anda dan coba <br> lagi untuk menambahkan data</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                if (<?php echo $success ? 'true' : 'false'; ?>) {
                    document.getElementById('popup').style.display = 'block';
                } else if (<?php echo $error ? 'true' : 'false'; ?>) {
                    document.getElementById('popup-fail').style.display = 'block';
                }
            <?php endif; ?>
        });
    </script>
</body>

</html>
