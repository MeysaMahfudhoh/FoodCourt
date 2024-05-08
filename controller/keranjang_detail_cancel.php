<?php

session_start();
include 'koneksi.php';


if (isset($_GET['id_detail']) && !empty($_GET['id_detail'])  && isset($_GET['detail_status']) && !empty($_GET['detail_status']) && isset($_GET['id_ker']) && !empty($_GET['id_ker']) && isset($_GET['harga']) && !empty($_GET['harga']) && isset($_GET['jumlah']) && !empty($_GET['jumlah'])) {
    $id_detail = $conn->real_escape_string($_GET['id_detail']);
    $status = $conn->real_escape_string($_GET['detail_status']);
    $id_ker = $conn->real_escape_string($_GET['id_ker']);
    $harga = $conn->real_escape_string($_GET['harga']);
    $jumlah = $conn->real_escape_string($_GET['jumlah']);
    var_dump($id_detail, $id_ker, $status, $harga, $jumlah);
    // var_dump($id_detail);
}

if ($status == 1) {
    $stmt = $conn->prepare("SELECT total_item, total_harga FROM keranjang WHERE id = ? ");
    $stmt->bind_param("i", $id_ker);
    $stmt->execute();
    $result = $stmt->get_result();
    $keranjang = $result->fetch_assoc();
    $totbar = $keranjang['total_item'] - $jumlah;
    $harbar = $keranjang['total_harga'] - $harga;

    $update = "UPDATE keranjang SET total_item = $totbar, total_harga = $harbar WHERE id = $id_ker";

    $update2 = "UPDATE keranjang_detail SET status = 9 WHERE id = $id_detail";
    $conn->query($update);
    $conn->query($update2);
} else {
    $stmt = $conn->prepare("SELECT total_item, total_harga FROM keranjang WHERE id = ? ");
    $stmt->bind_param("i", $id_ker);
    $stmt->execute();
    $result = $stmt->get_result();
    $keranjang = $result->fetch_assoc();
    $totbar = $keranjang['total_item'] + $jumlah;
    $harbar = $keranjang['total_harga'] + $harga;

    $update = "UPDATE keranjang SET total_item = $totbar, total_harga = $harbar WHERE id = $id_ker";

    $update2 = "UPDATE keranjang_detail SET status = 1 WHERE id = $id_detail";
    $conn->query($update);
    $conn->query($update2);
}
// // $conn->query($update);

// if ($conn->query($update) === TRUE) {
    $_SESSION['sukses'] = 'Pesanan Dibatalkan';
    header("Location: {$_SERVER['HTTP_REFERER']}");
// } else {
//     $_SESSION['error'] = 'Gagal';
//     header("Location: {$_SERVER['HTTP_REFERER']}");
// }
