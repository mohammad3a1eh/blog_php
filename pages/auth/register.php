<?php

require_once __DIR__ . "/../../lib/config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["id"])) {
    header("Location: /");
    exit;
}

$message = "";

if (
    isset($_POST["username"], $_POST["password"], $_POST["verify_password"], $_POST["email"],
        $_POST["firstname"], $_POST["lastname"], $_POST["age"], $_POST["submit"])
) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];
    $verify_password = $_POST["verify_password"];
    $email = trim($_POST["email"]);
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $age = (int)$_POST["age"];

    if ($password !== $verify_password) {
        $message = "Invalid Verify Password!";
    } elseif (
        $username === "" || $password === "" || $verify_password === "" || $email === "" ||
        $firstname === "" || $lastname === "" || empty($age)
    ) {
        $message = "Fields cannot be empty!";
    } else {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingUser) {
            $message = "Username already exists!";
        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, password, email, firstname, lastname, age)
                                   VALUES (:username, :password, :email, :firstname, :lastname, :age)");

            $result = $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
                ':email' => $email,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':age' => $age
            ]);

            if ($result) {
                header("Location: /auth/login");
                exit;
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>


<html>
<head>
    <title>Register</title>
    <link rel="icon" type="image/x-icon" href="favorite.ico">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <script src="/js/bootstrap.bundle.min.js"</script>
    <script src="/js/main.js"></script>
</head>


<body class="d-flex align-items-center py-4 bg-body-tertiary">


<main class="form-signin w-100 m-auto" id="form">
    <form method="post" action="">

        <h1 class="h3 mb-3 fw-normal">Sign up</h1>

        <div class="form-floating">
            <input type="text" class="form-control" name="firstname" id="corner_t" placeholder="firstname">
            <label for="floatingInput">First name</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="lastname" id="center" placeholder="lastname">
            <label for="floatingInput">Last name</label>
        </div>
        <div class="form-floating">
            <input type="number" class="form-control" name="age" id="center" placeholder="age">
            <label for="floatingInput">Age</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="center" placeholder="username">
            <label for="floatingInput">Username</label>
        </div>
        <div class="form-floating">
            <input type="email" name="email" class="form-control" id="center" placeholder="Email">
            <label for="floatingEmail">Email</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="center" placeholder="Password">
            <label for="floatingPassword">Password</label>
        </div>
        <div class="form-floating">
            <input type="password" name="verify_password" class="form-control" id="corner_b" placeholder="Password">
            <label for="floatingPassword">Verify Password</label>
        </div>


        <button class="btn btn-primary w-100 py-2" type="submit" name="submit">Sign up</button>
        <?php require_once __DIR__ . "/../parts/msg.php" ?>
        <p class="mt-5 mb-3 text-body-secondary">Do you have an account? <a href="/auth/login">Sign in</a> or <a
                    href="/">Home</a></p>
    </form>
</main>

</body>

</html>