<?php

require_once "config.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {header("Location:accept_post_list.php?message=Id not found!!!");}
$con = mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS,DATABASE_NAME) or die('Unable To connect');

$query = "delete from posts where id='$id'";
$result = mysqli_query($con, $query);

header("Location:accept_post_list.php?message=drop successfully!");
