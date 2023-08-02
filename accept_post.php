<?php

require_once "config.php";
require_once "class\class.php";

session_start();

$message = "";

$connection = new database();
$connection->start();
$admin = 0;
$result_post = null;

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $connection->setQuery("SELECT * FROM posts WHERE id='$id'");
    $connection->fetch_assoc();
    $result_post = $connection->getFetch();

    $get_comment = $result_post["id"];

    $connection->setQuery("SELECT * FROM comments WHERE postid='$get_comment' and status=0 ");
    $connection->fetch_all();
    $comments = $connection->getFetch();

    $status = true;

    if (isset($_SESSION["username"])) {
        $username = $_SESSION["username"];
        $connection->setQuery("select admin from users where username='$username'");
        $connection->fetch_row();
        $admin = $connection->getFetch()[0];
    }
} else {
    $status = false;
}

?>


<?php require_once "header.php" ?>


<html lang="en">

<title>User Register</title>
<link href="css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="css/main.css" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
<script src="js/main.js"></script>

<body>
<main class="form-signin w-100 m-auto" id="form_new_post">


    <?php if ($status) { ?>
        <?php if ($admin == 1) { ?>
            <a href="edit_post.php?id=<?php echo $result_post["id"] ?>">Edit</a>
        <?php } ?>

        <p class="fs-2"><?php echo $result_post["title"] ?></p>
        <hr>
        <p class="fs-6 multiline"><?php echo $result_post["discription"] ?></p>

        <p class="fs-5 multiline"><?php echo $result_post["content"] ?></p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><?php echo $result_post["date"] ?></li>
            </ol>
        </nav>

        <a class="btn btn-primary" href="publish.php?id=<?php echo $result_post["id"] ?>">Publish</a>
        <a class="btn btn-danger" href="drop.php?id=<?php echo $result_post["id"] ?>">Drop</a>

    <?php } else {
        header("Location:index.php");
    } ?>


</main>
</body>

</html>
