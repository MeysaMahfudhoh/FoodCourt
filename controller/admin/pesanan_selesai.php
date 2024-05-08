<?php
session_start();
include '../koneksi.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    var_dump($id);
    date_default_timezone_set('Asia/Jakarta');
    $tanggal = date('Y-m-d H:i:s');
    $sql = "UPDATE keranjang SET status = 5 , waktu_selesai ='$tanggal'  WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['sukses'] = 'Pesanan Selesai';
        header('Location: ../../admin/pesanan-selesai.php');
        // exit();
    } else {
        $_SESSION['error'] = ' Gagal ';
        header('Location: ../../admin/pesanan-selesai.php');
        // echo "Error updating record: " . $conn->error;
    }
}

// Tutup koneksi database
$conn->close();
