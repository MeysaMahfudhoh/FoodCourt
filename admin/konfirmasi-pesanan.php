<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
  $_SESSION['error'] = 'Gagal';
  header('Location: ../login.php');
}
if ($_SESSION['role'] == 'mahasiswa') {
  header('Location: ../index.php');
}
if (isset($_SESSION['sukses'])) {
  echo "<script>alert('" . $_SESSION['sukses'] . "');</script>"; // Menampilkan alert jika ada sukses
  unset($_SESSION['sukses']);
}
if (isset($_SESSION['error'])) {
  echo "<script>alert('" . $_SESSION['error'] . "');</script>";
  unset($_SESSION['error']);
}

include '../controller/koneksi.php';

$sql = "SELECT keranjang_detail.id AS id_detail, keranjang.id, keranjang.status, keranjang.waktu_bayar, menu.nama_menu, menu.harga_menu, menu.gambar_menu , keranjang_detail.jumlah, keranjang_detail.total, keranjang_detail.id_keranjang
, keranjang.id_user, user.username, user.email, keranjang.total_item, keranjang.jenis, keranjang.meja, keranjang_detail.status AS detail_status, keranjang.meja
FROM keranjang_detail 
INNER JOIN menu  ON keranjang_detail.id_menu = menu.id 
INNER JOIN keranjang ON keranjang.id = keranjang_detail.id_keranjang
INNER JOIN user ON keranjang.id_user = user.id
WHERE keranjang.id_stand = ? AND keranjang.status < 4";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Foodcourt | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="dashboard.php" class="nav-link">Dashboard</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i> Profile
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="profile.php" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a href="../controller/logout.php" class="dropdown-item">
              <i class="fas fa-arrow-right mr-2"></i> Logout
            </a>
          </div>
        </li>

      </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #1714B6;">
      <a href="dashboard.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Halaman Admin</span>
      </a>
      <div class="sidebar">
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="konfirmasi-pesanan.php" class="nav-link">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                  Konfirmasi Pesanan
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="pesanan-selesai.php" class="nav-link">
                <i class="nav-icon fas fa-check"></i>
                <p>
                  Pesanan Selesai
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="data-menu.php" class="nav-link">
                <i class="nav-icon fas fa-utensils"></i>
                <p>
                  Data Menu
                </p>
              </a>
            </li>

          </ul>
        </nav>
      </div>
    </aside>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">Konfirmasi Pesanan</h1>
              <p>Harap konfirmasi pesanan yang sudah masuk, jika semua informasi yang diberikan sudah benar, silahkan klik verify pada kolom yang sesuai</p>
            </div>
          </div>
        </div>
      </div>
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Konfirmasi Pesanan</h3>
                </div>
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Nomor</th>
                        <th>Konfirmasi</th>
                        <th>Tolak</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Waktu Pesanan</th>
                        <th>Nomer Meja</th>
                        <th>Order</th>
                        <th>Nama Menu</th>
                        <th>Habis</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($result->num_rows > 0) {
                        $no = 0;
                        $rowid = 0;
                        $rowspan = 0;

                        while ($row = $result->fetch_assoc()) {
                          if ($rowid == 0 || $rowspan == $rowid) {
                            $rowid = 0;
                            $rowspan = $row['total_item'];
                            $no++;
                      ?>
                            <tr>
                              <td rowspan="<?= $rowspan ?>"><?php echo $no ?></td>
                              <?php
                              if ($row['status'] === 1) {
                              ?>
                                <td rowspan="<?= $rowspan ?>">
                                  <form action="../controller/admin/pesanan_konfirmasi.php?id=<?php echo $row['id'] ?>" method="POST">
                                    <input class="" type="text" id="meeting-time" name="meeting-time" required>
                                    <!-- <br> -->
                                    <button value="submit" class="btn btn-success mt-2">
                                      Terima Pesanan
                                    </button>
                                  </form>
                                </td>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="../controller/admin/pesanan_tolak.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"> Tolak </a>
                                </td>
                              <?php
                              }
                              if ($row['status'] === 2) {
                              ?>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="../controller/admin/pesanan_terima.php?id=<?php echo $row['id'] ?>" class="btn btn-success"> Terima Pembayaran</a>
                                </td>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="../controller/admin/pesanan_tolak.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"> Tolak </a>
                                </td>
                              <?php
                              }
                              if ($row['status'] === 3) {
                              ?>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="../controller/admin/pesanan_antar.php?id=<?php echo $row['id'] ?>" class="btn btn-success"> Antar Pesanan </a>
                                </td>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="../controller/admin/pesanan_tolak.php?id=<?php echo $row['id'] ?>" class="btn btn-danger"> Tolak </a>
                                </td>
                              <?php
                              }
                              if ($row['status'] === 9) {
                              ?>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="" class="btn btn-danger disabled"> Ditolak </a>
                                </td>
                                <td rowspan="<?= $rowspan ?>">
                                  <a href="" class="btn btn-danger disabled"> Ditolak </a>
                                </td>
                              <?php
                              }
                              ?>
                              <td rowspan="<?= $rowspan ?>"><?php echo $row['username'] ?></td>
                              <td rowspan="<?= $rowspan ?>"><?php echo $row['email'] ?></td>
                              <td rowspan="<?= $rowspan ?>">
                                <?php if (!isset($row['waktu_bayar'])) { ?>
                                  Belum Bayar
                                <?php
                                } else {
                                  echo $row['waktu_bayar'] ?>
                                <?php } ?>
                              </td>
                              <td rowspan="<?= $rowspan ?>">
                                <?php
                                if ($row['meja'] == 0) {
                                  echo "---";
                                } else {
                                  echo $row['meja'];
                                }
                                ?>
                              </td>
                              <td rowspan="<?= $rowspan ?>">
                                <?php if ($row['jenis'] === 'dine_in') { ?>
                                  Dine In
                                <?php } else { ?>
                                  Take Away
                                <?php  } ?>
                              </td>

                            <?php
                          }
                            ?>
                            <td><?php echo $row['nama_menu'] ?></td>
                            <td>
                              <?php
                              if ($row['detail_status'] == 1) {
                              ?>
                                <a href="../controller/keranjang_detail_cancel.php?id_detail=<?php echo $row['id_detail'] ?>&detail_status=<?php echo $row['detail_status'] ?>&id_ker=<?php echo $row['id'] ?>&harga=<?php echo $row['harga_menu'] ?>&jumlah=<?php echo $row['jumlah'] ?>" class="btn btn-success">Konfirmasi</a>
                              <?php } else { ?>
                                <a href="../controller/keranjang_detail_cancel.php?id_detail=<?php echo $row['id_detail'] ?>&detail_status=<?php echo $row['detail_status'] ?>&id_ker=<?php echo $row['id'] ?>&harga=<?php echo $row['harga_menu'] ?>&jumlah=<?php echo $row['jumlah'] ?>" class="btn btn-primary">Batalkan</a> <?php } ?>
                            </td>

                            </tr>
                        <?php
                          $rowid++;
                        }
                      } else {
                        echo "Tidak ada data yang ditemukan";
                      }
                        ?>


                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
            </div>
          </div>
          <!-- /.row -->
          <!-- Main row -->


        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script> -->
  <!-- <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>

  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <!-- <script src="plugins/jszip/jszip.min.js"></script> -->
  <!-- <script src="plugins/pdfmake/pdfmake.min.js"></script> -->
  <!-- <script src="plugins/pdfmake/vfs_fonts.js"></script> -->
  <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
  <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
  <script>
    $(function() {
      $('#reservationdatetime').datetimepicker({
        icons: {
          time: 'far fa-clock'
        }
      });
    })
  </script>
  <script>
    // Inisialisasi Flatpickr untuk input datetime
    flatpickr('#meeting-time', {
      enableTime: true,
      altFormat: "Y-m-d H:i:s", // Format yang diinginkan
      altInput: true
    });
  </script>
</body>

</html>