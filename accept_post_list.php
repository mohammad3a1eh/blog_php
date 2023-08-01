<?php

require_once "config.php";

session_start();

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}

if (! isset($_SESSION["username"])) {
    header("Location:index.php");
    die();
} else {
    $username = $_SESSION["username"];
    $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');
    $result = mysqli_query($con, "select admin from users where username='$username'");
    $result = mysqli_fetch_row($result);

    if ($result[0] == 0) {
        header("Location:index.php");
        die();
    }

    $results_per_page = 5;

    $query = "select * from posts where status=0";
    $result2 = mysqli_query($con, $query);
    $number_of_result = mysqli_num_rows($result2);


    $number_of_page = ceil ($number_of_result / $results_per_page);


    if (! isset($_GET["page"])) {
        $page = 1;
    } else {
        $page = $_GET["page"];
    }

    $page_first_result = ($page-1) * $results_per_page;
    $query = "select * from posts  where status=0 limit $page_first_result ,$results_per_page";
    $result2 = mysqli_query($con, $query);



}


?>

<?php require_once "header.php" ?>


<html>

<head>
    <title>User Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/main.js" ></script>
</head>
<body>

<main class="form-signin w-100 m-auto" id="form_new_post">
    <?php require_once "msg.php" ?>
</main>

<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center" >
    <div class="list-group" id="list_item">


<?php require_once "list_pagination_accept.php" ?>


    </div>
</div>


</body>
</html>