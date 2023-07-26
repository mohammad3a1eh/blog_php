

<?php

require_once "config.php";

session_start();

if (isset($_GET["message"])) {
    $message = $_GET["message"];
} else {
    $message = "";
}


if(empty($_SESSION['username']))
{
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);
    $result = mysqli_fetch_assoc($result);

    $status = true;
} else {
    $status = false;
}


if (isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["email"])) {

    if ($_POST["username"] == "" or $_POST["password"] == "" or $_POST["email"] == "") {
        $message = "Fields cannot be empty!";
    } else {
        $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');

        $query = "SELECT * FROM users WHERE username='" . $_POST["username"] . "'";
        $result = mysqli_query($con, $query);
        $result = mysqli_fetch_array($result);

        var_dump($result);

        if (!is_null($result)) {
            $message = "Invalid username!";
        } else {
            echo $_POST["title"];
            $query = "SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'";
            $result = mysqli_query($con, $query);
            $result = mysqli_fetch_array($result);
            $message = "test";
            if (!is_null($result)) {
                $message = "Invalid title!";
            } else {
                $user = $_SESSION['username'];
                $username = $_POST["username"];
                $password = $_POST["password"];
                $email = $_POST["email"];
                $query = "update users set username='$username', password='$password', email='$email' where username=$user";
                $result = mysqli_query($con, $query);
                if ($result) {
                    header("Location:index.php?message=Save edits profile");
                } else {
                    $message = "Problem saving edit!";
                }
            }
        }
    }
}

if (isset($_FILES["image"]["name"])) {
    var_dump($_FILES["image"]["name"]);
}

?>


<html>

<head>
    <title>User Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="css/main.css" rel="stylesheet">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="js/main.js" ></script>
</head>
<body>

<?php require_once "header.php" ?>
<?php if ($status) { ?>

    <main class="form-signin w-100 m-auto" id="form_new_post">
        <h1 class="h3 mb-3 fw-normal">Edit Profile</h1>



        <form method="post" action="upload_profile.php" enctype="multipart/form-data">
            <div class="input-group">
                <?php require_once "img_b.php" ?>
                <input type="file" class="form-control" name="pic" id="browse" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                <button class="btn btn-outline-secondary" type="submit" id="browse_btn">Save</button>
            </div>
        </form>


        <form method="post" action="">
            <?php require_once "msg.php" ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="username" placeholder="username" value="<?php echo $result["username"] ?>">
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating mb-3" >
                <input type="text" class="form-control" name="password" id="password"  placeholder="password"  value="<?php echo $result["password"] ?>">
                <label for="floatingInput">Date</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="email" value="<?php echo $result["email"] ?>">
                <label for="floatingEmail">Email</label>
            </div>
            <div class="form-floating mb-3" >
                <button type="submit" class="btn btn-primary">Save Form</button>
                <button type="reset" class="btn btn-secondary">Reset Form</button>
            </div>
        </form>
    </main>
<?php } else { header("Location:index.php"); }?>



</body>
</html>