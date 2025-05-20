<?php
session_start();
$email = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// DB connection
$conn = new mysqli("localhost", "root", "", "database1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user
$stmt = $conn->prepare("SELECT id, fullname, email, password FROM login WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Invalid email or password");
}
$user = $result->fetch_assoc();

if (password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['fullname'];
    $_SESSION['user_email'] = $user['email'];
    header("Location: about.html");
    exit();
} else {
    die("Invalid email or password");
}
?>
