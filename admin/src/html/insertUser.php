<?php
$nameErr = $emailErr = $passErr = "";
$err = 0;
include_once('../../conn.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST["name"]) and empty($_POST["name"])) {
    $nameErr = "Please enter your name :)";
    $err++;
  }
  if (isset($_POST["email"]) and empty($_POST["email"])) {
    $emailErr = "Please enter an E-mail :)";
    $err++;
  }
  if (isset($_POST["password"]) and empty($_POST["password"])) {
    $passErr = "Please enter your Password :)";
    $err++;
  }
  if ($err == 0) {
    try {
      $name = $_POST['name'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $email = $_POST['email'];
      if (isset($_POST['active'])) {
        $active = $_POST['active'];
        $active = 1;
      } else {
        $active = 0;
      }
      $sql = 'INSERT INTO `users`(`name`, `password`, `email`, `active`) VALUES (?,?,?,?)';
      $stmt = $conn->prepare($sql);
      $stmt->execute([$name, $password, $email, $active]);
      // echo "Your data inserted successfuly :)";
      header('location: users.php');
    } catch (PDOException $e) {
      echo $e->getMessage();

    }
    // $name = test_input($_POST["name"]);
  }

}
?>
<!doctype html>
<html lang="en">

<head>
  <?php
  $title = "Add to Users table";
  include_once('includes/head.php');
  ?>
  <style>
    .error {
      color: #FF0000;
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <?php
      include_once('includes/sidebarScroll.php');
      include_once('includes/navigation.php');
      ?>
    </aside>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <?php
      include_once('includes/header.php')
        ?>
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h2>Add to Users table</h2>
            <form action="" method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name">
                <span class="error">
                  <?php echo $nameErr; ?>
                </span>
                <br>
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                  name="email">
                <span class="error">
                  <?php echo $emailErr; ?>
                </span>
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                <br>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                <span class="error">
                  <?php echo $passErr; ?>
                </span>
                <br>
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active">
                <label class="form-check-label" for="active">Active</label>
                <br>
              </div>
              <button type="submit" class="btn btn-primary">Insert</button>
            </form>
          </div>
        </div>
      </div>

      <?php
      include_once('includes/footerJS.php')
        ?>
</body>

</html>