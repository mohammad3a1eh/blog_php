<?php

require_once "config.php";
require_once "class\class.php";

session_start();

$connecion = new database();
$connecion->start();
$message = "";

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $connecion->setQuery("SELECT * FROM posts WHERE id='$id'");
    $connecion->fetch_assoc();
    $post = $connecion->getFetch();

    $status = true;
} else {
    $status = false;
}

if (isset($_POST["title"]) and isset($_POST["discription"]) and isset($_POST["content"]) and isset($_POST["date"]) and isset($_POST["id"])) {

    if ($_POST["title"] == "" or $_POST["discription"] == "" or $_POST["content"] == "" or $_POST["date"] == "") {
        $message = "Fields cannot be empty!";
    } else {
        $con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME) or die('Unable To connect');

        $connecion->setQuery("SELECT * FROM posts WHERE title='" . $_POST["title"] . "'");
        $connecion->fetch_array();
        $resultcomment = $connecion->getFetch();

        $message = "test";
        if (!is_null($resultcomment)) {
            $message = "Invalid title!";
        } else {
            $title = $_POST["title"];
            $discription = htmlspecialchars($_POST["discription"]);
            $content = htmlspecialchars($_POST["content"]);
            $date = $_POST["date"];
            $id = $_POST["id"];

            $connecion->setQuery("update posts set title='$title', discription='$discription', content='$content', date='$date' where id=$id");
            $resultedit = $connecion->getQueryResult();

            if ($resultedit) {
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
        <h1 class="h3 mb-3 fw-normal">Edit Post</h1>
        <form method="post" action="">
            <?php if (!($message == "")) { ?>
                <div class="alert alert-primary" role="alert">
                    <?php echo $message ?>
                </div>
            <?php } ?>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="title" placeholder="title"
                       value="<?php echo $post["title"] ?>">
                <label for="floatingInput">Title</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Discription" name="discription"
                          id="discription"><?php echo $post["discription"] ?></textarea>
                <label for="floatingTextarea">Discription</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="Content" name="content"
                          id="content"><?php echo $post["content"] ?></textarea>
                <label for="floatingTextarea">Content</label>
            </div>
            <div class="form-floating mb-3">
                <input type="date" class="form-control" name="date" id="date" placeholder="date"
                       onfocus="set_datetime()" value="<?php echo $post["date"] ?>">
                <label for="floatingInput">Date</label>
            </div>
            <input type="text" value="<?php echo $_GET["id"] ?>" hidden="hidden" name="id">
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