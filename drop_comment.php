<?php

require_once "config.php";
require_once "class\class.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    header("Location:accept_comment_list.php?message=Id not found!!!");
}

$connection = new database();
$connection->start();
$connection->setQuery("delete from comments where id='$id'");




header("Location:accept_comment_list.php?message=drop successfully!");