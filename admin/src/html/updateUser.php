<?php
$nameErr = $emailErr = $passErr = "";
$err = 0;
include_once('../../conn.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        try{
        $name = $_POST['name'];
        $email = $_POST['email'];
        if(empty($_POST['password'])){
            $password = $_POST['oldPassword'];
        }else{
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }
        $active = isset($_POST['active']);

        $sql = "UPDATE `users` SET `name`=?,`password`=?,`email`=?,`active`=? WHERE `id` =?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $password,$email,$active, $id]);
        header('location: users.php');
        die;
    }catch (PDOException $e) {
        echo $e->getMessage();

    }
}

    try {
        $sql = 'SELECT * FROM `users` WHERE `id` = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        $name = $result['name'];
        $password = $result['password'];
        $email = $result['email'];
        $active = $result['active'] ? "checked" : "";
    } catch (PDOException $e) {
        echo $e->getMessage();

    }

}
?>
<!doctype html>
<html lang="en">

<head>
    <?php
    $title = "Update User";
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
                        <h2>Update User</h2>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" aria-describedby="emailHelp"
                                    name="name" value="<?php echo $name; ?>">
                                <span class="error">
                                    <?php echo $nameErr; ?>
                                </span>
                                <br>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp" name="email" value="<?php echo $email; ?>">
                                <span class="error">
                                    <?php echo $emailErr; ?>
                                </span>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.
                                </div>
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
                                <input type="checkbox" class="form-check-input" id="active" name="active" <?php echo $active; ?>>
                                <label class="form-check-label" for="active">Active</label>
                                <br>
                            </div>
                            <input type="hidden" name="oldPassword" value="<?php echo $password; ?>" >
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php
            include_once('includes/footerJS.php')
                ?>
</body>

</html>