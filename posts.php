<?php
session_start();

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}

require_once "config.php";

$con = mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS,DATABASE_NAME) or die('Unable To connect');


$results_per_page = 5;

$query = "select * from posts where status=1";
$result = mysqli_query($con, $query);
$number_of_result = mysqli_num_rows($result);


$number_of_page = ceil ($number_of_result / $results_per_page);

if (! isset($_GET["page"])) {
    $page = 1;

} else {
    $page = $_GET["page"];
}

$page_first_result = ($page-1) * $results_per_page;
$query = "select * from posts  where status=1 limit $page_first_result ,$results_per_page";
$result2 = mysqli_query($con, $query);





?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css" >
</head>

<body>


<?php require_once "header.php" ?>

<main class="form-signin w-100 m-auto" id="form_new_post">
    <?php require_once "msg.php" ?>
</main>
<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center" >
    <div class="list-group" id="list_item">


        <?php require_once "list_pagination.php" ?>


    </div>
</div>
</body>

</html>
