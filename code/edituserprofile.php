<?php
session_start();
$image     = "";
$name      = "";
$email     = "";
$password  = "";
$gender    = "";
$mobile    = "";
$location  = "";

//Start Function
function redirect($url)
{
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit;
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }
}
//Connect
include('admin/includes/connect.php');

// start Edit 
$sql    = "SELECT * FROM users WHERE user_id='{$_SESSION["user_id"]}'";
$result = mysqli_query($conn, $sql);
$user   = mysqli_fetch_all($result, MYSQLI_ASSOC);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check    = 1;
    $image    = ($_FILES["userimg"]);
    $name     = ($_POST["name"]);
    $email    = strtolower($_POST["email"]);
    $password = ($_POST["password"]);
    $gender   = ($_POST["gender"]);
    $mobile   = ($_POST["mobile"]);
    $location   = ($_POST["location"]);

    // input validation 
    if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
        $nameError  = "Only letters and white space allowed";
        $check      = 0;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $emailError     = ("email is not a valid email address");
        $check          = 0;
    }
    if ($name == "") {

        $check          = 0;
        $nameError      = "The name shouldn't be empty!";
    }
    if ($email == "") {

        $check          = 0;
        $emailError     = "The email shouldn't be empty!";
    }
    if ($password == "") {

        $check          = 0;
        $passError      = "The password shouldn't be empty!";
    }
    if (!preg_match("/^[077|079|078]+[0-9]{7}$/", $mobile)) { //mobile 
        $mobileError  = "Only letters and white space allowed";
        $check      = 0;
    }
    if ($mobile == "") {

        $check          = 0;
        $mobileError      = "The mobile shouldn't be empty!";
    }


    if ($location == "") {

        $check              = 0;
        $locationError      = "The location shouldn't be empty!";
    }


    //Image File
    $image_folder   = "admin/uploads/user_image/";
    $target_file    = $image_folder . uniqid() . basename($image["name"]);
    $image_check    = ",user_image='$target_file'";
    if (($image["size"]) == 0) {
        $target_file    = $user['user_image'];
        $image_check    = "";
    }
    //print_r($image);

    move_uploaded_file($image["tmp_name"], $target_file);
    if ($check == 1) {
        $sql2 = "UPDATE users  SET user_name = '$name', user_email ='$email', user_mobile='$mobile', user_location='$location', user_password='$password', user_gender='$gender' {$image_check} WHERE user_id = '{$_SESSION["user_id"]}'";
        if ($conn->query($sql2) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn->error;
        }
        $conn->close();
        redirect("profile.php");
    }
}
?>

<!--Links -->

<head>
    <link rel="stylesheet" href="styling.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <link rel="stylesgeet" href="https://rawgit.com/creativetimofficial/material-kit/master/assets/css/material-kit.css">
    < </head>
        <!-- End Links -->

<body class="profile-page">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="page-header header-filter" data-parallax="true" style="background-image:url('images/product-04.jpg');"></div>
        <div class="main main-raised">
            <div class="profile-content" style="margin-bottom: 135px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 ml-auto mr-auto">
                            <div class="profile" style="text-align: center;">
                                <div class="avatar">
                                    <img src="<?php echo $user[0]['user_image'] ?>" alt="photo">
                                    <div class="file btn btn-lg btn-primary ck">
                                        <!-- Change Photo -->
                                        <input name="userimg" type="file" class="form-control" id="exampleInputPassword1">
                                    </div>
                                </div>
                                <div class="name">
                                    <h3 class="title"><?php echo $user[0]['user_name'] ?></h3>
                                    <h6 class="created"><?php echo "DATE CREATED: " . $user[0]['user_creation_date'] ?></h6>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row gutters ">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <h5 class="personal">Personal Details</h5>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group ii">
                                <label for="fullName" class="fullname">Full Name</label>
                                <input name="name" type="text" class="form-control" id="fullName" placeholder="Enter full name" value="<?php echo $user[0]['user_name']; ?>">
                            </div>
                            <div style="color:red"><?php echo @$nameError; ?></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group f ii">
                                <label for="eMail">Email</label>
                                <input name="email" type="email" class="form-control" id="eMail" placeholder="Enter email ID" value="<?php echo $user[0]['user_email']; ?>">
                            </div>
                            <div style="color:red"><?php echo @$emailError; ?></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group ii">
                                <label for="phone">Phone</label>
                                <input name="mobile" type="text" class="form-control" id="phone" placeholder="Enter phone number" value="<?php echo $user[0]['user_mobile']; ?>">
                            </div>
                            <div style="color:red"><?php echo @$mobileError; ?></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group f ii">
                                <label for="website">Password</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Enter your password" value="<?php echo $user[0]['user_password']; ?>">
                            </div>
                            <div style="color:red"><?php echo @$passError; ?></div>
                        </div>
                    </div>
                    <div class="row gutters">

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group ii">
                                <label for="Street">Gender</label>

                                <select name="gender" class="form-control col-9 mb-2" style="border: 1px solid #dce7f1 !important;">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female </option>
                                </select>
                            </div>
                            <div style="color:red"><?php echo @$genderError; ?></div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="form-group f ii">
                                <label for="ciTy">Location</label>
                                <input name="location" type="text" class="form-control" id="location" placeholder="Enter your Location" value="<?php echo $user[0]['user_location']; ?>">
                            </div>
                            <div style="color:red"><?php echo @$locationError; ?></div>
                        </div>

                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="text-right u z">
                                    <style>
                                        .savebtn {
                                            background-color: #7D7D7D;
                                        }

                                        .savebtn:hover {
                                            background-color: #8A2BE2;
                                        }
                                    </style>
                                    <button class="bc savebtn" type="submit" id="submit" name="submit" class="btn btn-primary">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </form>
</body>
<!--start form -->


<!-- End Form -->
<?php
$conn->close();
?>