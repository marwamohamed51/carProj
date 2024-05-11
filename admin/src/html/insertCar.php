<?php
include_once('includes/loginChecker.php');
include_once('../../conn.php');
// show categories in select tag
try {
  $sql = 'SELECT * FROM `categories`';
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();
} catch (PDOException $e) {
  echo $e->getMessage();
}

// insert car into DB
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include_once('includes/upload.php');
        try {
            $sql = "INSERT INTO `cars`(`title`, `image`,`content`,`model`, `automatic`,`consumption`, `options`,`price`,`category_id`,`published`)
            VALUES(?,?,?,?,?,?,?,?,?,?);";
            $title = $_POST[ 'title' ];
            $content = $_POST[ 'content' ];
            $model = $_POST['model'];
            $consumption = $_POST['consumption'];
            $options = $_POST['options'];
            $price = $_POST['price'];
            $category_id  =$_POST['category_id'];
            $automatic =(isset($_POST[ 'automatic' ]));
            $published =(isset($_POST[ 'published' ]));
            $stmt = $conn->prepare( $sql );
            $stmt->execute( [$title,$image_name,$content,$model,
            $automatic,$consumption,$options,$price,$category_id,$published] );
            // echo 'Inserted Successfuly';
            header('location:insertCar.php?insert=success');
            die;
        } catch ( PDOException $e ) {
            echo 'falied insert: '.$e->getMessage();
        }
  // $name = test_input($_POST["name"]);
}


?>
<!doctype html>
<html lang="en">

<head>
  <?php
  $title = "Add to Cars table";
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
            <h2>Insert Car</h2>
            <form action="" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="name" class="form-label">Car title</label>
                <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="title">
              </div>
              <div>
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content"></textarea>
              </div>
              <div class="mb-3">
                <label for="model" class="form-label">Model</label>
                <input type="number" class="form-control" id="model" aria-describedby="emailHelp" name="model">
              </div>
              <div class="mb-3 form-check">
                <label class="form-check-label" for="auto">Automatic</label>
                <input type="checkbox" class="form-check-input" id="auto" name="automatic">
              </div>
              <div class="mb-3">
                <label for="consumption" class="form-label">Consumption</label>
                <input type="number" class="form-control" id="consumption" name="consumption">
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price">
              </div>
              <div class="mb-3">
                <label for="options" class="form-label">Car options</label>
                <input type="text" class="form-control" id="options" name="options">
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="published" name="published">
                <label class="form-check-label" for="published">Published</label>
              </div>
              <div class="mb-3 form-check">
                <label class="form-check-label" for="category_id">Category</label>
                <!-- <br> -->
                <select name="category_id" id="" class="form-check-select">
                  <option value="">please select a car</option>
                  <?php
                  foreach ($result as $category_name) {
                    ?>
                    <option value="<?php echo $category_name['cat_id'] ?>">
                      <?php echo $category_name['category_name'] ?>
                    </option>
                    <?php
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="image" class="form-label">Car Image</label>
                <input type="file" class="form-control" id="image" name="image">
              </div>
              <button type="submit" class="btn btn-primary">Insert car</button>
            </form>
          </div>
        </div>
      </div>

      <?php
      include_once('includes/footerJS.php')
        ?>
</body>

</html>