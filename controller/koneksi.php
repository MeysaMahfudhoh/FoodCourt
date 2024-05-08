<?php
$servername = "localhost"; // Host server
$username = "root"; // Username database
$password = ""; // Password database
$dbname = "foodcourt"; // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("koneksi gagal. " . $conn->connect_error);
}
// $stmt = $conn->prepare($sql);
// if (!$stmt) {
//     die("Error saat menyiapkan pernyataan SQL: " . $conn->error);
// }
// echo "koneksi berhasil";
?>
