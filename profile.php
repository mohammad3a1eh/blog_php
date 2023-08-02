<?php

require_once "config.php";
require_once "class\class.php";

session_start();

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}

$connection = new database();
$connection->start();


if (empty($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');

    $connection->setQuery("SELECT * FROM users WHERE username='$username'");
    $connection->fetch_assoc();
    $profile = $connection->getFetch();


    $status = true;
} else {
    $status = false;
}


if (isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["email"])) {

    if ($_POST["username"] == "" or $_POST["password"] == "" or $_POST["email"] == "") {
        $message = "Fields cannot be empty!";
    } else {
        $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');

        $connection->setQuery("SELECT * FROM users WHERE username='" . $_POST["username"] . "'");
        $connection->fetch_array();
        $profile_name = $connection->getFetch();

        if (!is_null($profile_name)) {
            $message = "Invalid username!";
        } else {
            $connection->setQuery("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
            $connection->fetch_array();
            $result = $connection->getFetch();

            var_dump($result);

            $message = "test";
            if (is_null($result)) {
                $message = "Invalid title!";
            } else {
                $user = $_SESSION['username'];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];

                $connection->setQuery("update users set username='$username', password='$password', email='$email' where username=$user");
                $result = $connection->getQueryResult();


                if ($result) {
                    header("Location:index.php?message=Save edits profile");
                } else {
                    $message = "Problem saving edit!";
                }
            }
        }
    }
}


?>


<html>

<head>
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="favorite.ico">
    <link href="css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>
<body>

<?php require_once "header.php" ?>
<?php if ($status) { ?>

    <main class="form-signin w-100 m-auto" id="form_new_post">
        <h1 class="h3 mb-3 fw-normal">Edit Profile</h1>


        <form method="post" action="upload_profile.php" enctype="multipart/form-data">
            <div class="input-group">
                <?php require_once "img_b.php" ?>
                <input type="file" class="form-control" name="pic" id="browse" aria-describedby="inputGroupFileAddon04"
                       aria-label="Upload">
                <button class="btn btn-outline-secondary" type="submit" id="browse_btn">Save</button>
            </div>
        </form>


        <form method="post" action="">
            <?php require_once "msg.php" ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="username"
                       value="<?php echo $profile["username"] ?>">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="password" id="password" placeholder="password"
                       value="<?php echo $profile["password"] ?>">
                <label for="floatingInput">Date</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="email"
                       value="<?php echo $profile["email"] ?>">
                <label for="floatingEmail">Email</label>
            </div>
            <div class="form-floating mb-3">
                <button type="submit" class="btn btn-primary">Save Form</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </div>
        </form>
    </main>
<?php } else {
    header("Location:index.php");
} ?>


</body>
</html>