<?php
session_start();
include '../koneksi.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    var_dump($id);
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d H:i:s');
    $sql = "UPDATE keranjang SET status = 4 , waktu_antar ='$tanggal'  WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['sukses'] = 'Pesanan Berhasil Diantar';
        header('Location: ../../admin/konfirmasi-pesanan.php');
        // exit();
    } else {
        $_SESSION['error'] = 'Pesanan Gagal Diantar';
        header('Location: ../../admin/konfirmasi-pesanan.php');
        // echo "Error updating record: " . $conn->error;
    }
}

// Tutup koneksi database
$conn->close();