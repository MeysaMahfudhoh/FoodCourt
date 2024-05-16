<?php
session_start();
include 'controller/koneksi.php';
include 'controller/cart-view.php';
if (isset($_SESSION['sukses'])) {
  echo "<script>alert('" . $_SESSION['sukses'] . "');</script>"; // Menampilkan alert jika ada sukses
  unset($_SESSION['sukses']);
}
if (isset($_SESSION['error'])) {
  echo "<script>alert('" . $_SESSION['error'] . "');</script>";
  unset($_SESSION['error']);
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
  <title>About | Unesa Foodcourt</title>
</head>

<body>
  <!-------------------------------------------- HEADER SECTION -->
  <header class="header">
    <a href="#" class="logo">
      <img src="image/logo.png" alt="logo" />
    </a>
    <nav class="navbar">
      <a href="index.php">home</a>
      <a href="stand.php">stand</a>
      <a href="about.php" class="active">about</a>
      <a href="contact.php">contact</a>
      <!-- <a href="blog.php">blog</a> -->
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
      <input type="text" class="search-input" id="search-box" placeholder="Search" autocomplete="off" />
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

  <!-- -------------------------------------------ABOUT US SECTION -->
  <section class="about" id="about">
    <h1 class="heading">about <span>us</span></h1>

    <div class="row">
      <div class="image">
        <img src="./image/pngwing.com (7).png" alt="" />
      </div>
      <div class="content">
        <h3>WEBSITE FOODCOURT UNESA KETINTANG</h3>
        <div class="paragraph">
          <p>
            Website food court UNESA Ketintang ini merupakan sebuah sistem
            layanan pemesanan makanan dan minuman secara online yang
            disediakan melalui website.
          </p>
          <p>
            Website ini dirancang dengan fitur agar pembeli dapat melihat
            menu, memilih menu, memesan menu, kemudian pesanan akan diterima
            otomatis oleh penjual, jadi pembeli tidak perlu datang untuk
            mengantri dan berebut tempat duduk.
          </p>
          <p>
            sistem berbasis website ini yang nantinya akan memudahkan citivas
            akademika Universitas Negeri Surabaya dalam memenuhi kebutuhan
            mereka pada proses pemesanan makanan dan minuman di kantin.
          </p>
        </div>
        <a href="#" class="btn">Learn More</a>
      </div>
    </div>
  </section>
  <!-- -------------------------------------------ABOUT US SECTION -->

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
          Swal.fire({
            title: 'Meja Nomer ?',
            input: "text",
            showCloseButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Pesan',
          }).then((inputResult) => {
            if (inputResult.value) {
              const meja = inputResult.value;
              window.location.href = `pesanan2.php?type=dine_in&meja=${meja}`;
            } else {
              window.location.href = 'stand.php';
            }

          });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          window.location.href = 'pesanan2.php?type=take_away&meja=0';
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