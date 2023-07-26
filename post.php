<?php

require_once "config.php";

session_start();

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');

    $query = "SELECT * FROM posts WHERE id='$id'";
    $result = mysqli_query($con, $query);
    $result = mysqli_fetch_assoc($result);

    $status = true;
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

    <a href="edit_post.php?id=<?php echo $result["id"]?>">Edit</a>
    <p class="fs-2"><?php echo $result["title"] ?></p>
    <hr>
    <p class="fs-6 multiline"><?php echo $result["discription"] ?></p>

    <p class="fs-5 multiline"><?php echo $result["content"] ?></p>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page"><?php echo $result["date"] ?></li>
        </ol>
    </nav>
    <?php } else {
        header("Location:index.php");
    } ?>


</main>
</body>

</html>
