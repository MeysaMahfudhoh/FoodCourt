<?php

if (isset($_SESSION['user_id'])) {
    // Mendapatkan id pengguna dari session
    $id_user = $_SESSION['user_id'];

    // Query SQL untuk mendapatkan data keranjang berdasarkan id pengguna
    $sql = "SELECT  keranjang.id AS id_ker, keranjang.status, keranjang_detail.id_keranjang ,keranjang_detail.id , menu.nama_menu, menu.harga_menu, menu.gambar_menu , keranjang_detail.jumlah, keranjang_detail.total, keranjang_detail.id_keranjang 
            FROM keranjang_detail 
            INNER JOIN keranjang ON keranjang.id = keranjang_detail.id_keranjang
            INNER JOIN menu  ON keranjang_detail.id_menu = menu.id 
            WHERE keranjang_detail.id_user = ? AND keranjang.status = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $keranjang = $stmt->get_result();
    // var
    // Tutup statement dan koneksi database
    $stmt->close();
    // $conn->close();
} else {
    // Jika pengguna belum login, redirect ke halaman login
    // header('Location: ../.php');
    $keranjang = null;
    // exit();
}
