<?php
session_start();

require_once "config.php";

$con = mysqli_connect(DATABASE_HOST,DATABASE_USER,DATABASE_PASS,DATABASE_NAME) or die('Unable To connect');

$query = "SELECT * FROM posts where status=1";
$result = mysqli_query($con, $query);
$result = mysqli_fetch_all($result);


?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css" >
</head>

<body>

<?php require_once "header.php" ?>
<div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center" >
    <div class="list-group" id="list_item">
<?php foreach ($result as $key => $value) { ?>

            <a href="post.php?id=<?php echo $value[0] ?>" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                <div class="d-flex gap-2 w-100 justify-content-between">
                    <div>
                        <h6 class="mb-0"><?php echo $value[1] ?></h6>
                        <span class="d-inline-block text-truncate" style="max-width: 150px;"><?php echo $value[2] ?></span>
                    </div>
                    <small class="opacity-50 text-nowrap"><?php echo $value[4] ?></small>
                </div>
            </a>
<?php } ?>
    </div>
</div>
</body>

</html>
