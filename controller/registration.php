<?php
session_start();
include 'koneksi.php';
$email = $_POST['email'];
$username = strstr($email, '@', true);
$password = $_POST['password'];
if ($stmt = $conn->prepare('SELECT id FROM user WHERE email = ?')) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = 'Email Sudah Ada';
        header('Location: ../register.php');
    } else {
        if ($stmt = $conn->prepare('INSERT INTO user (role, email, username, password) VALUES (?, ?, ?, ?)')) {
            $role = 'mahasiswa';
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssss', $role, $email, $username, $password_hashed);
            $stmt->execute();
            $_SESSION['sukses'] = 'Registrasi Berhasil';
            header('Location: ../login.php');
        } else {
            $_SESSION['error'] = 'Registrasi Gagal';
            header('Location: ../register.php');
        }
    }
    $stmt->close();
} else {
    $_SESSION['error'] = 'Registrasi Gagal';
    header('Location: ../register.php');
}
$conn->close();
