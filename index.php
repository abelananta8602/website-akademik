
<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: kenalan.php');
    exit;
} else {
    header('Location: home.php');
    exit;
}
?>
