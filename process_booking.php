<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "database1");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize POST data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$selected_date = $_POST['selected_date'] ?? '';
$time = $_POST['time'] ?? '';
$service = $_POST['service'] ?? '';
$technician = $_POST['technician'] ?? '';
$notes = $_POST['notes'] ?? '';

// Basic validation
if (empty($name) || empty($email) || empty($phone) || empty($selected_date) || empty($time) || empty($service)) {
    die("All required fields must be filled.");
}

// Prepare and insert
$stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, selected_date, time, service, technician, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssss", $name, $email, $phone, $selected_date, $time, $service, $technician, $notes);

if ($stmt->execute()) {
    echo "<h2>Appointment booked successfully!</h2><p><a href='booking.html'>Book another</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
