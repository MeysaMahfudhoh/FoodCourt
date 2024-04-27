<?php
session_start();
include '../koneksi.php';
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $waktu = $_POST['meeting-time'];
    if ($waktu == null) {
        $_SESSION['error'] = 'Masukkan Waktu Perkiraan';
        header('Location: ../../admin/konfirmasi-pesanan.php');
    } else {


        $sql = "UPDATE keranjang SET status = 2 , perkiraan_waktu ='$waktu'  WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['sukses'] = 'Pesanan Berhasil Diterima';
            header('Location: ../../admin/konfirmasi-pesanan.php');
            //     // exit();
        } else {
            $_SESSION['error'] = 'Pesanan Gagal Diterima';
            header('Location: ../../admin/konfirmasi-pesanan.php');
            //     // echo "Error updating record: " . $conn->error;
        }
    }
}

// Tutup koneksi database
$conn->close();
