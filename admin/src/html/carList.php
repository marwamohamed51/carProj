<?php
include_once ('../../conn.php');
include_once ('includes/loginChecker.php');
try {
  $sql = "SELECT cars.id, cars.title,cars.model ,categories.category_name FROM `cars` 
    INNER JOIN categories on categories.cat_id = cars.category_id;";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
} catch (PDOException $e) {
  echo $e->getMessage();
}
?>
<!doctype html>
<html lang="en">

<head>
  <?php
  $title = "car list";
  include_once ('includes/head.php');
  ?>
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <?php
      include_once ('includes/sidebarScroll.php');
      include_once ('includes/navigation.php');
      ?>
    </aside>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">
      <?php
      include_once ('includes/header.php')
        ?>
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">
              <?php echo $title; ?>
            </h5>
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>Model</th>
                  <th>Category</th>
                  <th>Delete</th>
                  <th>Update</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach ($result as $row) {
                  $id = $row['id'];
                  $title = $row['title'];
                  $model = $row['model'];
                  $category_name = $row['category_name'];
                  ?>
                  <tr>
                    <td>
                      <?php echo $title; ?>
                    </td>
                    <td>
                      <?php echo $model; ?>
                    </td>
                    <td>
                      <?php echo $category_name; ?>
                    </td>
                    <td><a href="deleteCar.php?id=<?php echo $id; ?>"
                        onclick="return confirm('Are you sure you want to delete?')"><img
                          src="../assets/images/delete.png" height="25px"></td>
                    <td><a href="updateCar.php?id=<?php echo $id; ?>"><img src="../assets/images/edit.png" height="25px">
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include_once ('includes/footerJS.php')
    ?>
</body>

</html>