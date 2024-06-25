<?php
include 'koneksi.php';

function get_ukm_by_id($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM ukm WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

$editData = null;
if (isset($_GET['id'])) {
    $editData = get_ukm_by_id($conn, $_GET['id']);
}

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
    $stmt->execute();
    $stmt->close();

    // Redirect ke halaman main.php setelah data berhasil disimpan atau diperbarui
    header("Location: ukm.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit UKM</title>
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
        <div class="title">Edit UKM</div>
    </div>
    <div class="breadcrumb">
        <a href="ukm.php">UKM</a> > <a href="edit_ukm.php?id=<?php echo $_GET['id']; ?>" class="active">Edit UKM</a>
    </div>
    <div style="margin-top: 100px;" class="form-container">
        <form action="edit_ukm.php?id=<?php echo $editData['id'] ?? ''; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">
            <input type="hidden" name="action" value="<?php echo $editData ? 'edit' : 'add'; ?>">
            <input type="text" name="nama" placeholder="Nama" value="<?php echo $editData['nama'] ?? ''; ?>" required>
            <input style="height: 180px;" type="text" name="deskripsi" placeholder="Deskripsi" value="<?php echo $editData['deskripsi'] ?? ''; ?>" required>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
