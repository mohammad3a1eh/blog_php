<?php
session_start();

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}



?>
<html>
<head>
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="favorite.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/main.js" ></script>
</head>
<body">


<?php require_once "header.php" ?>

<main class="form-signin w-100 m-auto" id="form_new_post">

<?php require_once "msg.php" ?>



</main>


</body>
</html>