<?php
include_once('includes/loginChecker.php');
if (isset($_GET['id'])) {
    include_once('../../conn.php');
    try {
        $id = $_GET['id'];
        $sql = 'DELETE FROM `users` WHERE `id` = ?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
        // echo "deleted";
        header('location: users.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
