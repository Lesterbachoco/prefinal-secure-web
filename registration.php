<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $fullname = trim($_POST["fullname"] ?? "");
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";
    $email = trim($_POST["email"] ?? "");
    $age = filter_var($_POST["age"] ?? "", FILTER_VALIDATE_INT);
    $address = trim($_POST["address"] ?? "");

    if (
        $fullname === "" ||
        $username === "" ||
        $password === "" ||
        $confirm_password === "" ||
        $email === "" ||
        $address === "" ||
        $age === false ||
        $age < 1
    ) {
        die("All fields are required.");
    }

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // Check username
    $check = $conn->prepare(
        "SELECT id FROM secure WHERE username = ? LIMIT 1"
    );

    if (!$check) {
        die("Database error: " . $conn->error);
    }

    $check->bind_param("s", $username);
    $check->execute();

    $result = $check->get_result();

    if ($result->num_rows > 0) {
        die("Username already exists.");
    }

    // Hash password
    $hashed_password = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    // Insert account
    $stmt = $conn->prepare(
        "INSERT INTO secure
        (fullname, username, password, email, age, address)
        VALUES (?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssis",
        $fullname,
        $username,
        $hashed_password,
        $email,
        $age,
        $address
    );

    if ($stmt->execute()) {

        // Registration successful
        header("Location: login.php?registered=1");
        exit();

    } else {
        die("Registration failed: " . $stmt->error);
    }

    $stmt->close();
    $check->close();
    $conn->close();
}
?>