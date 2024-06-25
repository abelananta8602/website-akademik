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

    // Redirect ke halaman kegiatan.php setelah data berhasil disimpan atau diupdate
    header("Location: kegiatan.php");
    exit();
}

$editData = null;
if (isset($_GET['id'])) {
    $editData = get_kegiatan_by_id($conn, $_GET['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kegiatan</title>
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
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Edit Kegiatan</div>
    </div>
    <div class="breadcrumb">
        <a href="kegiatan.php">Kegiatan</a> > <a href="edit_kegiatan.php?id=<?php echo $_GET['id']; ?>" class="active">Edit Kegiatan</a>
    </div>
    <div style="margin-top: 50px;" class="form-container">
        <form action="edit_kegiatan.php" method="post">
            <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
            <input type="text" name="nama_kegiatan" placeholder="Nama Kegiatan" value="<?php echo $editData['nama_kegiatan'] ?? ''; ?>" required>
            <input type="text" name="deskripsi" placeholder="Deskripsi" value="<?php echo $editData['deskripsi'] ?? ''; ?>" required>
            <input type="text" name="waktu" placeholder="Waktu" value="<?php echo $editData['waktu'] ?? ''; ?>" required>
            <input type="text" name="tempat" placeholder="Tempat" value="<?php echo $editData['tempat'] ?? ''; ?>" required>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
