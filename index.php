<?php
include "./Model/User.php";
include "./Model/API.php";
include "./Model/DBConfig.php";
include "./Model/Shoes_Type.php";
include "./Model/Brand.php";
include "./Model/Size.php";
include "./Model/Product.php";
include "./Model/Address_Order.php";
include "./Model/Order.php";
include "./Model/Contact.php";
include "./Model/Status.php";
include "./Model/Goods_sold.php";
include "./Model/Comment.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shop giày</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="utf-8">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://unpkg.com/sweetalert2@11"></script>
    <link rel="apple-touch-icon" href="assets/img/apple-icon.png">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="./View/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./View/assets/css/templatemo.css">
    <link rel="stylesheet" href="./View/assets/css/custom.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="./View/assets/css/fontawesome.min.css">
</head>

<body>
    <?php
    include_once './View/header.php';
    ?>


    <?php
    $action = 'home';
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
    }

    if ($action == 'info_user' && !isset($_SESSION['user_id']) && !isset($_SESSION['lastname'])) {
        include_once "./Controller/home.php";
    } else if ($action == 'user' && isset($_GET['act']) && $_GET['act'] == 'register' && isset($_SESSION['user_id']) && isset($_SESSION['lastname'])) {
        include_once "./Controller/shop.php";
    } else if ($action == 'user' && isset($_GET['act']) && $_GET['act'] == 'login' && isset($_SESSION['user_id']) && isset($_SESSION['lastname'])) {
        include_once "./Controller/shop.php";
    } else if ($action == 'order_history' && !isset($_SESSION['user_id'])) {
        include_once "./Controller/shop.php";
    } else {
        include_once "./Controller/$action.php";
    }
    ?>

    <?php
    include_once './View/footer.php';
    ?>

    <!-- Start Script -->
    <!-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> -->
    <script src="./View/assets/js/jquery-1.11.0.min.js"></script>
    <script src="./View/assets/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="./View/assets/js/bootstrap.bundle.min.js"></script>    
    <script src="./View/assets/js/templatemo.js"></script>
    <script src="./View/assets/js/custom.js"></script>
    <script src="ajax/login.js"></script>
    <script src="ajax/User.js"></script>
    <script src="ajax/Cart.js"></script>
    <script src="ajax/Product.js"></script>
    <script src="ajax/Details_Product.js"></script>
    <script src="ajax/Address_Order.js"></script>
    <script src="ajax/Order.js"></script>
    <script src="ajax/PHPMailer.js"></script>
    <script src="ajax/home.js"></script>
    <script src="ajax/Contact.js"></script>
    <script src="ajax/Info_user.js"></script>
    <script src="ajax/validate.js"></script>
    <script src="ajax/comment.js"></script>
    <script src="ajax/change_password.js"></script>
    <script src="./View/assets/ajax/upload_img.js"></script>


    <!-- End Script -->

</body>

</html>