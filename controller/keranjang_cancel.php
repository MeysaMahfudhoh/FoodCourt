<?php

session_start();
include 'koneksi.php';


if (isset($_GET['id_keranjang']) && !empty($_GET['id_keranjang']) && isset($_GET['type']) && !empty($_GET['type'])) {
    $id_keranjang = $conn->real_escape_string($_GET['id_keranjang']);
    $jenis =  $conn->real_escape_string($_GET['type']);
}

$update = "UPDATE keranjang SET status = 9 ,  jenis='$jenis'  WHERE id = $id_keranjang";
// $conn->query($update);

if ($conn->query($update) === TRUE) {
    $_SESSION['sukses'] = 'Pesanan Dibatalkan';
    header("Location: {$_SERVER['HTTP_REFERER']}");
} else {
    $_SESSION['error'] = 'Gagal';
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
