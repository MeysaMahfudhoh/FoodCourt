<?php
session_start();
include 'koneksi.php';

if (isset($_POST['cari']) && !empty($_POST['cari'])) {
    $cari = $_POST['cari'];
    $cari = $conn->real_escape_string($cari);
    $stmt = $conn->prepare('SELECT * FROM menu INNER JOIN user ON menu.id_user = user.id WHERE nama_menu LIKE ?');
    $searchTerm = "%" . $cari . "%";
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();

    // if ($stmt) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['url' => "pencarian.php?cari=" . $cari]);
    } else {
        echo json_encode(['error' => 'Hasil Tidak Ditemukan']);
    }
    // } else {
    // echo json_encode(['error' => "Query execution failed: " . $conn->error]);
    // }
    // $stmt->close();
} else {
    echo json_encode(['error' => 'Input is empty']);
}
$conn->close();
