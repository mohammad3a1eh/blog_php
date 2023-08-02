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
$connection->setQuery("update comments set status=1 where id='$id'");
$result = $connection->getQueryResult();

header("Location:accept_comment_list.php?message=publish successfully!");

