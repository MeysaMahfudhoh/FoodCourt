<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
  <?php
  session_start();
  if (isset($_SESSION['error'])) {
    echo "<script>alert('" . $_SESSION['error'] . "');</script>"; // Menampilkan alert jika ada error
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['sukses'])) {
    echo "<script>alert('" . $_SESSION['sukses'] . "');</script>"; // Menampilkan alert jika ada sukses
    unset($_SESSION['sukses']);
  }
  ?>
  <section class="vh-100" style="background-color: #284990">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="image/court.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">
                  <form action="controller/registration.php" method="post">
                    <div class="d-flex align-items-center mb-3 pb-1">
                      <i class="fas fa-cubes fa-2x me-3" style="color: #284990"></i>
                      <span class="h1 fw-bold mb-0">Register !</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px">
                      Register your account
                    </h5>

                    <div class="form-outline mb-4">
                      <input type="email" id="email" name="email" class="form-control form-control-lg" />
                      <label class="form-label" for="email">Email address</label>
                    </div>

                    <div class="form-outline mb-4">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" />
                      <label class="form-label" for="password">Password</label>
                    </div>

                    <div class="pt-1 mb-4">
                      <!-- <a href="controller/registration.php"> -->
                      <button class="btn btn-dark btn-lg btn-block" type="submit" value="submit" type="button">
                        Register
                      </button>
                      <!-- </a> -->
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>