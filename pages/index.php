<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}



?>
<html>
<head>
    <title>Home</title>
    <link rel="icon" type="image/x-icon" href="../index.php">
    <link href="../css/bootstrap.min.css" rel="stylesheet" >
    <script src="../js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/main.css">
    <script src="../js/main.js" ></script>
</head>
<body">


<?php require_once __DIR__ . "/parts/header.php" ?>

<main class="form-signin w-100 m-auto" id="form_new_post">

<?php require_once __DIR__ . "/parts/msg.php" ?>



</main>


</body>
</html>