<?php
session_start();
include 'koneksi.php'; // Sambungkan ke database

// Mendapatkan nilai dari form
$email = $_POST['email'];
$password = $_POST['password'];
// var_dump($email);

// Cek jika username sudah ada
if ($stmt = $conn->prepare('SELECT id FROM user WHERE email = ?')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        // Username sudah ada
        // echo "Username sudah digunakan, silakan pilih username lain.";
        $_SESSION['error'] = 'Email Sudah Ada';
        header('Location: ../register.php');
    } else {
        // Username tersedia, lanjutkan proses pendaftaran
        if ($stmt = $conn->prepare('INSERT INTO user (role, email, password) VALUES (?, ?, ?)')) {
            $role = 'mahasiswa';
            // Menggunakan password_hash() untuk mengenkripsi password sebelum disimpan di database
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('sss', $role, $email, $password_hashed);
            $stmt->execute();
            // echo "Pendaftaran berhasil! Silakan <a href='login.php'>login</a>.";
            $_SESSION['sukses'] = 'Registrasi Berhasil';
            header('Location: ../login.php');
        } else {
            // Terjadi kesalahan saat menyimpan data
            // echo "Terjadi kesalahan saat pendaftaran.";
            $_SESSION['error'] = 'Registrasi Gagal';
            header('Location: ../register.php');
        }
    }
    $stmt->close();
} else {
    // Terjadi kesalahan dengan database atau query
    // echo "Terjadi kesalahan.";
    $_SESSION['error'] = 'Registrasi Gagal';
    header('Location: ../register.php');
}
$conn->close();
