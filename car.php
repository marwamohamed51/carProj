<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    $title = "Car List";
    include_once('includes/head.php'); ?>
</head>

<body>
    <?php
    include_once('includes/topbar.php');
    include_once('includes/navbar.php');
    include_once('includes/search.php');
    include_once('includes/car_pageHeader.php');
    include_once('includes/rentCar.php');
    include_once('includes/banner2.php');
    include_once('includes/vendor.php');
    include_once('includes/footer.php');
    include_once('includes/backToUp.php');
    include_once('includes/jsFooter.php');

    ?>

</body>

</html>