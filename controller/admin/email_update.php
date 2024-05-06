<?php
session_start();
include '../koneksi.php';


// if (isset($_GET['id']) && !empty($_GET['id'])) {
//     $id = $conn->real_escape_string($_GET['id']);
// }

$id = $_POST['id'];
$email = $_POST['email'];
$password = $_POST['password'];
// var_dump($email,$password,$id);
// $level = $_POST['level'];

$password_hashed = password_hash($password, PASSWORD_DEFAULT);
$update = "UPDATE user SET email = ?,  password = ?  WHERE id = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("ssi", $email, $password_hashed, $id);
$stmt->execute();


if ($stmt->execute()) {
    $_SESSION['sukses'] = 'Email & Password Berhasil Dirubah';
    header("Location: {$_SERVER['HTTP_REFERER']}");
} else {
    $_SESSION['error'] = 'Email & Password Gagal Dirubah';
    header("Location: {$_SERVER['HTTP_REFERER']}");
}
