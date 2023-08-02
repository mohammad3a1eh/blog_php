<?php
require_once "config.php";


$message = "";

if (isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["verify_password"]) and isset($_POST["email"]) and isset($_POST["submit"]) and isset($_POST["firstname"]) and isset($_POST["lastname"]) and isset($_POST["age"])) {

    if (!($_POST["password"] == $_POST["verify_password"])) {
        $message = "Invalid Verify Password!";
    } else {
        if ($_POST["username"] == "" or $_POST["password"] == "" or $_POST["verify_password"] == "" or $_POST["email"] == "" or $_POST["firstname"] == "" or $_POST["lastname"] == "" or $_POST["age"] == "") {
            $message = "Fields cannot be empty!";
        } else {

            $connection = new database();
            $connection->start();
            $connection->setQuery("SELECT * FROM users WHERE username='" . $_POST["username"] . "'");
            $connection->fetch_array();
            $result = $connection->getFetch();


            if (!is_null($result)) {
                $message = "Invalid username!";
            } else {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $age = (int)$_POST["age"];

                $connection->setQuery("insert into users (username, password, email,firstname ,lastname ,age) values ('$username', '$password', '$email', '$firstname', '$lastname', '$age')");
                $result = $connection->getQueryResult();

                if ($result) {
                    header("Location:login.php");
                } else {
                    $message = "Invalid Username or Password!";
                }
            }
        }
    }
}


?>

<html>
<head>
    <title>User Register</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>


<body class="d-flex align-items-center py-4 bg-body-tertiary">


<main class="form-signin w-100 m-auto" id="form">
    <form method="post" action="">

        <h1 class="h3 mb-3 fw-normal">Sign up</h1>

        <div class="form-floating">
            <input type="text" class="form-control" name="firstname" id="corner_t" placeholder="firstname">
            <label for="floatingInput">First name</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="lastname" id="center" placeholder="lastname">
            <label for="floatingInput">Last name</label>
        </div>
        <div class="form-floating">
            <input type="number" class="form-control" name="age" id="center" placeholder="age">
            <label for="floatingInput">Age</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="center" placeholder="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="center" placeholder="Email">
            <label for="floatingEmail">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="center" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
            <input type="password" name="verify_password" class="form-control" id="corner_b" placeholder="Password">
            <label for="floatingPassword">Verify Password</label>
        </div>


        <button class="btn btn-primary w-100 py-2" type="submit" name="submit">Sign up</button>
        <?php require_once "msg.php" ?>
        <p class="mt-5 mb-3 text-body-secondary">Do you have an account? <a href="login.php">Sign in</a> or <a
                    href="index.php">Home</a></p>
    </form>
</main>

</body>

</html>