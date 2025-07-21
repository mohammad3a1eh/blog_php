<?php

require_once __DIR__ . "/../lib/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";
$status = false;
$profile = null;

try {
    $pdo = new PDO("mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME, DATABASE_USER, DATABASE_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// گرفتن اطلاعات کاربر فعلی
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        $status = true;
    }
}

// پردازش فرم‌ها
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["form_type"])) {

    if ($_POST["form_type"] === "profile_edit") {
        // فرم ویرایش اطلاعات کاربری
        $newFirstname = trim($_POST["firstname"]);
        $newLastname  = trim($_POST["lastname"]);
        $newAge       = trim($_POST["age"]);
        $newUsername  = trim($_POST["username"]);
        $newEmail     = trim($_POST["email"]);

        if (
            empty($newFirstname) || empty($newLastname) || empty($newAge) ||
            empty($newUsername) || empty($newEmail)
        ) {
            $message = "All profile fields are required!";
        } else {
            // بررسی یکتا بودن نام کاربری
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND username != ?");
            $stmt->execute([$newUsername, $_SESSION['username']]);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                $message = "Username already taken!";
            } else {
                $stmt = $pdo->prepare("UPDATE users SET firstname = ?, lastname = ?, age = ?, username = ?, email = ? WHERE username = ?");
                $success = $stmt->execute([
                    $newFirstname, $newLastname, $newAge, $newUsername, $newEmail, $_SESSION['username']
                ]);

                if ($success) {
                    $_SESSION['username'] = $newUsername;
                    header("Location: index.php?message=Profile updated successfully");
                    exit;
                } else {
                    $message = "Error updating profile!";
                }
            }
        }
    } elseif ($_POST["form_type"] === "password_change") {
        $currentPassword = $_POST["current_password"] ?? '';
        $newPassword     = $_POST["new_password"] ?? '';
        $confirmPassword = $_POST["confirm_password"] ?? '';

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $message = "All password fields are required!";
        } elseif ($newPassword !== $confirmPassword) {
            $message = "New passwords do not match!";
        } else {
            // دریافت رمز هش‌شده فعلی از دیتابیس
            $stmt = $pdo->prepare("SELECT password FROM users WHERE username = ?");
            $stmt->execute([$_SESSION['username']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user || !password_verify($currentPassword, $user["password"])) {
                $message = "Current password is incorrect!";
            } else {
                // رمز جدید را هش کن و ذخیره کن
                $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
                $success = $stmt->execute([$hashedNewPassword, $_SESSION['username']]);

                if ($success) {
                    $message = "Password changed successfully.";
                } else {
                    $message = "Error changing password.";
                }
            }
        }
    }

}
?>

<!-- HTML -->
<html>

<head>
    <title>Profile</title>
    <link rel="icon" type="image/x-icon" href="favorite.ico">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
</head>

<body>

<?php require_once __DIR__ . "/parts/header.php" ?>
<?php if ($status) { ?>

    <main class="form-signin w-100 m-auto" id="form_new_post">
        <h1 class="h3 mb-3 fw-normal">Edit Profile</h1>

        <!-- فرم آپلود تصویر -->
        <form method="post" action="upload_profile.php" enctype="multipart/form-data">
            <div class="input-group">
                <?php require_once "img_b.php" ?>
                <input type="file" class="form-control" name="pic" id="browse" aria-describedby="inputGroupFileAddon04"
                       aria-label="Upload">
                <button class="btn btn-outline-secondary" type="submit" id="browse_btn">Save</button>
            </div>
        </form>

        <!-- پیام‌ها -->
        <?php require_once __DIR__ . "/parts/msg.php" ?>
        <?php if (!empty($message)) : ?>
            <div class="alert alert-info mt-3"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- فرم ویرایش اطلاعات کاربری -->
        <form method="post" action="">
            <input type="hidden" name="form_type" value="profile_edit">

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="firstname" placeholder="firstname"
                       value="<?php echo htmlspecialchars($profile["firstname"]) ?>">
                <label for="floatingInput">First Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="lastname" placeholder="lastname"
                       value="<?php echo htmlspecialchars($profile["lastname"]) ?>">
                <label for="floatingInput">Last Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="age" placeholder="age"
                       value="<?php echo htmlspecialchars($profile["age"]) ?>">
                <label for="floatingInput">Age</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="username" placeholder="username"
                       value="<?php echo htmlspecialchars($profile["username"]) ?>">
                <label for="floatingInput">Username</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" placeholder="email"
                       value="<?php echo htmlspecialchars($profile["email"]) ?>">
                <label for="floatingEmail">Email</label>
            </div>

            <div class="form-floating mb-3">
                <button type="submit" class="btn btn-primary">Save Profile</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>

        <br>
        <hr>
        <h1 class="h3 mb-3 fw-normal">Edit Password</h1>

        <!-- فرم تغییر رمز عبور -->
        <form method="post" action="" class="mt-5">
            <input type="hidden" name="form_type" value="password_change">

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="current_password" placeholder="Current Password" required>
                <label for="current_password">Current Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
                <label for="new_password">New Password</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" required>
                <label for="confirm_password">Confirm New Password</label>
            </div>

            <div class="form-floating mb-3">
                <button type="submit" class="btn btn-warning">Change Password</button>
            </div>
        </form>


    </main>

<?php } else {
    header("Location:index.php");
    exit;
} ?>

</body>
</html>
