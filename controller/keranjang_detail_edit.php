<?php

session_start();
include 'koneksi.php';


if (isset($_GET['id_detail']) && !empty($_GET['id_detail'])  && isset($_GET['id_ker']) && !empty($_GET['id_ker']) && isset($_GET['aksi']) && !empty($_GET['aksi']) && isset($_GET['harga']) && !empty($_GET['harga'])) {
    $id_detail = $conn->real_escape_string($_GET['id_detail']);
    $id_ker = $conn->real_escape_string($_GET['id_ker']);
    $aksi = $conn->real_escape_string($_GET['aksi']);
    $harga = $conn->real_escape_string($_GET['harga']);
    var_dump($id_detail, $id_ker, $aksi, $harga);
}

if ($aksi == 'tambah') {
    $stmt = $conn->prepare("SELECT total_item, total_harga FROM keranjang WHERE id = ? ");
    $stmt->bind_param("i", $id_ker);
    $stmt->execute();
    $result = $stmt->get_result();
    $keranjang = $result->fetch_assoc();
    $totbar = $keranjang['total_item'] + 1;
    $harbar = $keranjang['total_harga'] + $harga;

    $update = "UPDATE keranjang SET total_item = $totbar, total_harga = $harbar WHERE id = $id_ker";

    $stmt = $conn->prepare("SELECT jumlah, total FROM keranjang_detail WHERE id = ? ");
    $stmt->bind_param("i", $id_detail);
    $stmt->execute();
    $result = $stmt->get_result();
    $detail = $result->fetch_assoc();
    $jumdet = $detail['jumlah'] + 1;
    $totdet = $detail['total'] + $harga;

    $update2 = "UPDATE keranjang_detail SET jumlah = $jumdet, total = $totdet WHERE id = $id_detail";
    $conn->query($update);
    $conn->query($update2);
} else {
    $stmt = $conn->prepare("SELECT total_item, total_harga FROM keranjang WHERE id = ? ");
    $stmt->bind_param("i", $id_ker);
    $stmt->execute();
    $result = $stmt->get_result();
    $keranjang = $result->fetch_assoc();
    if ($keranjang['total_item'] == 1) {
        $_SESSION['sukses'] = 'Item kurang dari 2';
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }
    $totbar = $keranjang['total_item'] - 1;
    $harbar = $keranjang['total_harga'] - $harga;

    $update = "UPDATE keranjang SET total_item = $totbar, total_harga = $harbar WHERE id = $id_ker";

    $stmt = $conn->prepare("SELECT jumlah, total FROM keranjang_detail WHERE id = ? ");
    $stmt->bind_param("i", $id_detail);
    $stmt->execute();
    $result = $stmt->get_result();
    $detail = $result->fetch_assoc();
    $jumdet = $detail['jumlah'] - 1;
    $totdet = $detail['total'] - $harga;

    $update2 = "UPDATE keranjang_detail SET jumlah = $jumdet, total = $totdet WHERE id = $id_detail";
    $conn->query($update);
    $conn->query($update2);
}
// // $conn->query($update);

// if ($conn->query($update) === TRUE) {
    $_SESSION['sukses'] = 'Pesanan Diubah';
    header("Location: {$_SERVER['HTTP_REFERER']}");
// } else {
//     $_SESSION['error'] = 'Gagal';
//     header("Location: {$_SERVER['HTTP_REFERER']}");
// }
