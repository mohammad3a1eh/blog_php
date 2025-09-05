<?php if (isset($_SESSION["username"])) {
    $user = $_SESSION["username"]; ?>


    <?php if (file_exists("profiles/$user/profile.jpeg")) { ?>

        <img src="profiles/<?php echo $user ?>/profile.jpeg" alt="mdo" width="32" height="32" class="rounded-circle">

    <?php } else { ?>
        <img src="res/profile.png" alt="mdo" width="32" height="32" class="rounded-circle">

    <?php } ?>


<?php } else { ?>

    <img src="res/profile.png" alt="mdo" width="32" height="32" class="rounded-circle">

<?php } ?>
