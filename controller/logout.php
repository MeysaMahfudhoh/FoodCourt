<?php
session_start();
session_destroy();
$_SESSION['sukses'] = 'Berhasil Logout';
header("Location: ../index.php");
exit();
