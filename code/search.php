<?php
include "./admin/includes/connect.php";
include "./admin/includes/functions.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Product Detail</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.png" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>
    <?php

    $searching_products = $_SESSION["search"];
    if (!empty($searching_products)) {
        foreach ($searching_products as $key => $value) {
            $sql = "SELECT * FROM products WHERE product_id=$value";
            $result = mysqli_query($conn, $sql);
            $product_info = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
            <div class="card ml-5" style="width: 18rem;">
                <img class="card-img-top" alt="product image" src="<?php echo $product_info[0]['product_main_image']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo  $product_info[0]['product_name'] ?></h5>
                    <p class="card-text"><?php echo  $product_info[0]['product_description'] ?></p>
                    <a href="#" class="btn btn-primary">"single page here"</a>
                </div>
            </div>

    <?php }
    } else {
        redirect("error.php");
    }
    unset($_SESSION["search"]);
    print_r($_SESSION);
    ?>


</body>

</html>