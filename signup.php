<?php
$conn = new mysqli("localhost", "root", "", "cosmetics_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows > 0){
    echo "User already exists";
    exit();
}
$stmt->close();

// Insert user
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role, phone_number) VALUES (?, ?, ?, 'user', ?)");
$stmt->bind_param("ssss", $name, $email, $password, $phone);

if($stmt->execute()){
    header("Location: login.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>