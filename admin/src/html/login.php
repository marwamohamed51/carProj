<?php
session_start();
if (isset($_SESSION['login']) and $_SESSION['login'] == true) {
  header('location: users.php');
  die();
}
include_once('../../conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $password = $_POST['password'];
    $email = $_POST['email'];
    $active = 1;
    $sql = 'SELECT `name`,`password` FROM `users` WHERE email = ? and active =?';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email, $active]);
    if ($stmt->rowCount()) {
      $result = $stmt->fetch();
      $verify = password_verify($password, $result['password']);

      // Print the result depending if they match 
      if ($verify) {
        $_SESSION['login'] = true;
        header('location: users.php');
        die();
        // echo 'Password Verified :)';
      } else {
        echo 'Incorrect Password!';
      }
    } else {
      echo "Email not found or email not active :(";
    }

  } catch (PDOException $e) {
    echo $e->getMessage();

  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>
<!-- admin/src/html/login.php -->

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                </a>
                <p class="text-center">Your Social Campaigns</p>
                <form action="" method="post">
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                      name="email">
                  </div>
                  <div class="mb-4">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                  </div>
                  <input type="submit" name="submit" value="Login"
                    class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">
                  <!-- <a href="./index.html" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</a> -->
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Register new !</p>
                    <a class="text-primary fw-bold ms-2" href="register.php">Create an account</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>