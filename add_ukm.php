<?php
include 'koneksi.php';

$id = $nama = $deskripsi = '';
$action = 'add';

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM ukm WHERE id='$id'");
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
    $deskripsi = $row['deskripsi'];
    $action = 'edit';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];

    if ($_POST['action'] == 'add') {
        $sql = "INSERT INTO ukm (nama, deskripsi) VALUES ('$nama', '$deskripsi')";
    } elseif ($_POST['action'] == 'edit') {
        $sql = "UPDATE ukm SET nama='$nama', deskripsi='$deskripsi' WHERE id='$id'";
    }
    $conn->query($sql);
    header("Location: ukm.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $action == 'add' ? 'Tambah UKM' : 'Edit UKM'; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center"><?php echo $action == 'add' ? 'Tambah UKM' : 'Edit UKM'; ?></h1>
        <form method="post">
            <input type="hidden" name="action" value="<?php echo $action; ?>">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="nama">Nama UKM:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>
            <label for="deskripsi">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" required><?php echo $deskripsi; ?></textarea>
            <button type="submit">Simpan</button>
        </form>
    </div>
</body>
</html>
