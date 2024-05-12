<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>";
    unset($_SESSION['error']);
}
if (isset($_SESSION['sukses'])) {
    echo "<script>alert('" . $_SESSION['sukses'] . "');</script>";
    unset($_SESSION['sukses']);
}


include 'controller/koneksi.php';
include 'controller/cart-view.php';

if (isset($_GET['cari']) && !empty($_GET['cari'])) {
    $cari = $_GET['cari'];
    $cari = $conn->real_escape_string($cari);
    $stmt = $conn->prepare('SELECT * FROM menu INNER JOIN user ON menu.id_user = user.id WHERE nama_menu LIKE ? ORDER BY user.id ASC');
    $searchTerm = "%" . $cari . "%";
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();

    $result = $stmt->get_result();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- CSS LINK -->
    <link rel="stylesheet" href="style.css" />
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Our Stands | Unesa Foodcourt</title>
</head>

<body>
    <!-------------------------------------------- HEADER SECTION -->
    <header class="header">
        <a href="#" class="logo">
            <img src="image/logo.png" alt="logo" />
        </a>
        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="stand.php" class="active">stand</a>
            <a href="about.php">about</a>
            <a href="contact.php">contact</a>
            <a href="blog.php">blog</a>
        </nav>
        <div class="buttons">
            <button id="search-btn">
                <i class="fas fa-search"></i>
            </button>
            <button id="cart-btn">
                <i class="fas fa-shopping-cart"></i>
            </button>
            <button id="menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="search-form">
            <input type="text" class="search-input" id="search-box" name="cari" placeholder="Search" autocomplete="off" />
            <i class="fas fa-search"></i>
        </div>
        <div class="cart-items-container">
            <?php
            if ($keranjang == null) {
            ?>
                <h1>tidak ada keranjang</h1>
                <?php
            } else {
                if ($keranjang->num_rows > 0) {
                    while ($row2 = $keranjang->fetch_array()) {
                ?>
                        <div class="cart-item">
                            <a href="controller/cart-hapus.php?id=<?php echo $row2['id'] ?>&id_keranjang=<?php echo $row2['id_keranjang'] ?>&harga=<?php echo $row2['harga_menu'] ?>">
                                <i class="fas fa-times"></i>
                            </a>
                            <img src="image/menu/<?php echo $row2['gambar_menu'] ?>" alt="menu" />
                            <div class="content">
                                <h3><?php echo $row2['nama_menu'] ?></h3>
                                <div class="price"><?php echo $row2['total'] ?></div>
                            </div>
                            <a href="controller/keranjang_detail_edit.php?id_detail=<?php echo $row2['id'] ?>&id_ker=<?php echo $row2['id_ker'] ?>&harga=<?php echo $row2['harga_menu'] ?>&aksi=tambah" class="btn btn-sm m-0" style="padding: 3px 3px;"><i class="fas fa-plus"></i></a>
                            <h2><?php echo $row2['jumlah'] ?></h2>
                            <a href="controller/keranjang_detail_edit.php?id_detail=<?php echo $row2['id'] ?>&id_ker=<?php echo $row2['id_ker'] ?>&harga=<?php echo $row2['harga_menu'] ?>&aksi=kurang" class="btn btn-sm m-0" style="padding: 3px 3px;"><i class="fas fa-minus"></i></a>
                        </div>
                    <?php
                    }
                    ?>
                    <button class="btn" id="orderButton">Check Out</button>
                <?php
                } else {
                ?>
                    <a href="pesanan2.php" class="btn">Lihat Pesanan Saya </a>
            <?php
                }
            }
            ?>
        </div>
    </header>
    <!-- -------------------------------------------HEADER SECTION -->
    <!-- -------------------------------------------PRODUCTS SECTION -->
    <section class="products" id="products">
        <h1 class="heading">Hasil <span>Pencarian</span></h1>
        <div class="box-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                    <div class="box">
                        <div class="box-head">
                            <a href="#" class="name"> <?php echo $row['username'] ?></a>
                        </div>
                        <!-- <div class="box"> -->
                        <div class="box-head">
                            <img src="image/menu/<?php echo $row['gambar_menu'] ?> " class="img-fluid" alt="" />
                            <h1><?php echo $row['nama_menu'] ?></h1>
                            <div class="price"><?php echo $row['harga_menu'] ?></div>
                        </div>
                        <div class="box-bottom">
                            <a href="controller/cart-tambah.php?id=<?php echo $row['id']  ?>" class="btn">add to cart</a>
                        </div>
                        <!-- </div> -->
                    </div>

                <?php
                }
            } else {
                ?>
                Tidak ada hasil yang ditemukan
            <?php
            }
            ?>

        </div>
    </section>
    <!-- -------------------------------------------PRODUCTS SECTION -->

    <!-- -------------------------------------------FOOTER SECTION -->
    <section class="footer">
        <div class="search">
            <input type="text" class="search-input" placeholder="Search" />
            <button class="btn btn-primary">search</button>
        </div>
        <div class="share">
            <a href="#" class="fab fa-facebook"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
            <a href="#" class="fab fa-pinterest"></a>
        </div>
        <div class="links">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#products">Stand</a>
            <a href="#contact">contact</a>
            <a href="#blog">blog</a>
        </div>
        <div class="credit">
            creaated by <span>FoodCourt Universitas Negeri Surabaya</span>
        </div>
    </section>
    <!-- -------------------------------------------FOOTER SECTION -->

    <script src="./script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        document.getElementById('orderButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Pilih Jenis Order',
                text: 'Pilih dine in atau take away ?',
                icon: 'question',
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Dine In',
                cancelButtonText: 'Take Away'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'pesanan2.php?type=dine_in';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    window.location.href = 'pesanan2.php?type=take_away';
                } else {
                    window.location.href = 'stand.php';
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#search-box').on('keypress', function(e) {
                if (e.which == 13) { // Only trigger on Enter key press
                    var query = $(this).val();
                    $.ajax({
                        url: 'controller/search.php',
                        method: 'POST',
                        data: {
                            cari: query
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.url) {
                                window.location.href = response.url;
                            } else {
                                alert(response.error);
                            }
                        },
                        error: function() {
                            alert('GAGAL!!');
                        }
                    });
                    return false;
                }
            });
        });
    </script>
</body>

</html>