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
  <title>Blog | Unesa Foodcourt</title>
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
      <a href="about.php">about</a>
      <a href="contact.php">contact</a>
      <a href="blog.php" class="active">blog</a>
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
      <input type="text" class="search-input" id="search-box" placeholder="Search" />
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
                <div class="price"><?php echo $row2['harga_menu'] ?></div>
              </div>
            </div>
          <?php
          }
          ?>
          <a href="pesanan.php" class="btn">check out </a>
        <?php
        } else {
        ?>
          <!-- <h1>tidak ada keranjang</h1> -->
          <a href="pesanan.php" class="btn">Lihat Pesanan Saya </a>
      <?php
        }
      }
      ?>

    </div>
  </header>
  <!-- -------------------------------------------HEADER SECTION -->

  <!-- -------------------------------------------BLOG SECTION -->
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
  <!-- -------------------------------------------BLOG SECTION -->

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
</body>

</html>