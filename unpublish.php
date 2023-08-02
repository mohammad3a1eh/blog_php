<?php


require_once "config.php";
require_once "class\class.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    header("Location:accept_post_list.php?message=Id not found!!!");
}

$connection = new database();
$connection->start();
$connection->setQuery("update posts set status=0 where id='$id'");
$result = $connection->getQueryResult();

header("Location:posts.php?message=unpublish successfully!");

