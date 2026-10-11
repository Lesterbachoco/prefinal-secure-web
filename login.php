<?php
session_start();
require "db.php";

$error = "";
$success = "";

if (isset($_GET["registered"])) {
    $success = "Account created successfully! Please log in.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($username === "" || $password === "") {

        $error = "Please enter your username and password.";

    } else {

        // Find the user
        $stmt = $conn->prepare(
            "SELECT id, username, password
             FROM secure
             WHERE username = ?
             LIMIT 1"
        );

        if (!$stmt) {
            die("Database error: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            // Check password
            if (password_verify($password, $user["password"])) {

                // Create new session ID
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];

                // Login successful
                header("Location: landing.php");
                exit();

            } else {

                $error = "Invalid username or password.";

            }

        } else {

            $error = "Invalid username or password.";

        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign In</title>
<link rel="stylesheet" href="galaxy.css">
</head>

<body>

<div class="sky" aria-hidden="true">
    <div class="milky"></div>
    <div class="stars s1"></div>
    <div class="stars s2"></div>
    <div class="stars s3"></div>
    <div class="comet"></div>
</div>

<main class="card">

    <div class="planet" aria-hidden="true"><i></i></div>

    <h1>Welcome back</h1>
    <p class="subtitle">Sign in to continue.</p>

    <?php if (!empty($error)): ?>
        <div class="error" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div class="success" role="status"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" autocomplete="username" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
        </div>

        <button type="submit">Sign in</button>

    </form>

    <div class="footer">
        Don't have an account?
        <a href="index.php">Create one</a>
    </div>

</main>

</body>
</html>