<?php
session_start();
include 'controller/koneksi.php';



if (isset($_SESSION['user_id'])) {

    $id_user = $_SESSION['user_id'];
    $query =    "SELECT keranjang.id, user.username, keranjang.status, keranjang.waktu_konfirmasi, keranjang.waktu_antar, keranjang.waktu_selesai FROM keranjang 
                INNER JOIN user ON keranjang.id_stand = user.id
                where id_user = $id_user
                ORDER BY keranjang.id DESC
                LIMIT 1
                ";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $sql = "SELECT keranjang.id, keranjang_detail.id AS id_detail, menu.nama_menu, menu.harga_menu, menu.gambar_menu , keranjang_detail.jumlah, keranjang_detail.total, keranjang.status, keranjang.waktu_bayar
            FROM keranjang
            INNER JOIN keranjang_detail ON keranjang.id = keranjang_detail.id_keranjang
            INNER JOIN menu  ON keranjang_detail.id_menu = menu.id 
            WHERE keranjang_detail.id_user = ?
            AND keranjang.id = ?
            ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_user, $data['id']);
    $stmt->execute();
    $keranjang = $stmt->get_result();
    $stmt->close();
} else {
    $keranjang = null;
}

if ($keranjang->num_rows === 0) {
    $_SESSION['sukses'] = 'Buat Pesanan';
    header('Location: stand.php');
    }


?>
<!DOCTYPE html>
<html lang="en">
<style>
    :root {
        --main-color: #284990;
        --black-color: #252525;
        --border: 0.1rem solid rgba(255, 255, 255, 0.4);
    }

    body {
        background-color: var(--main-color);
    }
</style>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet" />
    <!-- CSS LINK -->
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Our Menu | FoodCourt UNESA</title>
</head>

<body style="background-color: #1714B6;">

    <div class="container mb-5">
        <div class="row">
            <div class="col">
                <h1 class="text-center text-white pt-2">
                    Rincian Pesananmu
                </h1>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row">
            <div class="col-4 d-flex justify-content-center">
                <div class="text-center">
                    <?php
                    if ($data['status'] < 3) {
                    ?>
                        <img src="./image/bulat2.svg" alt="" style="width: 50%;" />
                        <h3 class="text-white mt-3">Dibuat</h3>
                        <h3 class="text-white">---</h3>
                    <?php
                    } else {
                    ?>
                        <img src="./image/bulat1.svg" alt="" style="width: 50%;" />
                        <h3 class="text-white mt-3">Dibuat</h3>
                        <h3 class="text-white"><?php echo $data['waktu_konfirmasi'] ?></h3>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="col-4 d-flex justify-content-center">
                <div class="text-center">
                    <?php
                    if ($data['status'] < 4) {
                    ?>
                        <img src="./image/bulat2.svg" alt="" style="width: 50%;" />
                        <h3 class="text-white mt-3">Diantar</h3>
                        <h3 class="text-white">---</h3>
                    <?php
                    } else {
                    ?>
                        <img src="./image/bulat1.svg" alt="" style="width: 50%;" />
                        <h3 class="text-white mt-3">Diantar</h3>
                        <h3 class="text-white"><?php echo $data['waktu_antar'] ?></h3>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="col-4 d-flex justify-content-center">
                <div class="text-center">
                    <?php
                    if ($data['status'] < 5) {
                    ?>
                        <img src="./image/bulat2.svg" alt="" style="width: 50%;" />
                        <h3 class="text-white mt-3">Selesai</h3>
                        <h3 class="text-white">---</h3>
                    <?php
                    } else {
                    ?>
                        <img src="./image/bulat1.svg" alt="" style="width: 50%;" />
                        <h3 class="text-white mt-3">Selesai</h3>
                        <h3 class="text-white"><?php echo $data['waktu_antar'] ?></h3>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <form action="controller/keranjang.php">
        <div class="container mb-5">
            <div class="row">
                <div class="col-auto mr-auto">
                    <h2 class="text-white"><?php echo $data['username'] ?></h2>
                </div>
            </div>
            <?php
            $total_belanja = 0;
            if ($keranjang->num_rows > 0) {
                while ($row2 = $keranjang->fetch_array()) {
                    $total_belanja += $row2['total'];
            ?>
                    <div class="row">
                        <div class="col-4 d-flex justify-content-center">
                            <div class="rounded">
                                <img src="image/menu/<?php echo $row2['gambar_menu'] ?>" style="width: 90%;" alt="menu" />
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-center">
                            <h3 class="text-white"><?php echo $row2['nama_menu'] ?></h3>
                            <input type="hidden" name="nama" value="<?php echo $row2['nama_menu'] ?>">
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            <h3 style="color: #359DE8;"><?php echo $row2['harga_menu'] ?></h3>
                            <input type="hidden" name="harga" value="<?php echo $row2['harga_menu'] ?>">

                        </div>
                    </div>
                <?php
                }
            } else {
                ?>
                <h1>tidak ada keranjang</h1>
            <?php
            }
            ?>
        </div>

        <div class="container mb-5">
            <div class="row">
                <div class="col-4">
                    <h3 class="text-white">Subtotal</h3>
                </div>
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-end">
                    <h3 style="color: #359DE8;">Rp. <?php echo number_format($total_belanja, 0, ',', '.') ?></h3>
                    <input type="hidden" name="amount" value="<?php echo $total_belanja ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <h3 class="text-white">Order</h3>
                </div>
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-end">
                    <h3 style="color: #359DE8;">Dine In</h3>
                    <input type="hidden" name="jenis" value="Dine In">
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <h3 class="text-white">Waktu Pemesanan</h3>
                </div>
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-end">

                    <h3 style="color: #359DE8;">
                        <?php
                        echo date("d M Y");

                        ?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <h3 class="text-white">Nomor Kursi</h3>
                </div>
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-end">
                    <h3 style="color: #359DE8;"><?php echo $data['id'] ?></h3>
                    <input type="hidden" name="meja" value="<?php echo $data['id'] ?>">
                </div>
            </div>
        </div>

    </form>
    <div class="container mb-5">
        <div class="row">
            <div class="col text-center">
                <?php
                if ($data['status'] < 3) {
                ?>
                    <a target="_blank" href="controller/keranjang.php?id_keranjang=<?php echo $data['id'] ?>">

                        <button class="btn btn-primary font-weight-bold" style="background-color: white; color: #1714B6; width: 200px; ">Bayar Sekarang</button>
                    </a>

                <?php
                } else {
                ?>
                    <a href="index.php">

                        <button class="btn btn-primary font-weight-bold" style="background-color: white; color: #1714B6; width: 200px; ">Kembali</button>
                    </a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>


</html>