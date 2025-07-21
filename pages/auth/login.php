<?php
require_once __DIR__ . "/../../lib/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = "";

if (isset($_POST["username"], $_POST["password"], $_POST["submit"])) {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if ($username === "" || $password === "") {
        $message = "Fields cannot be empty!";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION["id"] = $user['id'];
            $_SESSION["username"] = $user['username'];
            header("Location: /");
            exit;
        } else {
            $message = "Invalid Username or Password!";
        }
    }
}
?>


<html>
<head>
    <title>User Login</title>
    <link rel="icon" type="image/x-icon" href="favorite.ico">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/main.js"></script>
</head>


<body class="d-flex align-items-center py-4 bg-body-tertiary">


<main class="form-signin w-100 m-auto" id="form">
    <form method="post" action="">

        <h1 class="h3 mb-3 fw-normal">Sign in</h1>


        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="corner_t" placeholder="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="corner_b" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>


        <button class="btn btn-primary w-100 py-2" type="submit" name="submit">Sign in</button>

        <?php require_once __DIR__ . "/../parts/msg.php" ?>

        <p class="mt-5 mb-3 text-body-secondary">Don't have an account? <a href="/auth/register">Sign up</a> or <a
                    href="/">Home</a></p>
    </form>
</main>

</body>
</html>