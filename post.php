<?php

require_once "config.php";
require_once "class\class.php";

session_start();

$message = "";

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $user_auth = new database();
    $user_auth->start();
    $user_auth->setQuery("select admin from users where username='$username'");
    $user_auth->fetch_row();
    $admin = $user_auth->getFetch()[0];
} else {
    $admin = null;
}


if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $get_post = new database();
    $get_post->start();
    $get_post->setQuery("SELECT * FROM posts WHERE id='$id'");
    $get_post->fetch_assoc();
    $post = $get_post->getFetch();


    $post_id = $post["id"];


    $get_comment = new database();
    $get_comment->start();
    $get_comment->setQuery("SELECT * FROM comments WHERE postid='$post_id' and postid=1 ");
    $get_comment->fetch_all();
    $comments = $get_comment->getFetch();


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

        $new_comment = new database();
        $new_comment->start();
        $new_comment->setQuery("insert into comments (user, postid, comment ) values ('$username', '$post_id', '$comment')");
        $result_add_comment = $new_comment->getQueryResult();

        if ($result_add_comment == true) {
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



<html>

<title>User Register</title>
<link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="css/main.css" rel="stylesheet">
<script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="js/main.js" ></script>

<body>
<main class="form-signin w-100 m-auto" id="form_new_post">


    <?php if ($status) { ?>
        <?php if (isset($_SESSION["username"])) { if ($_SESSION["username"] == $post["user"]) { ?>
            <a href="edit_post.php?id=<?php echo $post["id"]?>">Edit</a>
        <?php } } ?>

    <p class="fs-2"><?php echo $post["title"] ?></p>
    <hr>
    <p class="fs-6 multiline"><?php echo $post["discription"] ?></p>

    <p class="fs-5 multiline"><?php echo $post["content"] ?></p>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><?php echo $post["user"] . " in " . $post["date"] ?> </li>
        </ol>
    </nav>
        <?php if (isset($_SESSION["username"])) { if ($_SESSION["username"] == $post["user"] ) { ?>
            <a class="btn btn-danger" href="drop.php?id=<?php echo $post["id"] ?>">Drop</a>
        <?php } } ?>
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
