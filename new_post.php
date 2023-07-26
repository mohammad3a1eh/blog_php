<?php

require_once "config.php";

session_start();
if(empty($_SESSION['username']))
{
    header('Location: index.php');
    exit;
}

$message = "";

    if (isset($_POST["title"]) and isset($_POST["discription"]) and isset($_POST["content"]) and isset($_POST["date"])) {

        if ($_POST["title"] == "" or $_POST["discription"] == "" or $_POST["content"] == "" or $_POST["date"] == "") {
            $message = "Fields cannot be empty!";
        } else {
            $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');
            echo $_POST["title"];
            $query = "SELECT * FROM posts WHERE title='" . $_POST["title"] . "'";
            $result = mysqli_query($con, $query);
            $result = mysqli_fetch_array($result);
            $message = "test";
            if (!is_null($result)) {
                $message = "Invalid title!";
            } else {
                $title = $_POST["title"];
                $discription = htmlspecialchars($_POST["discription"]);
                $content = htmlspecialchars($_POST["content"]);
                $date = $_POST["date"];
                $query = "insert into posts (title, discription, content, date) values ('$title', '$discription', '$content', '$date')";
                $result = mysqli_query($con, $query);

                echo $result;

                if ($result) {
                    header("Location:index.php?message=The post was successfully saved");
                } else {
                    $message = "Problem saving post!";
                }
            }
        }
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
<main class="form-signin w-100 m-auto" id="form_new_post">
    <h1 class="h3 mb-3 fw-normal">Create Now Post</h1>
    <form method="post" action="">
        <?php require_once "msg.php" ?>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatingInput" name="title" placeholder="title" >
            <label for="floatingInput">Title</label>
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Discription" name="discription" id="discription" ></textarea>
            <label for="floatingTextarea">Discription</label>
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Content" name="content" id="content" ></textarea>
            <label for="floatingTextarea">Content</label>
        </div>
        <div class="form-floating mb-3" >
            <input type="date" class="form-control" name="date" id="date"  placeholder="date" onfocus="set_datetime()" >
            <label for="floatingInput">Date</label>
        </div>
        <div class="form-floating mb-3" >
            <button type="submit" class="btn btn-primary">Save Form</button>
            <button type="reset" class="btn btn-secondary">Reset Form</button>
        </div>
    </form>
</main>


</body>
</html>