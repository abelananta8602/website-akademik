<?php
include 'koneksi.php';

function get_matakuliah($conn)
{
    $sql = "SELECT * FROM matakuliah";
    $result = $conn->query($sql);
    return $result;
}

if (isset($_GET['delete'])) {
    $ids = explode(',', $_GET['delete']);
    foreach ($ids as $id) {
        $stmt = $conn->prepare("DELETE FROM matakuliah WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: mata_kuliah.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Akademik</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'components/sidebar.php'; ?>
    <h3 style="font-family:merriweather; font-weight:bold;margin-top:30px; margin-left:350px">MATA KULIAH</h3>
    <div id="main" class="container mt-5">
        <div class="controls mb-3">
            <button id="delete-btn" class="btn btn-danger" style="display: none; margin-right: 10px;" onclick="deleteSelected()">Hapus Data</button>
            <?php
            $result = get_matakuliah($conn);
            if ($result->num_rows > 0) {
                echo "<button onclick=\"window.location.href='add_mata_kuliah.php'\" class=\"btn btn-tambah-data\">Tambah Data</button>";
            }
            ?>
        </div>

        <?php
        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead><tr><th scope="col"><input type="checkbox" id="select-all"></th><th scope="col">Nama Mata Kuliah</th><th scope="col">Dosen</th><th scope="col">Jam Mulai</th><th scope="col">Actions</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='checkbox' class='select-checkbox' data-id='{$row['id']}'></td>";
                echo "<td>{$row['namamatakuliah']}</td>";
                echo "<td>{$row['dosen']}</td>";
                echo "<td>{$row['jam']}</td>";
                echo "<td><a href='edit_mata_kuliah.php?id={$row['id']}' class='edit-link'>Edit</a></td>";
                echo "</tr>";
            }
            echo '</tbody></table>';
        } else {
            echo "<div class='empty-data'>
            <div class='left-content'>
                <h2>MAAF KAMI TIDAK DAPAT <br> MENEMUKAN DATA <br> APAPUN DISINI</h2>
                <button onclick=\"window.location.href='add_mata_kuliah.php'\" class='btn btn-tambah-data'>TAMBAH DATA</button>
            </div>
            <div class='right-content'>
                <p>admin bisa memulai menambahkan <br> data melalui tombol dibawah</p>
            </div>
          </div>";
        }
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">HAPUS DATA</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Apakah anda ingin menghapus data yang anda pilih?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">TIDAK</button>
            <button type="button" class="btn btn-primary" id="confirmDeleteBtn">YA</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.select-checkbox');
            const deleteBtn = document.getElementById('delete-btn');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const selectAll = document.getElementById('select-all');

            let selectedIds = [];

            selectAll.addEventListener('change', function() {
                const isChecked = selectAll.checked;
                checkboxes.forEach(checkbox => {
                    checkbox.checked = isChecked;
                    const id = checkbox.getAttribute('data-id');
                    if (isChecked && !selectedIds.includes(id)) {
                        selectedIds.push(id);
                    } else if (!isChecked && selectedIds.includes(id)) {
                        selectedIds = selectedIds.filter(selectedId => selectedId !== id);
                    }
                });
                deleteBtn.style.display = selectedIds.length > 0 ? 'inline-block' : 'none';
            });

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const id = checkbox.getAttribute('data-id');
                    if (checkbox.checked) {
                        if (!selectedIds.includes(id)) {
                            selectedIds.push(id);
                        }
                    } else {
                        selectedIds = selectedIds.filter(selectedId => selectedId !== id);
                    }
                    deleteBtn.style.display = selectedIds.length > 0 ? 'inline-block' : 'none';
                });
            });

            deleteBtn.addEventListener('click', function() {
                $('#confirmDeleteModal').modal('show');
            });

            confirmDeleteBtn.addEventListener('click', function() {
                if (selectedIds.length > 0) {
                    window.location.href = 'mata_kuliah.php?delete=' + selectedIds.join(',');
                }
            });
        });
    </script>
</body>

</html>

<style>
    .empty-data {
        display: flex;
        justify-content: space-between;
        height: 580px;
        padding: 0;
        background-color: #fff;
        border: none;
        margin-top: 20px;
        background-image: url('image/elips.png');
        background-size: 100% 25%;
        background-position: bottom;
        background-repeat: no-repeat;
        box-sizing: border-box;
    }

    .left-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding-left: 40px;
    }

    .right-content {
        text-align: right;
        color: grey;
        padding-right: 40px;
    }

    .empty-data h2 {
        margin-bottom: 20px;
    }

    .btn:hover {
        background-color: #0D0C22;
    }

    .btn:active {
        background-color: #292751;
    }

    .btn-secondary[disabled] {
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    body {
        font-family: "Lato", sans-serif;
        background-color: #f4f4f4;
    }

    .btn {
        color: white;
        background-color: #0D0C22;
        border: none;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-tambah-data {
        color: white;
        background-color: #0D0C22;
    }

    .btn-danger {
        color: white;
        background-color: red;
        border: none;
        cursor: pointer;
    }

    .btn-danger:hover {
        background-color: darkred;
    }

    #main {
        margin-left: 340px;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: calc(100% - 360px);
    }

    .page-title {
        color: #333;
        margin-bottom: 20px;
    }

    .controls button {
        margin-right: 10px;
    }

    .table {
        width: 100%;
        margin-top: 20px;
    }

    .table th,
    .table td {
        vertical-align: middle;
        padding: 8px;
        border-bottom: 1px solid #ccc;
    }

    .edit-link {
        color: #007bff;
        text-decoration: none;
    }

    .edit-link:hover {
        text-decoration: underline;
    }

    .select-checkbox {
        cursor: pointer;
    }

    .controls {
        text-align: right;
        margin-bottom: 20px;
    }

    .alert-warning {
        color: #856404;
        background-color: #fff3cd;
        border-color: #ffeeba;
    }

    .modal-dialog {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 1rem);
    }

    .modal-content {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #fff;
        border-bottom: none;
    }

    .modal-footer {
        border-top: none;
    }

    .modal-title {
        color: #333;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #0D0C22;
        border: none;
    }

    .btn-secondary {
        color: #333;
        background-color: #f4f4f4;
        border: 1px solid #ccc;
    }
</style>
