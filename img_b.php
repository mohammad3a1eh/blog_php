<?php if (isset($_SESSION["username"])) { $user = $_SESSION["username"]; ?>

    <?php if (file_exists("profiles/$user/profile.jpeg")) { ?>

        <img src="profiles/<?php echo $user ?>/profile.jpeg" class="rounded-circle float-start" id="profile">

    <?php } else { ?>

        <img src="res/profile.png" class="rounded float-start" id="profile">

    <?php } ?>

<?php } else { ?>

    <img src="res/profile.png" class="rounded float-start" id="profile">

<?php } ?>
