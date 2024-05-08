<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirim melalui form
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    // Lakukan validasi data jika diperlukan

    // Lakukan koneksi ke database
    $conn = new mysqli('localhost', 'root', '', 'foodcourt');

    // Check koneksi
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query SQL untuk update data
    $sql = "UPDATE menu SET nama_menu = '$nama', harga_menu = '$harga' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['sukses'] = 'Menu Berhasil Diubah';
        header('Location: ../../admin/data-menu.php');
        exit();
    } else {
        $_SESSION['error'] = 'Menu Gagal Diubah';
        header('Location: ../../admin/data-menu.php');
        // echo "Error updating record: " . $conn->error;
    }

    // Tutup koneksi database
    $conn->close();
}
