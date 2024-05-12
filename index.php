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
  <title>Website Foodcourt Unesa</title>
</head>

<body>
  <!-------------------------------------------- HEADER SECTION -->
  <header class="header">
    <a href="#" class="logo">
      <img src="./image/logo.png" alt="logo" />
    </a>
    <nav class="navbar">
      <a href="index.php" class="active">home</a>
      <a href="stand.php">stand</a>
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
  <!---------------------------------------------HEADER SECTION -->

  <!---------------------------------------------HOME SECTION -->
  <section class="home" id="home">
    <div class="content">
      <h3>Welcome to FoodCourt UNESA</h3>
      <p>Order Your Best Food anytime</p>
      <p>
        hey, Our delicious food is waiting for you, We are always near to you
        with fresh item of food
      </p>
      <?php
      if (isset($_SESSION['loggedin'])) {
      ?>
        <a href="controller/logout.php" class="btn">Logout</a>

      <?php
      } else {
      ?>
        <a href="login.php" class="btn">Login</a>
      <?php
      }
      ?>
    </div>
  </section>
  <!---------------------------------------------HOME SECTION -->

  <!---------------------------------------------ABOUT US SECTION -->
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
            Website food court UNESA Ketintang ini merupakan sebuah sistem layanan pemesanan makanan dan minuman secara online yang disediakan melalui website.
          </p>
          <p>
            Website ini dirancang dengan fitur agar pembeli dapat melihat menu, memilih menu, memesan menu, kemudian pesanan akan diterima otomatis oleh penjual, jadi pembeli tidak perlu datang untuk mengantri dan berebut tempat duduk.
          </p>
          <p>
            sistem berbasis website ini yang nantinya akan memudahkan citivas akademika Universitas Negeri Surabaya dalam memenuhi kebutuhan mereka pada proses pemesanan makanan dan minuman di kantin.
          </p>
        </div>
        <a href="#" class="btn">Learn More</a>
      </div>
    </div>
  </section>
  <!---------------------------------------------ABOUT US SECTION -->

  <!---------------------------------------------CONTACT SECTION -->
  <section class="contact" id="contact">
    <h1 class="heading">contact <span>us</span></h1>
    <div class="row">
      <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3159.148560217434!2d112.72421902653578!3d-7.314180581776443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb7a74c60bc1%3A0x3eaf6f55d501a7cd!2sFood%20Court%20Baseball%20Unesa!5e0!3m2!1sid!2sid!4v1714563856195!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>"></iframe>
      <form>
        <h3>get in touch</h3>
        <div class="inputBox">
          <i class="fas fa-user"></i>
          <input type="text" placeholder="name" />
        </div>
        <div class="inputBox">
          <i class="fas fa-envelope"></i>
          <input type="email" placeholder="email" />
        </div>
        <div class="inputBox">
          <i class="fas fa-phone"></i>
          <input type="number" placeholder="number" />
        </div>
        <input type="submit" class="btn" value="contact now" />
      </form>
    </div>
  </section>
  <!---------------------------------------------CONTACT SECTION -->

  <!---------------------------------------------BLOG SECTION -->
  <section class="blog" id="blog">
    <h1 class="heading">our <span>blog</span></h1>
    <div class="box-container">
      <div class="box-full">
        <div class="image">
          <img src="./image/delicious-burger-on-wooden-board-2022-03-04-05-58-25-utc.jpg" alt="" />
        </div>
        <div class="content">
          <a href="#" class="title">how to make burgers</a>
          <span>by admin / 10st may, 2020</span>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus
            eos esse nesciunt cupiditate expedita.
          </p>
          <a href="#" class="btn">read more</a>
        </div>
      </div>
      <div class="box-full">
        <div class="image">
          <img src="./image/delicious-tasty-burgers-on-wooden-background-2021-08-26-15-25-13-utc.jpg" alt="" />
        </div>
        <div class="content">
          <a href="#" class="title">how to make burgers</a>
          <span>by admin / 10st may, 2020</span>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus
            eos esse nesciunt cupiditate expedita.
          </p>
          <a href="#" class="btn">read more</a>
        </div>
      </div>
      <div class="box-full">
        <div class="image">
          <img src="./image/handmade-burger-on-dark-background-delicious-blac-2021-10-21-02-27-27-utc.jpg" alt="" />
        </div>
        <div class="content">
          <a href="#" class="title">how to make burgers</a>
          <span>by admin / 10st may, 2020</span>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minus
            eos esse nesciunt cupiditate expedita.
          </p>
          <a href="#" class="btn">read more</a>
        </div>
      </div>
    </div>
  </section>
  <!---------------------------------------------BLOG SECTION -->

  <!---------------------------------------------FOOTER SECTION -->
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
  <!---------------------------------------------FOOTER SECTION -->

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
          window.location.href = 'index.php';
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