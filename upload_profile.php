<?php

session_start();

if (empty($_SESSION["username"])) {
    header("Location:index.php");
} else {



    $user = $_SESSION['username'];

    var_dump($_FILES);

    if ($_FILES['pic']['type'] == "image/jpeg") {
        $type = ".jpeg";
    } else {
        $type = "invalid";
        header("Location:profile.php?message=You should only use jpeg!");
    }

    if (isset($_FILES['pic']) and ! ($type == "invalid")) {
        if (file_exists($_FILES['pic']['tmp_name'])) {

            if (!is_dir("profile/$user")) {
                mkdir("profile/$user");
            }

            $path = "profile/$user/profile$type";
            $file = $_FILES['pic']['tmp_name'];

            if (move_uploaded_file($file, $path)) {
                header("Location:profile.php?message=Profile picture uploaded successfully!");
            }
        }
    } else {
        header("Location:profile.php?message=It was not successful!");
    }
}

