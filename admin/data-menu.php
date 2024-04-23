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
$sql = "SELECT * FROM menu WHERE id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
// $row = $result->fetch_assoc();
// var_dump($row);
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
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="dashboard.php" class="nav-link">Dashboard</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
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

        <!-- Notifications Dropdown Menu -->
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
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #1714B6;">
      <!-- Brand Logo -->
      <a href="dashboard.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Halaman Admin</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">


          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="konfirmasi-pesanan.php" class="nav-link">
                <i class="nav-icon fas fa-bell"></i>
                <p>
                  Konfirmasi Pesanan
                  <!-- <span class="right badge badge-danger">New</span> -->
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

            <!-- <li class="nav-item">
              <a href="dashboard.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li> -->

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">Data Menu</h1>
              <p>SOTO BAKSO PAK JI</p>
            </div><!-- /.col -->

          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Konfirmasi Pesanan</h3>
                  <br>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus"></i>
                    Nama Menu
                  </button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped"">
                    <thead>
                      <tr>
                        <th>Nomor</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>gambar</th>
                        <th>Action</th>
                        <th>Disable</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                      ?>
                          
                          <tr>
                            <td><?php echo $no ?></td>
                            <td><?php echo $row['nama_menu'] ?></td>
                            <td><?php echo $row['harga_menu'] ?></td>
                            <td><img src="../image/menu/<?php echo $row['gambar_menu'] ?>" width="50" alt=""></td>
                            <td> 
                              <a href='' data-toggle='modal' data-target='#modaledit<?php echo $row['id'] ?>' style='color:black'><i class='fas fa-pen mr-2' ></i> </a>
                            
                              <div class='modal fade' id='modaledit<?php echo $row['id'] ?>'>
                                <div class='modal-dialog'>
                                  <div class='modal-content'>
                                    <div class='modal-header'>
                                      <h4 class='modal-title'>Form Edit Menu</h4>
                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                      </button>
                                    </div>
                                    <div class='modal-body'>
                                      <form action='../controller/admin/edit-menu.php' method='post'>
                                        <input type='hidden' name='id' value='<?php echo $row['id'] ?>'>
                                        <div class='form-outline mb-1'>
                                          <label class='form-label' for='nama'>Nama Menu</label>
                                          <input type='text' id='nama' value='<?php echo $row['nama_menu'] ?>' name='nama' class='form-control form-control-lg' />
                                        </div>
          
                                        <div class='form-outline mb-1'>
                                          <label class='form-label' for='harga'>Harga</label>
                                          <input type='text' id='harga' value='<?php echo $row['harga_menu'] ?>' name='harga' class='form-control form-control-lg' />
                                        </div>
                                        
          
                                        <div class='pt-1 mb-4'>
                                          <a href='controller/login.php'>
                                            <button class='btn btn-primary btn-lg btn-block' type='submit' value='submit'>
                                              Ubah
                                            </button></a>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <a href='#' data-toggle='modal' data-target='#modalhapus<?php echo $row['id'] ?>'  style='color:black'><i class='fas fa-trash'></i></a>
                              <div class='modal fade' id='modalhapus<?php echo $row['id'] ?>'>
                                <div class='modal-dialog'>
                                  <div class='modal-content'>
                                    <div class='modal-header'>
                                      <h4 class='modal-title'>Hapus Menu</h4>
                                      <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                      </button>
                                    </div>
                                    <div class='modal-body'>
                                     <h5>Apakah anda ingin menghapus <?php echo $row['nama_menu'] ?> ?</h5>
                                    </div>
                                    <div class='modal-footer justify-content-between'>
                                      <button type='button' class='btn btn-danger' data-dismiss='modal'>Batal</button>
                                      <a href='../controller/admin/hapus-menu.php?id=<?php echo $row['id'] ?>' class='btn btn-primary'>Hapus</a>      
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </td>
                            <td>
                              <?php
                              if ($row['status'] === 1) {
                              ?>

                                <button type='button' data-toggle='modal' data-target='#modalnonaktif<?php echo $row['id'] ?>' class='btn btn-danger'>Non-Aktifkan
                                </button>
                                <div class='modal fade' id='modalnonaktif<?php echo $row['id'] ?>'>
                                  <div class='modal-dialog'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h4 class='modal-title'>Form Edit Menu</h4>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <h5>Non-Aktifkan <?php echo $row['nama_menu'] ?> ?</h5>
                                      </div>
                                      <div class='modal-footer justify-content-between'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Batal</button>
                                        <a href='../controller/admin/status-menu.php?id=<?php echo $row['id'] ?>&status=<?php echo $row['status'] ?>' class='btn btn-primary'>Non-Aktifkan</a>      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              <?php
                              } else {
                              ?>
                                <button type='button' data-toggle='modal' data-target='#modalaktif<?php echo $row['id'] ?>' class='btn btn-primary'>Aktifkan
                                </button>
                                <div class='modal fade' id='modalaktif<?php echo $row['id'] ?>'>
                                  <div class='modal-dialog'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h4 class='modal-title'>Form Edit Menu</h4>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <h5>Aktifkan <?php echo $row['nama_menu'] ?> ?</h5>
                                      </div>
                                      <div class='modal-footer justify-content-between'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Batal</button>
                                        <a href='../controller/admin/status-menu.php?id=<?php echo $row['id'] ?>&status=<?php echo $row['status'] ?>' class='btn btn-primary'>Aktifkan</a>      
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <?php
                              }
                                ?>
                          
                            </td>
                          </tr>
                          <?php
                          $no++;
                        }
                      } else {
                        echo "<tr><td colspan='6'>TIDAK ADA MENU</td></tr>";
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
                        <div class=" modal fade" id="modal-default">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Form Menu</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <!-- <p>One fine body&hellip;</p> -->
                          <form action="../controller/admin/tambah-menu.php" method="post" enctype="multipart/form-data">
                            <div class="form-outline mb-1">
                              <label class="form-label" for="nama">Nama Menu</label>
                              <input type="text" id="nama" name="nama" class="form-control form-control-lg" />
                            </div>

                            <div class="form-outline mb-1">
                              <label class="form-label" for="harga">Harga</label>
                              <input type="text" id="harga" name="harga" class="form-control form-control-lg" />
                            </div>

                            <div class="form-group form-outline mb-1">
                              <label for="gambar">Gambar</label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input form-control form-control-lg" id="gambar" name="gambar">
                                  <label class="custom-file-label form-label" for="gambar">Pilih file</label>
                                </div>
                                <div class="input-group-append">
                                  <span class="input-group-text">Upload</span>
                                </div>
                              </div>
                            </div>

                            <div class="pt-1 mb-4">
                              <a href="controller/login.php">
                                <button class="btn btn-primary btn-lg btn-block" type="submit" value="submit">
                                  Tambahkan
                                </button></a>
                            </div>
                          </form>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
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
                <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
                <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
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
                <script src="plugins/jszip/jszip.min.js"></script>
                <script src="plugins/pdfmake/pdfmake.min.js"></script>
                <script src="plugins/pdfmake/vfs_fonts.js"></script>
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

</body>

</html>