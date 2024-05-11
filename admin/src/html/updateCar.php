<?php
include_once ('includes/loginChecker.php');
if (isset($_GET['id']) and $_GET['id'] > 0) {
    include_once ('../../conn.php');
    $id = $_GET['id'];

    // insert car into DB
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $model = $_POST['model'];
            $consumption = $_POST['consumption'];
            $options = $_POST['options'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $automatic = (isset($_POST['automatic']));
            $published = (isset($_POST['published']));
            if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
                include_once ('includes/upload.php');
                $carImage = $image_name;
            } else {
                $carImage = $_POST['oldImage'];
            }

            // include_once('includes/upload.php');
            $sql = "UPDATE `cars` SET `title` =?,`image` = ?, `content` = ?,`model` = ?,
            `automatic` = ?,`consumption` = ?,`options` = ?,`price` = ?,
            `category_id` = ?, `published` = ? WHERE `id` = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $title,
                $carImage,
                $content,
                $model,
                $automatic,
                $consumption,
                $options,
                $price,
                $category_id,
                $published,
                $id
            ]);
            header('location: carList.php');
            die;
            // echo "Your data inserted successfuly :)";
        } catch (PDOException $e) {
            echo $e->getMessage();

        }
        // $name = test_input($_POST["name"]);
    }
    //get current car detail
    try {
        $sql = 'SELECT * FROM `cars` WHERE id =?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $resultCar = $stmt->fetch();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // show categories in select tag
    try {
        $sql = 'SELECT * FROM `categories`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

}

?>
<!doctype html>
<html lang="en">

<head>
    <?php
    $title = "Update car";
    include_once ('includes/head.php');
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
                        <h2>Update Car</h2>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="name" class="form-label">Car title</label>
                                <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                                    name="title" value="<?php echo $resultCar['title'] ?>">
                            </div>
                            <div>
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content"
                                    name="content"><?php echo $resultCar['content'] ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="number" class="form-control" id="model" aria-describedby="emailHelp"
                                    name="model" value="<?php echo $resultCar['model'] ?>">
                            </div>
                            <div class="mb-3 form-check">
                                <label class="form-check-label" for="auto">Automatic</label>
                                <input type="checkbox" class="form-check-input" id="auto" name="automatic" <?php echo $resultCar['automatic'] ? "checked" : "" ?>>
                            </div>
                            <div class="mb-3">
                                <label for="consumption" class="form-label">Consumption</label>
                                <input type="number" class="form-control" id="consumption" name="consumption"
                                    value="<?php echo $resultCar['consumption'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price"
                                    value="<?php echo $resultCar['price'] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="options" class="form-label">Car options</label>
                                <input type="text" class="form-control" id="options" name="options"
                                    value="<?php echo $resultCar['options'] ?>">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="published" name="published" <?php echo $resultCar['published'] ? "checked" : "" ?>>
                                <label class="form-check-label" for="published">Published</label>
                            </div>
                            <div class="mb-3 form-check">
                                <label class="form-check-label" for="category_id">Category</label>
                                <!-- <br> -->
                                <select name="category_id" id="" class="form-check-select">
                                    <!-- <option value="">please select a car</option> -->
                                    <?php
                                    foreach ($result as $category_name) {
                                        ?>
                                        <option value="<?php echo $category_name['cat_id'] ?>" <?php echo $resultCar['category_id'] == $category_name['cat_id'] ? "selected" : "" ?>>
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
                                <br>
                                <img src="../assets/images/<?php echo $resultCar['image'] ?>"
                                    alt="<?php echo $resultCar['title'] ?>" style="width: 300px;">
                            </div>
                            <input type="hidden" name="oldImage" value="<?php echo $resultCar['image'] ?>">
                            <button type="submit" class="btn btn-primary">Update car</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            include_once ('includes/footerJS.php')
                ?>
</body>

</html>