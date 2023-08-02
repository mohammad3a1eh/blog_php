<?php

require_once "config.php";
require_once "class\class.php";

session_start();
$connection = new database();
$connection->start();

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}

if (!isset($_SESSION["username"])) {
    header("Location:index.php");
    die();
} else {
    $username = $_SESSION["username"];

    $connection->setQuery("select admin from users where username='$username'");
    $connection->fetch_row();
    $admin = $connection->getFetch();

    if ($admin[0] == 0) {
        header("Location:index.php");
        die();
    }

    $results_per_page = RESULTS_PER_PAGE;

    $connection->setQuery("select * from posts where status=0");
    $connection->num_row();
    $number_of_result = $connection->getFetch();

    $number_of_page = ceil($number_of_result / $results_per_page);

    if (!isset($_GET["page"])) {
        $page = 1;
    } else {
        $page = $_GET["page"];
    }

    $page_first_result = ($page - 1) * $results_per_page;
    $query = "select * from posts  where status=0 limit $page_first_result ,$results_per_page";
    $connection->setQuery("select * from posts  where status=0 limit $page_first_result ,$results_per_page");
    $posts = $connection->getQueryResult();


}


?>

<?php require_once "header.php" ?>

<html>

<head>
    <title>User Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>
<body>

<main class="form-signin w-100 m-auto" id="form_new_post">
    <?php require_once "msg.php" ?>
</main>

<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
    <div class="list-group" id="list_item">


        <?php require_once "list_pagination_accept.php" ?>


    </div>
</div>


</body>
</html>