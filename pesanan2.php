<?php
session_start();
include 'controller/koneksi.php';


if (isset($_GET['type']) && !empty($_GET['type'])) {
    $type = $conn->real_escape_string($_GET['type']);
}
if (isset($_GET['meja']) && !empty($_GET['meja'])) {
    $meja = $conn->real_escape_string($_GET['meja']);
} else {
    $meja = 0;
}
// var_dump($type,$orang);

if (isset($_SESSION['user_id'])) {

    $id_user = $_SESSION['user_id'];
    // cek ketersediaan keranjang daari user
    $query =    "SELECT keranjang.id, user.username, user.nama_toko, keranjang.status, keranjang.waktu_konfirmasi, 
                keranjang.waktu_antar, keranjang.waktu_selesai,keranjang.perkiraan_waktu, keranjang.waktu_batal, keranjang.waktu_pesan, keranjang.jenis, keranjang.total_harga
                FROM keranjang 
                INNER JOIN user ON keranjang.id_stand = user.id
                where id_user = $id_user
                ORDER BY keranjang.id DESC
                LIMIT 1
                ";

    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    $id =  $data['id'];
    $wakkktu = $data['waktu_batal'];
    $waktu_pesan = $data['waktu_pesan'];
    $total_harga = $data['total_harga'];
    if (!isset($type) && !isset($meja)) {
        $type = $data['jenis'];
        $meja = 0;
    }

    if (!isset($waktu_pesan)) {
        //update keranjang jika baru checkout
        date_default_timezone_set('Asia/Jakarta');
        $currentDateTime = date('Y-m-d H:i:s');
        $newDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . ' +10 minutes'));
        $update = "UPDATE keranjang SET  meja='$meja', jenis = '$type', waktu_batal='$newDateTime', waktu_pesan='$currentDateTime' WHERE id =  $id ";
        $conn->query($update);
    }

    //menampilkan keranjang dan detail keranjang
    $sql = "SELECT keranjang.id, keranjang_detail.id AS id_detail, menu.nama_menu, menu.harga_menu, menu.gambar_menu , keranjang_detail.jumlah, keranjang_detail.total, keranjang.status, keranjang.waktu_bayar, keranjang_detail.status
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

    //menampilkan detail keranjang
    $sql2 = "SELECT keranjang_detail.id_menu, keranjang_detail.id_keranjang, keranjang_detail.jumlah, keranjang_detail.total, keranjang_detail.status, menu.nama_menu
    FROM keranjang_detail
    INNER JOIN menu on keranjang_detail.id_menu = menu.id
    WHERE id_keranjang = ? AND keranjang_detail.status = 1 ";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $data['id']);
    $stmt2->execute();
    $detail = $stmt2->get_result();

    //menapilkan meja id paling tinggi
    // $sql4 = "SELECT * FROM meja ORDER BY id DESC LIMIT 1";
    // $result2 = mysqli_query($conn, $sql4);
    // $meja = mysqli_fetch_assoc($result2);
    // $id_meja_detail =  $meja['id_meja_detail'] + 1;
    // $id2 = $meja['id_keranjang'];

    //insert meja
    // if ($id2 !== $id) {
    // var_dump(true, $id, $id2);
    // $sql3 = "INSERT INTO meja (id_keranjang, id_meja_detail) VALUES (?,?)";
    // $stmt3 = $conn->prepare($sql3);
    // for ($i = 0; $i < $orang; $i++) {
    //     $id_meja_detail_current = $id_meja_detail + $i;
    //     $stmt3->bind_param("ii", $id, $id_meja_detail_current);
    //     $stmt3->execute();
    // }
    // } 
    // else {
    // var_dump(false);
    // }

    //menampilkan meja berdasarkan nomer keranjang
    // $sql5 = "SELECT *  FROM meja
    // INNER JOIN meja_detail ON meja.id_meja_detail = meja_detail.id
    // WHERE id_keranjang = ?
    // ";
    // $stmt4 = $conn->prepare($sql5);
    // $stmt4->bind_param("i", $id);
    // $stmt4->execute();
    // $mejakursi = $stmt4->get_result();



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
    /* Ukuran teks default untuk headings dan paragraphs */
    h1 {
        font-size: 2.5rem !important;
    }

    /* 40px */
    h2 {
        font-size: 2rem !important;
    }

    /* 32px */
    h3 {
        font-size: 1.75rem !important;
    }

    /* 28px */
    h4 {
        font-size: 1.5rem !important;
    }

    /* 24px */
    h5 {
        font-size: 1.25rem !important;
    }

    /* 20px */
    h6 {
        font-size: 1.25rem !important;
    }

    /* 16px */
    p {
        font-size: 1rem !important;
    }

    /* 16px */

    /* Ukuran teks untuk layar medium (kurang dari 992px) */
    @media (max-width: 992px) {
        h1 {
            font-size: 2rem !important;
        }

        /* 32px */
        h2 {
            font-size: 1.75rem !important;
        }

        /* 28px */
        h3 {
            font-size: 1.5rem !important;
        }

        /* 24px */
        h4 {
            font-size: 1.25rem !important;
        }

        /* 20px */
        h5 {
            font-size: 1rem !important;
        }

        /* 16px */
        h6 {
            font-size: 0.875rem !important;
        }

        /* 14px */
        p {
            font-size: 0.875rem !important;
        }

        /* 14px */
    }

    /* Ukuran teks untuk layar kecil (kurang dari 768px) */
    @media (max-width: 768px) {
        h1 {
            font-size: 1.75rem !important;
        }

        /* 28px */
        h2 {
            font-size: 1.5rem !important;
        }

        /* 24px */
        h3 {
            font-size: 1.25rem !important;
        }

        /* 20px */
        h4 {
            font-size: 1rem !important;
        }

        /* 16px */
        h5 {
            font-size: 0.875rem !important;
        }

        /* 14px */
        h6 {
            font-size: 0.75rem !important;
        }

        /* 12px */
        p {
            font-size: 0.75rem !important;
        }

        /* 12px */
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
    <title>Pesanan Kamu | FoodCourt UNESA</title>
</head>

<body style="background-color: #ffffff;">
    <div class="container-fluid p-0" style="background-color:#1714B6">
        <div class="row">
            <div class="col-sm-4 col-md-7 col-lg-7 ">
                <div class="card m-3">
                    <div class="card-body" style="background-color: #ffffff; border-radius:12px">
                        <?php
                        if ($data['status'] > 1 && $data['status'] < 9) {
                        ?>
                            <div class="row mt-3">
                                <div class="col-12  d-flex justify-content-center">
                                    <div class="card" style="background-color: transparant; border: 2px solid rgba(0, 0, 0, 1 ); border-radius: 35px;">
                                        <div class="card-body" style="padding: 10px 30px;">
                                            <p class="m-0 p-0">
                                                <i class="fas fa-clock pr-2"></i> Perkiraan pesanan
                                                <?php
                                                if ($type === "dine_in") {
                                                ?>
                                                    diantar
                                                <?php } else { ?>
                                                    diambil
                                                <?php } ?>
                                                : <?php echo date("H:i", strtotime($data['perkiraan_waktu']))  ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="row mt-3">
                            <div class="col mb-3 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <?php
                                    if ($data['status'] == 9) {
                                    ?>
                                        <img src="./image/bulat3.svg" alt="" style="width: 60%;" />
                                        <h6 class="">Dibuat</h6>
                                        <h6 class="">---</h6>
                                    <?php } else { ?>

                                        <?php
                                        if ($data['status'] < 3) {
                                        ?>
                                            <img src="./image/bulat4.svg" alt="" style="width: 60%;" />
                                            <h6 class="">Dibuat</h6>
                                            <h6 class="">---</h6>
                                        <?php
                                        } else {
                                        ?>
                                            <img src="./image/bulat5.svg" alt="" style="width: 60%;" />
                                            <h6 class="">Dibuat</h6>
                                            <h6 class=""><?php echo date("H:i", strtotime($data['waktu_konfirmasi'])) ?></h6>

                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="col d-flex align-items-center justify-content-center">
                                <div class="text-center mx-auto pb-5">
                                    <img src="./image/garis.svg" class="img-fluid " alt="" />
                                </div>
                            </div>

                            <div class="col mb-3 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <?php
                                    if ($data['status'] == 9) {
                                    ?>
                                        <img src="./image/bulat3.svg" alt="" style="width: 60%;" />
                                        <?php
                                        if ($type === "dine_in") {
                                        ?>
                                            <h6 class="">Diantar</h6>
                                        <?php } else { ?>
                                            <h6 class="">Diambil</h6>
                                        <?php } ?>
                                        <h6 class="">---</h6>
                                    <?php } else { ?>
                                        <?php
                                        if ($data['status'] < 4) {
                                        ?>
                                            <img src="./image/bulat4.svg" alt="" style="width: 60%;" />
                                            <?php
                                            if ($type === "dine_in") {
                                            ?>
                                                <h6 class="">Diantar</h6>
                                            <?php } else { ?>
                                                <h6 class="">Diambil</h6>
                                            <?php } ?>
                                            <h6 class="">---</h6>
                                        <?php } else { ?>

                                            <img src="./image/bulat5.svg" alt="" style="width: 60%;" />
                                            <?php
                                            if ($type === "dine_in") {
                                            ?>
                                               <h6 class="">Diantar</h6>
                                            <?php } else { ?>
                                               <h6 class="">Diambil</h6>
                                            <?php } ?>
                                            <h6 class=""><?php echo date("H;i", strtotime($data['waktu_antar']))  ?></h6>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center justify-content-center">
                                <div class="text-center mx-auto pb-5">
                                    <img src="./image/garis.svg" class="img-fluid" alt="" />
                                </div>
                            </div>

                            <div class="col mb-3 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <?php
                                    if ($data['status'] == 9) {
                                    ?>
                                        <img src="./image/bulat3.svg" alt="" style="width: 60%;" />
                                        <h6 class="">Selesai</h6>
                                        <h6 class="">---</h6>
                                    <?php } else { ?>
                                        <?php
                                        if ($data['status'] < 5) {
                                        ?>
                                            <img src="./image/bulat4.svg" alt="" style="width: 60%;" />
                                            <h6 class="">Selesai</h6>
                                            <h6 class="">---</h6>
                                        <?php
                                        } else {
                                        ?>
                                            <img src="./image/bulat5.svg" alt="" style="width: 60%;" />
                                            <h6 class="">Selesai</h6>
                                            <h6 class=""><?php echo date("H:i", strtotime($data['waktu_selesai'])) ?></h6>
                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                        <div class="col-12  d-flex justify-content-center">
                            <div class="card" style="background-color: #1714B6; border-radius: 15px;">
                                <div class="card-body" style="padding: 10px 30px;">
                                    <h4 class="text-white text-center"><?php echo $data['username'] ?>: <?php echo $data['nama_toko'] ?></h4>
                                    <?php
                                    $total_belanja = 0;
                                    if ($keranjang->num_rows > 0) {
                                        while ($row2 = $keranjang->fetch_array()) {
                                            $total_belanja += $row2['total'];
                                            if ($row2['status'] == 1) {
                                    ?>
                                                <div class="row mb-2">
                                                    <div class="col d-flex justify-content-center">
                                                        <div class="rounded">
                                                            <img src="image/menu/<?php echo $row2['gambar_menu'] ?>" style="width: 90%;" alt="menu" />
                                                        </div>
                                                    </div>
                                                    <div class="col d-flex justify-content-center">
                                                        <h6 class="text-white"><?php echo $row2['nama_menu'] ?></h6>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <h6 class="text-white">Rp. <?php echo number_format($row2['harga_menu'], 0, ',', '.') ?></h6>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <h6 class="text-white"><?php echo $row2['jumlah'] ?>x item</h6>
                                                    </div>

                                                </div>
                                            <?php } else { ?>
                                                <div class="row mb-2">
                                                    <div class="col d-flex justify-content-center">
                                                        <div class="rounded">
                                                            <img src="image/menu/<?php echo $row2['gambar_menu'] ?>" style="width: 90%;" alt="menu" />
                                                        </div>
                                                    </div>
                                                    <div class="col d-flex justify-content-center">
                                                        <h6 class="text-white"><?php echo $row2['nama_menu'] ?></h6>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <h6 style="color: red;">HABIS</h6>
                                                    </div>
                                                    <div class="col d-flex justify-content-end">
                                                        <h6 class="text-white">-</h6>
                                                    </div>

                                                </div>
                                        <?php
                                            }
                                        }
                                    } else {
                                        ?>
                                        <h1>tidak ada keranjang</h1>
                                    <?php
                                    }
                                    ?>

                                    <!-- <div class="row mb-2">
                                        <div class="col d-flex justify-content-center">
                                            <div class="rounded">
                                                <img src="image/menu/bakso1.png" style="width: 90%;" alt="menu" />
                                            </div>
                                        </div>
                                        <div class="col d-flex justify-content-center">
                                            <h6 class="text-white">Bakso</h6>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <h6 class="text-white">Rp. 10.000</h6>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <h6 class="text-white">2x item</h6>
                                        </div>

                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-md-5 col-lg-5">
                <div class="card m-3">
                    <div class="card-body" style="background-color: #ffffff; border-radius:12px">
                        <div class="container my-4">
                            <div class="text-center">
                                <h2 class="mb-5">Rincian Pesananmu</h2>
                            </div>
                            <div class="row mb-2">
                                <div class="col-auto">
                                    <h3>Produk</h3>
                                </div>
                                <div class="col-auto ml-auto">
                                    <h3>Subtotal</h3>
                                </div>
                            </div>
                            <?php
                            if ($detail->num_rows > 0) {
                                while ($row3 = $detail->fetch_array()) {
                            ?>
                                    <div class="row mb-2">
                                        <div class="col-auto">
                                            <h3 class=""><?php echo $row3['jumlah'] ?>x Item <?php echo $row3['nama_menu'] ?></h3>
                                        </div>
                                        <div class="col-auto ml-auto">
                                            <h3>Rp. <?php echo number_format($row3['total'], 0, ',', '.') ?></h3>
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
                            <!-- <div class="row mb-2">
                                <div class="col-auto">
                                    <h3 class="">1x Item Es Garbis</h3>
                                </div>
                                <div class="col-auto ml-auto">
                                    <h3>Rp. 5.000</h3>
                                </div>
                            </div> -->
                            <div class="row mb-2">
                                <div class="col-auto p-0 m-0">
                                    <img src="./image/garis5.svg" class="img-fluid" alt="" />
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-auto">
                                    <h3 class="">Total Harga</h3>
                                </div>
                                <div class="col-auto ml-auto">
                                    <h3>Rp. <?php echo number_format($total_harga, 0, ',', '.') ?></h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-auto">
                                    <h3 class="">Order</h3>
                                </div>
                                <div class="col-auto ml-auto">
                                    <?php
                                    if ($type === 'dine_in') {
                                    ?>
                                        <h3> Dine In</h3>
                                    <?php
                                    } else {
                                    ?>
                                        <h3> Take Away</h3>
                                    <?php
                                    }
                                    ?>
                                    <!-- <h3> Take Away</h3> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <h3>Waktu Pemesanan</h3>
                                </div>
                                <div class="col-auto ml-auto">
                                    <h3>
                                        <?php echo date("d-m-Y H:i", strtotime($waktu_pesan))  ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-auto">
                                    <h3>Meja </h3>
                                </div>
                                <div class="col-auto ml-auto">
                                    <h3>
                                        <!-- <?php
                                                if ($mejakursi->num_rows > 0) {
                                                    while ($row4 = $mejakursi->fetch_array()) {
                                                ?>
                                                    <?php echo $row4['kode'] ?>
                                                <?php }
                                                } else { ?>
                                                ---
                                            <?php } ?> -->
                                        <?php
                                        if ($meja == 0) {
                                            echo "---";
                                        } else {
                                            echo $meja;
                                        }
                                        ?>
                                    </h3>
                                </div>
                            </div>
                            <div class="row justify-content-center pt-5">
                                <div class="col-auto ">
                                    <?php
                                    if ($data['status'] < 3) {
                                        if (isset($data['waktu_batal'])) {
                                    ?>
                                            <a target="" href="controller/keranjang_cancel.php?id_keranjang=<?php echo $data['id'] ?>&type=<?php echo $type ?>">
                                                <button id="myButton" class="btn btn-primary font-weight-bold mr-1" style="background-color:  #1714B6; width: 100px; border-radius:15px">
                                                    <div id="time"></div> Cancel
                                                </button>
                                            </a>
                                        <?php } else { ?>
                                            <a target="_blank" href="controller/keranjang_cancel.php?id_keranjang=<?php echo $data['id'] ?>&type=<?php echo $type ?>">
                                                <button class="btn btn-primary font-weight-bold mr-1" style="background-color:  #1714B6; width: 100px; border-radius:15px">
                                                    Cancell
                                                </button>
                                            </a>
                                    <?php }
                                    } ?>
                                </div>
                                <div class="col-auto">
                                    <?php
                                    if ($data['status'] == 1) {
                                    ?>
                                        <a target="_blank" href="controller/keranjang.php?id_keranjang=<?php echo $data['id'] ?>&type=<?php echo $type ?>">
                                            <button class="btn btn-primary font-weight-bold" style="background-color: #1714B6; width: 200px;  border-radius:15px" disabled>Tunggu Konfirmasi</button>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($data['status'] == 2) {
                                    ?>

                                        <a target="_blank" href="controller/keranjang.php?id_keranjang=<?php echo $data['id'] ?>&type=<?php echo $type ?>">
                                            <button class="btn btn-primary font-weight-bold ml-1" style="background-color:  #1714B6; width: 100px;  border-radius:15px">Bayar</button>
                                        </a>
                                    <?php }
                                    if ($data['status'] > 3) { ?>
                                        <a href="index.php">
                                            <button class="btn btn-primary font-weight-bold" style="background-color:  #1714B6; width: 120px;  border-radius:15px">Kembali</button>
                                        </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    function startCountdown(endTime, display) {
        const button = document.querySelector('#myButton');
        button.disabled = false;
        const end = new Date(endTime);
        const interval = setInterval(function() {
            const now = new Date();
            const distance = end - now;

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            display.textContent = minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(interval);
                // display.textContent = "waktu habis! ";
                updateQuery();
                button.disabled = true;
            }
        }, 1000);
    }

    window.onload = function() {
        var endTime = "<?php echo $wakkktu; ?>";
        var display = document.querySelector('#time');
        startCountdown(endTime, display);
    };

    function updateQuery() {
        var iid = "<?php echo $id; ?>"
        var tipe = "<?php echo $type; ?>"
        $.ajax({
            url: 'controller/keranjang_cancel.php',
            type: 'GET',
            data: {
                id_keranjang: iid,
                type: tipe
            },
            success: function(response) {
                console.log('Data berhasil diperbarui:', response);
            },
            error: function(xhr, status, error) {
                console.error('Terjadi kesalahan:', error);
            }
        });
    }
</script>

</html>