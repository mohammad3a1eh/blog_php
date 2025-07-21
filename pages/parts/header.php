<?php require_once "config.php" ?>

<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap">
                    <use xlink:href="#bootstrap"/>
                </svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="index.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="posts.php" class="nav-link px-2 link-body-emphasis">Posts</a></li>

                <?php if (isset($_SESSION['username'])) { ?>
                    <li><a href="new_post.php" class="nav-link px-2 link-body-emphasis">New Post</a></li>
                <?php } ?>
            </ul>


            <div class="dropdown text-end">
                <?php if (isset($_SESSION["username"])) { ?>
                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <?php require_once "img.php" ?>
                    </a>

                    <ul class="dropdown-menu text-small">
                        <li><a class="dropdown-item" href="profile.php">Profile <?php echo $_SESSION["username"] ?></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                        <?php }
                        if (isset($_SESSION["username"])) {
                            $username = $_SESSION["username"];

                            try {
                                $pdo = new PDO("mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME . ";charset=utf8", DATABASE_USER, DATABASE_PASS);
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE username = :username");
                                $stmt->execute([':username' => $username]);
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                            } catch (PDOException $e) {
                                die("Database error: " . $e->getMessage());
                            }
                            ?>

                            <ul class="nav">
                                <?php
                                if ($result && $result['is_admin'] == 1) {
                                    ?>
                                    <li><a href="accept_post_list.php?page=1" class="dropdown-item">Posts pending approval</a></li>
                                    <li><a href="accept_comment_list.php?page=1" class="dropdown-item">Comments pending approval</a></li>
                                    <?php
                                }
                                ?>
                            </ul>

                            <?php
                        } else {
                            ?>
                            <ul class="nav">
                                <li class="nav-item"><a href="/auth/login" class="nav-link link-body-emphasis px-2">Login</a></li>
                                <li class="nav-item"><a href="/auth/register" class="nav-link link-body-emphasis px-2">Sign up</a></li>
                            </ul>
                            <?php
                        }
                        ?>


            </div>
        </div>
    </div>
</header>