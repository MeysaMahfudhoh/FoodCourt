<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['id_keranjang']) && !empty($_GET['id_keranjang']) && isset($_GET['harga']) && !empty($_GET['harga'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $id_keranjang = $conn->real_escape_string($_GET['id_keranjang']);
    $harga = $conn->real_escape_string($_GET['harga']);

    $sql1 = "SELECT * FROM keranjang WHERE id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $id_keranjang);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hargabaru = $row['total_harga'] - $harga;
        $itembaru = $row['total_item'] - 1;
        $sql5 = "UPDATE keranjang SET total_item = '$itembaru', total_harga = '$hargabaru' WHERE id = $id_keranjang";
        $stmt5 = $conn->query($sql5);
        //     $sql1 = "SELECT * FROM keranjang_detail WHERE id = ?";
        //     $stmt = $conn->prepare($sql1);
        //     $stmt->bind_param("i", $id_keranjang);
        //     $stmt->execute();
        //     $result = $stmt->get_result();
    }
    // var_dump($harga);

    $sql = "DELETE FROM keranjang_detail WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['sukses'] = 'Keranjang Berhasil Dihapus';
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        $_SESSION['error'] = 'Keranjang Gagal Dihapus';
        header("Location: {$_SERVER['HTTP_REFERER']}");
        // header('Location: ../stand.php');
    }


    $conn->close();
} else {
    $_SESSION['error'] = 'ID menu tidak valid';
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
