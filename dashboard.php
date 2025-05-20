<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>
<h2>Welcome Admin: <?php echo $_SESSION['admin']; ?></h2>
<a href="manage_users.php">Manage Users</a><br>
<a href="manage_services.php">Manage Services</a><br>
<a href="manage_appointments.php">Manage Appointments</a><br>
<a href="logout.php">Logout</a>
