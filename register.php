<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // ✅ Check password match
    if ($password !== $confirm) {
        echo "<script>alert('Passwords do not match'); window.location.href='login.html';</script>";
        exit();
    }

    // ✅ Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ✅ Check if user exists
    $check = mysqli_prepare($conn, "SELECT id FROM users WHERE email=?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        echo "<script>alert('User already exists'); window.location.href='login.html';</script>";
        exit();
    }

    // ✅ Insert user
    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, phone, email, password) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssss", $name, $phone, $email, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Account created successfully'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Error occurred'); window.location.href='login.html';</script>";
    }
}
?>