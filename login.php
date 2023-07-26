<?php

require_once "config.php";

session_start();
$message="";


if(isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["submit"])) {

    if ($_POST["username"] == "" or $_POST["password"] == "") {
        $message = "Fields cannot be empty!";
    } else {


        $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');
        $result = mysqli_query($con, "SELECT * FROM users WHERE username='" . $_POST["username"] . "' and password = '" . $_POST["password"] . "'");
        $row = mysqli_fetch_array($result);
        if (is_array($row)) {
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $row['username'];
        } else {
            $message = "Invalid Username or Password!";

        }
    }
    if (isset($_SESSION["id"])) {
        header("Location:index.php");
    }
}
?>
<html>
<head>
    <title>User Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>



<body class="d-flex align-items-center py-4 bg-body-tertiary">


<main class="form-signin w-100 m-auto" id="form">
    <form method="post" action="">

        <h1 class="h3 mb-3 fw-normal">Sign in</h1>


        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="corner_t" placeholder="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="corner_b" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>



        <button class="btn btn-primary w-100 py-2" type="submit" name="submit">Sign in</button>

        <?php require_once "msg.php" ?>

        <p class="mt-5 mb-3 text-body-secondary">Don't have an account? <a href="register.php">Sign up</a> or <a href="index.php">Home</a></p>
    </form>
</main>

</body>
</html>