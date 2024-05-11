<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    $title = "Booking";
    include_once('includes/head.php'); ?>
</head>

<body>
    <?php
    include_once('includes/topbar.php');
    include_once('includes/navbar.php');
    include_once('includes/search.php');
    include_once('includes/booking_pageHeader.php');
    include_once('includes/detail.php');
    include_once('includes/carBooking.php');
    include_once('includes/vendor.php');
    include_once('includes/footer.php');
    include_once('includes/backToUp.php');
    include_once('includes/jsFooter.php');
    ?>





</body>

</html>