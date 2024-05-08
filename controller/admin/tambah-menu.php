<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $status = 1;
    $gambar = $_FILES['gambar']['name'];
    $targetDir = "../../image/menu/";

    // Query SQL untuk menyimpan data menu baru
    $sql = "INSERT INTO menu (id_user, nama_menu, harga_menu, status, gambar_menu) VALUES (?, ?, ?, ?, ?)";
    
    // Persiapan pernyataan
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error saat menyiapkan pernyataan SQL: " . $conn->error);
    }

    // Bind parameter ke pernyataan
    $stmt->bind_param("sssis", $_SESSION['user_id'], $nama, $harga, $status, $gambar);

    // Coba untuk unggah file gambar
    $targetFile = $targetDir . basename($gambar);
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
        // File berhasil diunggah, lanjutkan dengan eksekusi query SQL
        if ($stmt->execute()) {
            $_SESSION['sukses'] = 'Menu Berhasil Ditambah';
        } else {
            $_SESSION['error'] = 'Menu Gagal Ditambah';
        }
    } else {
        $_SESSION['error'] = 'Gagal mengunggah gambar';
    }
    
    // Tutup pernyataan
    $stmt->close();
} else {
    // Jika bukan metode POST, redirect kembali ke halaman sebelumnya
    $_SESSION['error'] = 'Metode tidak diizinkan';
}

// Redirect kembali ke halaman sebelumnya
header('Location: ../../admin/data-menu.php');
exit();
?>
