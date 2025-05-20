<?php
session_start();
$fullname = $_POST['regUsername'] ?? '';
$email = $_POST['regEmail'] ?? '';
$password = $_POST['regPassword'] ?? '';

// Validate
if (empty($fullname) || empty($email) || empty($password)) {
    die("All fields are required.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// DB connection
$conn = new mysqli("localhost", "root", "", "database1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM login WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Email already registered.");
}
$stmt->close();

// Insert user
$stmt = $conn->prepare("INSERT INTO login (fullname, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $fullname, $email, $hashedPassword);
if ($stmt->execute()) {
    echo "Registration successful! <a href='index.html'>Login Now</a>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
