<?php
session_start();
include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirim melalui form
    $id = $_POST['id'];
    $nama = $_POST['name'];
    $foto = $_FILES['image']['name'];
    $targetDir = "../../image/profile/";
    var_dump($nama);

    if (isset($foto) && !empty($foto)) {
        $upload_foto = "UPDATE user SET foto = '$foto' WHERE id = $id";
        $targetFile = $targetDir . basename($foto);
        move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
        $conn->query($upload_foto);
    }

    $sql = "UPDATE user SET username = '$nama' WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['sukses'] = 'Profil Berhasil Diubah';
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            $_SESSION['error'] = 'Profil Gagal Diubah';
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }

        // Tutup koneksi database
        $conn->close();
}
