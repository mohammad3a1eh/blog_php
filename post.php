<?php

require_once "config.php";
require_once "class\class.php";

session_start();

$message = "";
$connection = new database();
$connection->start();
$post = null;

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $connection->setQuery("select admin from users where username='$username'");
    $connection->fetch_row();
    $admin = $connection->getFetch()[0];
} else {
    $admin = null;
}


if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $connection->setQuery("SELECT * FROM posts WHERE id='$id'");
    $connection->fetch_assoc();
    $post = $connection->getFetch();


    $post_id = $post["id"];

    $connection->setQuery("SELECT * FROM comments WHERE postid='$post_id' and status=1 ");
    $connection->fetch_all();
    $comments = $connection->getFetch();


    if (is_null($comments)) {
        $status_comment = false;
    } else {
        $status_comment = true;
    }

    $status = true;

    if (isset($_POST["comment"])) {
        $username = $_SESSION["username"];
        $comment = $_POST["comment"];
        $datetime = date("Y/m/d");

        $connection->setQuery("insert into comments (user, postid, comment ) values ('$username', '$post_id', '$comment')");
        $result_add_comment = $connection->getQueryResult();

        if ($result_add_comment) {
            $message = "The comment was successfully saved";
        } else {
            $message = "Problem saving post!";
        }
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
        <?php if (isset($_SESSION["username"])) {
            if ($_SESSION["username"] == $post["user"]) { ?>
                <a href="edit_post.php?id=<?php echo $post["id"] ?>">Edit</a>
            <?php }
        } ?>

        <p class="fs-2"><?php echo $post["title"] ?></p>
        <hr>
        <p class="fs-6 multiline"><?php echo $post["discription"] ?></p>

        <p class="fs-5 multiline"><?php echo $post["content"] ?></p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"
                    aria-current="page"><?php echo $post["user"] . " in " . $post["date"] ?> </li>
            </ol>
        </nav>
        <?php if (isset($_SESSION["username"])) {
            if ($_SESSION["username"] == $post["user"]) { ?>
                <a class="btn btn-danger" href="drop.php?id=<?php echo $post["id"] ?>">Drop</a>
            <?php }
        } ?>
        <?php if ($admin == 1) { ?>
            <a class="btn btn-primary" href="unpublish.php?id=<?php echo $post["id"] ?>">Unpublish</a>
        <?php } ?>


        <?php require_once "add_comment.php" ?>

    <?php } else {
        header("Location:index.php");
    } ?>


</main>
</body>

</html>
