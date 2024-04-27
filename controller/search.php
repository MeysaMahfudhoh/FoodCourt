<?php
session_start();
include 'koneksi.php';

if (isset($_POST['cari']) && !empty($_POST['cari'])) {
    $cari = $_POST['cari'];
    $cari = $conn->real_escape_string($cari);
    $stmt = $conn->prepare('SELECT * FROM user WHERE nama_toko LIKE ?');
    $searchTerm = "%" . $cari . "%";
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();

    // if ($stmt) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['url' => "menu.php?stand=" . $row['id']]);
    } else {
        echo json_encode(['error' => 'No results found']);
    }
    // } else {
    // echo json_encode(['error' => "Query execution failed: " . $conn->error]);
    // }
    // $stmt->close();
} else {
    echo json_encode(['error' => 'Input is empty']);
}
$conn->close();
