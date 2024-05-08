<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $sql = "SELECT * FROM menu WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $sql3 = "SELECT * FROM keranjang WHERE id_user = ? AND status = 1";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param("i", $_SESSION['user_id']);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        $jumlah = 1;
        $status = 1;
        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_assoc();
            $hargabaru = $row3['total_harga'] + $row['harga_menu'] ;
            $itembaru = $row3['total_item']+1;
            $ids =  $row3['id'];
            $sql5 = "UPDATE keranjang SET total_item = '$itembaru', total_harga = '$hargabaru' WHERE id = $ids";
            $stmt5 = $conn->query($sql5);
            // if($stmt5 === true){
            //     var_dump(true);
            // }
            


            // var_dump(true);
            // $jumlah = 1;
            // $total = $row['harga_menu'] * $jumlah;
            // $status = 1;
            // $sql2 = "INSERT INTO keranjang_detail (id_menu, id_user, jumlah, total, status) VALUES (?, ?, ?, ?, ?)";
            // $stmt2 = $conn->prepare($sql2);
            // $stmt2->bind_param("iiiii", $id, $_SESSION['user_id'], $jumlah, $total, $status);

            // if ($stmt2->execute()) {
            //     $_SESSION['sukses'] = 'Menu Berhasil Ditambah';
            //     header("Location: {$_SERVER['HTTP_REFERER']}");
            //     exit();
            // } else {
            //     $_SESSION['error'] = 'Menu Gagal Ditambah';
            //     header("Location: {$_SERVER['HTTP_REFERER']}");
            // }
            $total = $row['harga_menu'] * $jumlah;
            $sql2 = "INSERT INTO keranjang_detail (id_menu, id_user, id_keranjang, jumlah, total, status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("iiiiii", $id, $_SESSION['user_id'], $ids, $jumlah, $total, $status);
        } else {
            $sql4 = "INSERT INTO keranjang (id_stand, id_user, total_item, total_harga, status) VALUES (?, ?, ?, ?, ?)";
            $stmt4 = $conn->prepare($sql4);
            $stmt4->bind_param("iiiii", $row['id_user'], $_SESSION['user_id'], $jumlah, $row['harga_menu'], $status);
            $stmt4->execute();
            $last_insert_id = $conn->insert_id;
            // $result4 = $stmt4->get_result();
            // if (!$stmt4) {
            //     die("Error saat menyiapkan pernyataan SQL: " . $conn->error);
            // }


            // var_dump(false);
            $total = $row['harga_menu'] * $jumlah;
            $sql2 = "INSERT INTO keranjang_detail (id_menu, id_user, id_keranjang, jumlah, total, status) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("iiiiii", $id, $_SESSION['user_id'], $last_insert_id, $jumlah, $total, $status);
        }



        if ($stmt2->execute()) {
            $_SESSION['sukses'] = 'Menu Berhasil Ditambah';
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            $_SESSION['error'] = 'Menu Gagal Ditambah';
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }
    } else {
        $_SESSION['error'] = 'Menu tidak ditemukan';
        header("Location: {$_SERVER['HTTP_REFERER']}");
    }

    $stmt->close();
    $stmt2->close();
    $conn->close();
} else {
    $_SESSION['error'] = 'ID menu tidak valid';
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
