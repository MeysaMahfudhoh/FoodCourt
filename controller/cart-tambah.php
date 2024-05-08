<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    $conn->begin_transaction(); // Start transaction for better error handling
    try {
        // Fetch the menu details
        $stmt = $conn->prepare("SELECT harga_menu, id_user FROM menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception('Menu tidak ditemukan');
        }

        $menu = $result->fetch_assoc();
        $id_stand = $menu['id_user'];
        $harga_menu = $menu['harga_menu'];

        // Check if there's an existing cart for the user
        $stmt = $conn->prepare("SELECT id, id_stand FROM keranjang WHERE id_user = ? AND status = 1");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $keranjang = $result->fetch_assoc();

        if ($keranjang) {
            // If an existing cart is found, check if it belongs to the same stand
            if ($keranjang['id_stand'] != $id_stand) {
                // If the stand is different, delete the existing cart and its details
                $cart_id = $keranjang['id'];
                $stmt = $conn->prepare("DELETE FROM keranjang_detail WHERE id_keranjang = ?");
                $stmt->bind_param("i", $cart_id);
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM keranjang WHERE id = ?");
                $stmt->bind_param("i", $cart_id);
                $stmt->execute();

                // Create a new cart for the user
                $stmt = $conn->prepare("INSERT INTO keranjang (id_stand, id_user, total_item, total_harga, status) VALUES (?, ?, 0, 0, 1)");
                $stmt->bind_param("ii", $id_stand, $_SESSION['user_id']);
                $stmt->execute();
                $cart_id = $conn->insert_id;
            } else {


                // Get the ID of the cart
                $cart_id = $keranjang['id'];
            }
        } else {
            // If no existing cart is found, create a new one

            $stmt = $conn->prepare("INSERT INTO keranjang (id_stand, id_user, total_item, total_harga, status) VALUES (?, ?, 0, 0, 1)");
            $stmt->bind_param("ii", $id_stand, $_SESSION['user_id']);
            $stmt->execute();
            $cart_id = $conn->insert_id;
        }

        // Check if the menu item is already in the cart detail
        $stmt = $conn->prepare("SELECT id, jumlah, total FROM keranjang_detail WHERE id_keranjang = ? AND id_menu = ?");
        $stmt->bind_param("ii", $cart_id, $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $detail = $result->fetch_assoc();

        if ($detail) {
            // If the menu item is already in the cart, update its quantity and total price
            $new_jumlah = $detail['jumlah'] + 1;
            $new_total = $detail['total'] + $harga_menu;
            $stmt = $conn->prepare("UPDATE keranjang_detail SET jumlah = ?, total = ? WHERE id = ?");
            $stmt->bind_param("iii", $new_jumlah, $new_total, $detail['id']);
        } else {
            // If the menu item is not in the cart, add a new entry to the cart detail
            $new_jumlah = 1;
            $new_total = $harga_menu;
            $stmt = $conn->prepare("INSERT INTO keranjang_detail (id_keranjang, id_user, id_menu, jumlah, total, status) VALUES (?, ?, ?, ?, ?, 1)");
            $stmt->bind_param("iiiii", $cart_id, $_SESSION['user_id'], $id, $new_jumlah, $new_total);
        }
        $stmt->execute();

        // Update the cart totals
        $stmt = $conn->prepare("UPDATE keranjang SET total_item = total_item + 1, total_harga = total_harga + ? WHERE id = ?");
        $stmt->bind_param("ii", $harga_menu, $cart_id);
        $stmt->execute();

        $conn->commit(); // Commit the transaction
        $_SESSION['sukses'] = 'Menu berhasil ditambahkan ke keranjang';
    } catch (Exception $e) {
        $conn->rollback(); // Rollback on error
        $_SESSION['error'] = $e->getMessage();
    }

    $stmt->close();
    $conn->close();
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    $_SESSION['error'] = 'ID menu tidak valid';
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
