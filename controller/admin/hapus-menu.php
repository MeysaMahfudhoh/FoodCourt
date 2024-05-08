<?php
// Pastikan Anda telah memulai session jika diperlukan
session_start();

// Validasi apakah ID data dikirim melalui URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Database connection settings
    $host = 'localhost'; // Host name
    $dbUser = 'root';    // Database username
    $dbPassword = '';    // Database password
    $dbName = 'foodcourt'; // Database name

    // Create connection
    $conn = new mysqli($host, $dbUser, $dbPassword, $dbName);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape input untuk mencegah SQL injection
    $id = $conn->real_escape_string($_GET['id']);

    // Query SQL untuk menghapus data
    $sql = "DELETE FROM menu WHERE id = '$id'"; 
    if ($conn->query($sql) === TRUE) {
        $_SESSION['sukses'] = 'Menu Berhasil Dihapus';
        header('Location: ../../admin/data-menu.php');
        exit();
    } else {
        $_SESSION['error'] = 'Menu Gagal Dihapus';
        header('Location: ../../admin/data-menu.php');
    }

    // Tutup koneksi database
    $conn->close();
} else {
    $_SESSION['error'] = 'Gagal';
    header('Location: ../../admin/data-menu.php');
    exit();
}
